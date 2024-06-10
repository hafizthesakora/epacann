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
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Entry</a></li>
                <li><a href="loan_display.php">Party Name</a></li>
                <li class="active">Edit Party</li>
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
                                <a href="party_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Edit Party</h4></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Party name<span>:</span></label>
                                        <div class="col-lg-7">
                                            <input type="text" name="party_name" placeholder="Enter Party Name" value="<?php echo $result->party_name; ?>" class="form-control">     
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Print Name<span>:</span></label>                                                    
                                        <div class="col-lg-7">                                                     
                                            <input type="text" name="print_name" placeholder="Enter Print Name" value="<?php echo $result->print_name; ?>" class="form-control">     
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Mobile<span>:</span></label>                                                    
                                        <div class="col-lg-7">                                                      
                                            <input type="text" name="party_mobile" placeholder="Enter Mobile Number" value="<?php echo $result->party_mobile; ?>" class="form-control validate[required]">                  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Address<span>:</span></label>                                                
                                        <div class="col-lg-7">                                                   
                                            <textarea name="party_address" placeholder="Enter Address" class="form-control" rows="5" ><?php echo $result->party_address; ?></textarea>      
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-5">
                                    <div class="submit-buttons-wrapper">     
                                        <div class="span12">                
                                            <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Submit </button>     
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
</div>   
<script>
    jQuery(document).ready(function () {
        jQuery("#formID").validationEngine();
    });
</script>
