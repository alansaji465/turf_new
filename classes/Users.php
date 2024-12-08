<?php
require_once('../config.php');

Class Users extends DBConnection {
    private $settings;

    public function __construct(){
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    public function save_users(){
        if(!isset($_POST['status']) && $this->settings->userdata('login_type') == 1){
            $_POST['status'] = 1;
        }

        extract($_POST);
        $oid = isset($id) ? $id : null; // Check if $id exists
        $data = '';

        if(isset($oldpassword)){
            if(md5($oldpassword) != $this->settings->userdata('password')){
                return 4;
            }
        }

        $chk = $this->conn->query("SELECT * FROM `users` WHERE username = '{$username}' ".($oid > 0 ? " AND id != '{$oid}' " : ""))->num_rows;
        if($chk > 0){
            return 3;
            exit;
        }

        foreach($_POST as $k => $v){
            if(in_array($k, array('firstname', 'email', 'password'))){
                if(!empty($data)) $data .= " , ";
                $data .= " {$k} = '{$v}' ";
            }
        }

        if(!empty($password)){
            $password = md5($password);
            if(!empty($data)) $data .=" , ";
            $data .= " `password` = '{$password}' ";
        }

        if(empty($id)){
            $qry = $this->conn->query("INSERT INTO users SET {$data}");
            if($qry){
                $id = $this->conn->insert_id;
                $this->settings->set_flashdata('success','User Details successfully saved.');
                $resp['status'] = 1;
            } else {
                $resp['status'] = 2;
            }
        } else {
            $qry = $this->conn->query("UPDATE users SET $data WHERE id = {$id}");
            if($qry){
                $this->settings->set_flashdata('success','User Details successfully updated.');
                if($id == $this->settings->userdata('id')){
                    foreach($_POST as $k => $v){
                        if($k != 'id'){
                            if(!empty($data)) $data .=" , ";
                            $this->settings->set_userdata($k, $v);
                        }
                    }
                }
                $resp['status'] = 1;
            } else {
                $resp['status'] = 2;
            }
        }

        // Image upload handling
        if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
            $fname = 'uploads/avatar-' . $id . '.png';
            $dir_path = base_app . $fname;
            $upload = $_FILES['img']['tmp_name'];
            $type = mime_content_type($upload);
            $allowed = array('image/png','image/jpeg');
            if(!in_array($type, $allowed)){
                $resp['msg'] .= " But Image failed to upload due to invalid file type.";
            } else {
                $new_height = 200;
                $new_width = 200;

                list($width, $height) = getimagesize($upload);
                $t_image = imagecreatetruecolor($new_width, $new_height);
                imagealphablending($t_image, false);
                imagesavealpha($t_image, true);
                $gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
                imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                if($gdImg){
                    if(is_file($dir_path)) unlink($dir_path);
                    $uploaded_img = imagepng($t_image, $dir_path);
                    imagedestroy($gdImg);
                    imagedestroy($t_image);
                } else {
                    $resp['msg'] .= " But Image failed to upload due to unknown reason.";
                }
            }
            if(isset($uploaded_img)){
                $this->conn->query("UPDATE users SET `avatar` = CONCAT('{$fname}', '?v=', unix_timestamp(CURRENT_TIMESTAMP)) WHERE id = '{$id}' ");
                if($id == $this->settings->userdata('id')){
                    $this->settings->set_userdata('avatar', $fname);
                }
            }
        }

        if(isset($resp['msg']))
            $this->settings->set_flashdata('success', $resp['msg']);

        return $resp['status'];
    }

    public function delete_users(){
        extract($_POST);
        $avatar = $this->conn->query("SELECT avatar FROM users WHERE id = '{$id}'")->fetch_array()['avatar'];
        $qry = $this->conn->query("DELETE FROM users WHERE id = $id");
        if($qry){
            $this->settings->set_flashdata('success','User Details successfully deleted.');
            if(is_file(base_app . $avatar))
                unlink(base_app . $avatar);
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'failed';
        }
        return json_encode($resp);
    }

    public function save_client() {
        if (!empty($_POST['password'])) {
            $_POST['password'] = md5($_POST['password']);
        } else {
            unset($_POST['password']);
        }
    
        if (isset($_POST['oldpassword'])) {
            if ($this->settings->userdata('id') > 0 && $this->settings->userdata('login_type') == 2) {
                $get = $this->conn->query("SELECT * FROM `client_list` WHERE id = '{$this->settings->userdata('id')}'");
                $res = $get->fetch_array();
                if ($res['password'] != md5($_POST['oldpassword'])) {
                    return json_encode([
                        'status' => 'failed',
                        'msg' => 'Current Password is incorrect.'
                    ]);
                }
            }
            unset($_POST['oldpassword']);
        }
    
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (in_array($k, ['firstname', 'email', 'password'])) {
                if (!empty($data)) $data .= ", ";
                $data .= " `{$k}` = '{$v}' ";
            }
        }
    
        $check = $this->conn->query("SELECT * FROM `client_list` WHERE email = '{$email}' AND delete_flag = '0' " . 
            (is_numeric($id) && $id > 0 ? " AND id != '{$id}'" : "") . " ")->num_rows;
        if ($check > 0) {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Email already exists in the database.';
        } else {
            if (empty($id)) {
                $sql = "INSERT INTO `client_list` SET $data";
            } else {
                $sql = "UPDATE `client_list` SET $data WHERE id = '{$id}'";
            }
            
            $save = $this->conn->query($sql);
            if ($save) {
                $resp['status'] = 'success';
                $uid = empty($id) ? $this->conn->insert_id : $id;
                if (empty($id)) {
                    $resp['msg'] = "Account created successfully. Redirecting to Login page...";
                    // Set flash message for new account creation
                    $_SESSION['success'] = $resp['msg']; // Set session success message
                } else {
                    $resp['msg'] = "Account details updated successfully.";
                }
            } else {
                $resp['status'] = 'failed';
                $resp['msg'] = empty($id) ? "Failed to create account." : "Failed to update account details.";
            }
            
        }
    
        return json_encode($resp);
    }
      
	
	

    public function delete_client(){
        extract($_POST);
        $del = $this->conn->query("UPDATE `client_list` SET delete_flag = 1 WHERE id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $resp['msg'] = 'Client Account has been deleted successfully.';
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = "Client Account has failed to delete";
        }
        if($resp['status'] == 'success')
            $this->settings->set_flashdata('success', $resp['msg']);
        return json_encode($resp);
    }

}

$users = new Users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'save':
        echo $users->save_users();
    break;
    case 'delete':
        echo $users->delete_users();
    break;
    case 'save_client':
        echo $users->save_client();
    break;
    case 'delete_client':
        echo $users->delete_client();
    break;
    default:
    break;
}
?>
