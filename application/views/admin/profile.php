<?php
$check = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->row();
//print_r($check->profile);exit;
//$docid = $this->session->userdata('admin_id');
?>
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href=""><i class="icon-home2 position-left"></i>Admin</a></li>
                <li class="active">Edit Profile</li>
            </ul>
        </div>
    </div>
  <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                  <div class="trans-table" style="margin:unset">
                        <!-- BEGIN: Subheader -->            
   <!--<div class="m-subheader ">
      <div class="d-flex align-items-center">
         <div class="mr-auto">
            <h3 class="m-subheader__title ">                    
                My Profile                    
            </h3>
         </div>
      </div>
   </div>
   <!-- END: Subheader            
   <div class="m-content">
      <div class="row">
         <div class="col-lg-3">
            <div class="m-portlet  ">
               <div class="m-portlet__body">
                  <div class="m-card-profile">
                     <div class="m-card-profile__pic">
                        <div class="m-card-profile__pic-wrapper">                                    
                            <img src="<?php// echo base_url(); ?>../uploads<?php //echo $result->profile; ?>" class="img-circle" width="100px"/>                                        </div>
                     </div>
                     <div class="m-card-profile__details">                                        
                         <span class="m-card-profile__name">                                        
    <?php //echo $result->user_name; ?>                                   
                         </span>                                     
                         <a href="" class="m-card-profile__email m-link">                                   
         <?php //echo $result->email_id; ?>                                   
                         </a>                                 
                     </div>
                  </div>
               </div>
            </div>
         </div>-->
            <div class="m-portlet m-portlet--tabs ">
               <div class="m-portlet__head">
                  <div class="m-portlet__head-tools">
                     <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                        <li class="nav-item m-tabs__item active">                                    
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">                                               <i class="flaticon-share m--hide"></i>                                                Update Profile                                            </a>                                        </li>
                        <li class="nav-item m-tabs__item">                                        
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">                                                <i class="flaticon-share m--hide"></i>                                                Change Password                                           </a>                                        </li>
                     </ul>
                  </div>
               </div>
               <div class="tab-content clearfix">
                  <div class="tab-pane active clearfix" id="m_user_profile_tab_1">
                      <div class="container">
                     <form class="m-form m-form--fit m-form--label-align-right validation-form" method="post" autocomplete="off" action="<?php echo base_url('admin/profile'); ?>" enctype="multipart/form-data">
                        <div class="m-portlet__body">
                           <div class="form-group m-form__group">
                              <label class="col-3 col-form-label">Admin Name</label>                                                
                              <div class="col-5">                                                  
                                  <input class="form-control m-input validate[required]" name="user_name" type="text" value="<?php echo $result->user_name; ?>" >           
                              </div>
                           </div>
                           <div class="form-group m-form__group">
                              <label class="col-3 col-form-label">Email Address</label>                                                
                              <div class="col-5">                                                   
                                  <input class="form-control m-input validate[required,custom[email]]" type="text" name="email_id" value="<?php echo $result->email_id; ?>">                                         
                              </div>
                           </div>
                           <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
                           <div class="form-group m-form__group">
                              <label class="col-3 col-form-label">Profile Image</label>                                               
                              <div class="col-5">
                                 <div class="custom-file">                                                       
                                     <input type="file" name="profile" id="image" class="custom-file-input validate[custom[image]]">      
                                     <label class="custom-file-label" for="image"></label>                                         
                                <p>(Recommended image size 110 X 110)</p> 
                                </div> 
                              </div>
                              <div class="form-group m-form__group">                                           
                                <img src="<?php echo base_url(); ?>uploads/<?php echo $result->profile; ?>" width="100px"/>       
                              </div>
                           </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                           <div class="m-form__actions">
                              <div class="">
                                 <div class="col-2"></div>
                                 <div class="col-5">                                                      
                                     <button type="submit" class="button-style-2 profile-save">      
                                         Save changes                                                     
                                     </button>                                                  
                                     &nbsp;&nbsp;                                              
                                     <button type="reset" class="button-style-2 profile-save" onclick="window.history.back();">               
                                         Cancel                                                     
                                     </button>                                                
                                 </div>
                              </div>
                           </div>
                         </div>
                     </form>
                  </div>
                  </div>
                  <div class="tab-pane clearfix" id="m_user_profile_tab_2">
                    <div class="container">
                      <form class="m-form m-form--fit m-form--label-align-right validation-form" method="post" autocomplete="off" action="<?php echo base_url('admin/changepassword'); ?>">
                        <div class="m-portlet__body">
                           <div class="form-group m-form__group">
                              <label class="col-3 col-form-label">                                                 
                                  Current Password                                                </label>                                                
                              <div class="col-5">                          
                                  <input class="form-control m-input validate[required]" type="password" name="oldpassword"/>                                                </div>
                           </div>
                           <div class="form-group m-form__group">
                              <label class="col-3 col-form-label">                                                
                                  New Password                                                </label>                                                
                              <div class="col-5">                    
                                  <input class="form-control m-input validate[required,minSize[6]]" type="password" name="password">                                                </div>
                           </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                           <div class="m-form__actions">
                              <div class="">
                                 <div class="col-2"></div>
                                 <div class="col-5">       
                                     <button type="submit" class="button-style-2 profile-save">                                                            Save changes                                                        </button>                                                      &nbsp;&nbsp;                                                        <button type="reset" class="button-style-2 profile-save">                                                            Cancel                                                        </button>                                                    </div>
                              </div>
                           </div>
                        </div>
                     </form>
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
    </div>
</div>
</div>
<script>      
    $('#m_aside_left_minimize_toggle').click(function () {    
    if ($('.m-menu__item--submenu').attr('data-menu-submenu-toggle') == 'hover') {       
    $('.m-menu__item--submenu').attr('data-menu-submenu-toggle', 'click');       
    } else {    
    $('.m-menu__item--submenu').attr('data-menu-submenu-toggle', 'hover');     
    }        
    });       
     <?php if (isset($_GET['tab']) && $_GET['tab'] == 'changepassword') { ?>       
    $('a[href="#m_user_profile_tab_2"]').tab('show')    
        <?php }   
        ?>     
</script>        
<style>       
    .m-card-profile .m-card-profile__details .m-card-profile__name {    
        color: #1b1c1e;       
        word-wrap: break-word;     
    }
    .trans-table {
    border: unset !important;
    }
</style>
