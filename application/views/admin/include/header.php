<?php
$check = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->row();
$docid = $this->session->userdata('admin_id');
?>
  <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="">
                <span>Epacann Management System</span>
            </a>
            <ul class="nav navbar-nav pull-right visible-xs-block">
                <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
        </div>
        <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a class="sidebar-control sidebar-main-toggle hidden-xs">
                        <i class="icon-paragraph-justify3"></i>
                    </a>
                </li>
            </ul>
            <!--//sasi - db backup works --<a href="database_backup" style="color:#fff;font-size:15px;border: 1px solid #fff;
    padding: 5px;
    position: relative;
    top: 10px;">Database Backup</a>-->
                <a href="#" style="color:#fff;font-size:15px;border: 1px solid #fff;
    padding: 5px;
    position: relative;
    top: 10px;">Database Backup</a>
          <a href="settings" style="position: absolute;right: 0;padding: 3px;"><i class="fa fa-cog" aria-hidden="true" style="position: absolute;right: 0;padding: 11px;font-size: 22px;color:white"></i></a>
        </div>
    </div>
<!-- Main sidebar -->
    
