<?php
require_once('../config.php');

class Master extends DBConnection {
    private $settings;

    public function __construct(){
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    function capture_err(){
        if(!$this->conn->error)
            return false;
        else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
            return json_encode($resp);
            exit;
        }
    }

    // Removing save_category and delete_category

    function save_facility(){
        $_POST['description'] = html_entity_decode($_POST['description']);
        if(empty($_POST['id'])){
            $prefix = date('Ym-');
            $code = sprintf("%'.05d",1);
            while(true){
                $check = $this->conn->query("SELECT * FROM `turfs` where turf_code = '{$prefix}{$code}'")->num_rows;
                if($check > 0){
                    $code = sprintf("%'.05d",ceil($code) + 1);
                }else{
                    break;
                }
            }
            $_POST['turf_code'] = $prefix.$code;
        }

        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }

        // Removed category checks, replaced with turf name checks
        if(isset($name)){
            $check = $this->conn->query("SELECT * FROM `turfs` where `turf_name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
            if($this->capture_err())
                return $this->capture_err();
            if($check > 0){
                $resp['status'] = 'failed';
                $resp['msg'] = " Facility (Turf) already exists.";
                return json_encode($resp);
                exit;
            }
        }

        if(empty($id)){
            $sql = "INSERT INTO `turfs` set {$data} ";
            $save = $this->conn->query($sql);
        }else{
            $sql = "UPDATE `turfs` set {$data} where id = '{$id}' ";
            $save = $this->conn->query($sql);
        }

        if($save){
            $resp['status'] = 'success';
            $cid = empty($id) ? $this->conn->insert_id : $id;
            $resp['id'] = $cid;
            if(empty($id))
                $resp['msg'] = " New facility (turf) successfully saved.";
            else
                $resp['msg'] = " Facility (turf) successfully updated.";

            // Handle image upload
            if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
                if(!is_dir(base_app."uploads/facility/"))
                    mkdir(base_app."uploads/facility/");
                $fname = 'uploads/facility/'.$cid.'.png';
                $dir_path = base_app . $fname;
                $upload = $_FILES['img']['tmp_name'];
                $type = mime_content_type($upload);
                $allowed = array('image/png', 'image/jpeg');
                if(!in_array($type, $allowed)){
                    $resp['msg'] .= " But Image failed to upload due to invalid file type.";
                }else{
                    list($width, $height) = getimagesize($upload);
                    $t_image = imagecreatetruecolor($width, $height);
                    imagealphablending($t_image, false);
                    imagesavealpha($t_image, true);
                    $gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
                    imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $width, $height, $width, $height);
                    if($gdImg){
                        if(is_file($dir_path))
                            unlink($dir_path);
                        $uploaded_img = imagepng($t_image, $dir_path);
                        imagedestroy($gdImg);
                        imagedestroy($t_image);
                    }else{
                        $resp['msg'] .= " But Image failed to upload due to unknown reason.";
                    }
                }
                if(isset($uploaded_img)){
                    $this->conn->query("UPDATE turfs set `image_path` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$cid}' ");
                }
            }
        }else{
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->error."[{$sql}]";
        }

        if(isset($resp['msg']) && $resp['status'] == 'success'){
            $this->settings->set_flashdata('success', $resp['msg']);
        }
        return json_encode($resp);
    }

    function delete_facility(){
        extract($_POST);
        $del = $this->conn->query("UPDATE `turfs` set `delete_flag` = 1  where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success', " Facility (Turf) successfully deleted.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    function save_booking(){
        if(empty($_POST['id'])){
            $prefix = date('Ym-');
            $code = sprintf("%'.05d",1);
            while(true){
                $check = $this->conn->query("SELECT * FROM `booking_list` where ref_code = '{$prefix}{$code}'")->num_rows;
                if($check > 0){
                    $code = sprintf("%'.05d",ceil($code) + 1);
                }else{
                    break;
                }
            }
            $_POST['client_id'] = $this->settings->userdata('id');
            $_POST['ref_code'] = $prefix.$code;
        }

        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!empty($data)) $data .=",";
                $data .= " `{$k}`='{$v}' ";
            }
        }

        $check = $this->conn->query("SELECT * FROM `booking_list` where  turf_id = '{$turf_id}' and ('{$date_from}' BETWEEN date(date_from) and date(date_to) or '{$date_to}' BETWEEN date(date_from) and date(date_to)) and status = 1 ")->num_rows;
        if($check > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = 'Facility is not available on the selected dates.';
            return json_encode($resp);
            exit;
        }

        if(empty($id)){
            $sql = "INSERT INTO `booking_list` set {$data} ";
            $save = $this->conn->query($sql);
        }else{
            $sql = "UPDATE `booking_list` set {$data} where id = '{$id}' ";
            $save = $this->conn->query($sql);
        }

        if($save){
            $resp['status'] = 'success';
            if(empty($id))
                $this->settings->set_flashdata('success', " Facility has been booked successfully.");
            else
                $this->settings->set_flashdata('success', " Booking successfully updated.");
        }else{
            $resp['status'] = 'failed';
            $resp['err'] = $this->conn->error."[{$sql}]";
        }
        return json_encode($resp);
    }

    function delete_booking(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `booking_list` where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success', " Booking successfully deleted.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    function update_booking_status(){
        extract($_POST);
        $update = $this->conn->query("UPDATE `booking_list` set `status` = '{$status}' where id = '{$id}' ");
        if($update){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success', " Booking status successfully updated.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    public function toggle_status(){
        $id = $_POST['id'];
        $new_status = $_POST['status'];
        $update = $this->conn->query("UPDATE `turfs` SET `status` = '{$new_status}' WHERE `turf_id` = '{$id}'");
        if($update){
            return ['status' => 'success'];
        } else {
            return ['status' => 'failed', 'error' => $this->conn->error];
        }
    }
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();

switch ($action) {
    case 'save_facility':
        echo $Master->save_facility();
        break;
    case 'delete_facility':
        echo $Master->delete_facility();
        break;
    case 'save_booking':
        echo $Master->save_booking();
        break;
    case 'delete_booking':
        echo $Master->delete_booking();
        break;
    case 'update_booking_status':
        echo $Master->update_booking_status();
        break;
    case 'toggle_status':
        echo json_encode($Master->toggle_status());
        break;
    default:
        break;
}
?>
