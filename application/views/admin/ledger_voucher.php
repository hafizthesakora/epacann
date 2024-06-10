  <div class="content-wrapper">
    <!-- Page header -->                
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>                            </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Accounts</a></li>
                <li>Ledger</li>
                <li class="active">Ledger Account</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal form-validation" id="formID" action="ledger_voucher_display" method="get" autocomplete="off">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <fieldset>
                      
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Ledger Account</h4></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Name<span>:</span></label>
                                        <div class="col-lg-7">
                                           <select class="form-control chosen validate[required] input-height" name="name" id="name">
                                                <option value="">Choose Name...</option>  
                                                <?php
                                               // foreach ($nameresults as $result) {
                                                    ?>
                                                    <!--<option value="<?php echo $result->group_name; ?>"><?php echo $result->group_name; ?></option>-->
                                                <?php //} 
                                                     foreach ($nl_results as $nlresult) {
                                                    ?>
                                                    <option value="<?php echo $nlresult->ledger_id; ?>"><?php echo $nlresult->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="submit-buttons-wrapper">     
                        <div class="span12">                
                            <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Submit </button>     
                        </div>                               
                    </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
        <!-- /2 columns form -->                    <!-- Footer -->                    
    </div>
    <!-- /main content -->     
</div>
<script>
    jQuery(document).ready(function () {
    jQuery("#formID").validationEngine();
    });
</script>