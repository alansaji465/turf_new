<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary bg-gradient-dark text-light elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="<?php echo base_url ?>admin" class="brand-link bg-gradient-primary text-sm text-light">
        <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3 bg-gradient-light" style="opacity: .8;width: 1.6rem;height: 1.6rem;max-height: unset">
        <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
        <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 0px;"></div>
        <div>
            <div>
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <!-- Sidebar Menu -->
                    <nav class="mt-4">
                        <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item dropdown">
                                <a href="./" class="nav-link nav-home" style="margin-top: 15px;">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li> 
                            <!-- Manage Turfs -->
                            <li class="nav-item dropdown">
                                <a href="<?php echo base_url ?>admin/?page=turfs" class="nav-link nav-manage_turfs">
                                    <i class="nav-icon fas fa-door-closed"></i>
                                    <p>Manage Turfs</p>
                                </a>
                            </li>
                            <!-- Registered Clients -->
                            <li class="nav-item dropdown">
                                <a href="<?php echo base_url ?>admin/?page=clients" class="nav-link nav-clients">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Manage Clients</p>
                                </a>
                            </li>
                            <!-- Booking List -->
                            <li class="nav-item dropdown">
                                <a href="<?php echo base_url ?>admin/?page=bookings" class="nav-link nav-bookings">
                                    <i class="nav-icon fas fa-tasks"></i>
                                    <p>Booking List</p>
                                </a>
                            </li>
                            <?php if($_settings->userdata('type') == 1): ?>
                                <!-- Staffs (formerly User List) -->
                                <li class="nav-item dropdown">
                                    <a href="<?php echo base_url ?>admin/?page=staffs" class="nav-link nav-staffs">
                                        <i class="nav-icon fas fa-users-cog"></i>
                                        <p>Manage Staffs</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.sidebar -->
</aside>

<script>
    $(document).ready(function(){
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
        var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
        page = page.replace('/',"_");
        if(s!='')
            page = page+'_'+s;

        if($('.nav-link.nav-'+page).length > 0){
            $('.nav-link.nav-'+page).addClass('active')
            if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
                $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
                $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
            }
            if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
                $('.nav-link.nav-'+page).parent().addClass('menu-open')
            }
        }
    })
</script>
