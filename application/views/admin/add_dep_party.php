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
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Master</a></li>
                <li><a href="dep_party_display">Dep Party Name</a></li>
                <li class="active">Add Dep Party</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Horizontal form options -->
        <!-- /fieldset legend -->
        <!-- 2 columns form -->
          <form class="form-horizontal form-validation" id="formID" action="#" method="post" autocomplete="off">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a href="dep_party_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Add Dep Party</h4></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Party Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="party_name" id="party_name" placeholder="Enter Party Name" class="form-control validate[required]">
                                        </div>
                                    </div>
<!--                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Phone (Off)</label>
                                        <div class="col-lg-7">
                                            <input type="text" name="off_phone" placeholder="Enter Phone (Off)" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Phone (Res)</label>
                                        <div class="col-lg-7">
                                            <input type="text" name="res_phone" placeholder="Enter Phone (Res)" class="form-control">
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Mobile</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="party_mobile" placeholder="Enter Mobile Number" class="form-control ">
                                        </div>
                                    </div>
 <div class="form-group">
                                        <label class="col-lg-4 control-label">Address</label>
                                        <div class="col-lg-8 ">
                                            <textarea name="party_address" placeholder="Enter Address" class="form-control validate[required]" rows="5" ></textarea>
                                        </div>
                                    </div>
<!--                                      <div class="form-group">
                                        <label class="col-lg-4 control-label">Reference</label>
                                        <div class="col-lg-7">
                                            <select class="form-control validate[required] input-height" name="reference">
                                                <option value="">Select Reference Name...</option>  
                                                <?php
                                                foreach ($refnameresults as $result) {
                                                    ?>
                                                    <option value="<?php echo $result->reference_name; ?>"><?php echo $result->reference_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>-->
                                                            
<!--                                     <div class="form-group">
                                        <label class="col-lg-4 control-label">Area</label>
                                        <div class="col-lg-8">
                                            <select class="form-control validate[required] input-height" name="area">
                                                <option value="">Select Area...</option>  
                                                <?php
                                                foreach ($arearesults as $result) {
                                                    ?>
                                                    <option value="<?php echo $result->area_name; ?>"><?php echo $result->area_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>-->
                                     
                               
                                    <!--<div class="form-group">
                                   <label class="col-lg-4 control-label">Gender<span>:</span></label>
                                   <div class="col-lg-8">
                                       <select class="select-box validate[required]" name="gender" >
                                           <option value="">Select ...</option>
                                           <option value="Male">Male</option>
                                           <option value="Female">Female</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group">
                                  <label class="col-lg-4 control-label">Age<span>:</span></label>
                                   <div class="col-lg-8">
                                       <input type="text" name="age" data-required="1" placeholder="Enter your age" class="form-control input-height validate[required]" /> </div>
                               </div>-->
                            
                            <div class="submit-buttons-wrapper row-fluid">     
                                <div class="span12 align-center">                
                                    <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Submit </button>     
                                </div>                               
                            </div>
                                </div>
                        </div>
                            </div>
                    </fieldset>
                </div>
            </div>
        </form>
        <!-- /2 columns form -->
    </div>
    <!-- /content area -->
</div>
<!-- /main content -->
<script>
    jQuery(document).ready(function () {
    jQuery("#formID").validationEngine();
    });
</script>
<script>
    $('#party_name').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/check_depparty_name')?>",
            data: 'party_name=' + $(this).val(),
            dataType: "json",
            success: function (data) {
               if( data.party_name  != ''){
                  alert("Party Name already exist !");
                  }
             }
        });
    });
</script>