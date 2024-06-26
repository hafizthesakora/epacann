<?php
$date = date('Y-m-d');
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
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a> <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a> <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a> </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href=""><i class="icon-home2 position-left"></i>Features</a></li>
                <li class="active">User Creation</li>
            </ul>
        </div>
    </div>
    <!-- /page header --> <!-- Content area --> 
    <div class="content">
        <!-- Horizontal form options --> <!-- /fieldset legend --> <!-- 2 columns form --> 
        <form class="form-horizontal form-validation" id="formID" action="#" method="post" autocomplete="off">
            <div class="panel panel-flat loan-panel">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a href="user_display"><span class="trans-icons-3"></span>Back</a> 
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Add User</h4></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">User Name</label> 
                                        <div class="col-lg-4">
                                            <input type="text" name="user_name" class="form-control validate[required]"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">User Type</label> 
                                        <div class="col-lg-4">
                                            <select class="form-control" name="user_type">
                                                <option value="User">User</option>
                                                <option value="Super User">Super User</option>
                                                <option value="Administrator">Administrator</option>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Password</label> 
                                        <div class="col-lg-4">
                                            <input type="password" name="password" class="form-control validate[required]" id="txtNewPassword"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Repeat</label> 
                                        <div class="col-lg-4">
                                            <input type="password" name="repeat" class="form-control validate[required]" id="txtConfirmPassword"> 
                                        </div><div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Days</label> 
                                        <div class="col-lg-4">
                                            <input type="text" name="days" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Login Reset</label> 
                                        <div class="col-lg-4">
                                            <select class="form-control" name="login_reset">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select> 
                                        </div>
                                    </div>                                             
                                </div>   
                            </div>                                         
                            <div class="submit-buttons-wrapper row-fluid">     
                                <div class="span12 align-center">                
                                    <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Submit </button>     
                                </div>                               
                            </div>                                
                        </div>  
                    </fieldset>              
                </div>   
            </div>                   
        </form>                                 
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery("#formID").validationEngine();
    });
</script>
<script>
function checkPasswordMatch() {
    var password = $("#txtNewPassword").val();
    var confirmPassword = $("#txtConfirmPassword").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    else
        $("#divCheckPasswordMatch").html("Passwords match.");
}

$(document).ready(function () {
   $("#txtConfirmPassword").keyup(checkPasswordMatch);
});
</script>

