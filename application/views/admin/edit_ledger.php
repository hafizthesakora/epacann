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
                <li><a href="ledger_display">Ledger</a></li>
                <li class="active">Edit Ledger</li>
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
                                <a href="ledger_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Edit Ledger</h4></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Name<span>:</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" name="name" placeholder="Enter Name" value="<?php echo $result->name; ?>" id="name" class="form-control validate[required]">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Print Name<span>:</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" name="print_name" id="copy" class="form-control" value="<?php echo $result->print_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Alias Name<span>:</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" name="alias_name" placeholder="Enter Alias Name" value="<?php echo $result->alias_name; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Under<span>:</span></label>
                                        <div class="col-lg-8">
                                           <select class="form-control chosen input-height validate[required]" name="under">
                                                <option value="">Select...</option>                                 
                                                <option selected="selected" value="<?php echo $result->under; ?>"><?php echo $result->under; ?></option>
                                                <?php
                                                foreach ($nameresults as $results) {
                                                 if($results->name != $result->under){?>
                                                    <option  value="<?php echo $results->name; ?>"><?php echo $results->name; ?></option>
                                                <?php } ?>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                        
                                    </div>
<!--                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Opening Balance<span>:</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" name="opening_balance" value="<?php echo $result->opening_balance; ?>" placeholder="" class="form-control validate[required]">
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Area<span>:</span></label>
                                        <div class="col-lg-8">
                                           <select class="form-control input-height" name="area">
                                                <option value="">Select Area...</option>  
                                                <option selected="selected" value="<?php echo $result->area; ?>"><?php echo $result->area; ?></option>
                                                <?php
                                                foreach ($arearesults as $result) {
                                                  if($result->area_name != $result->area){?>  
                                                    <option value="<?php echo $result->area_name; ?>"><?php echo $result->area_name; ?></option>
                                                <?php } } ?>
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
$(document).ready(function(){
    $("#name").change(function(){
        var name = $("#name").val();
        $("#copy").val(name);
    });
});
</script>