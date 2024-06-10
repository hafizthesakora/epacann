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
               
                <li class="active">Settings</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal form-validation" id="formID" action="#" method="post" autocomplete="off">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <fieldset>
                     
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Settings</h4></div>
                            <div class="row">
                                <div class="col-md-6">
<!--                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Add Less<span>:</span></label>                                                    
                                        <div class="col-lg-7">                                                   
                                            <input type="text" name="addless" class="form-control">                                                 </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Commision Paid to Bank<span>:</span></label>                                                    
                                        <div class="col-lg-7">                                                     
                                            <input type="text" name="commision"class="form-control">                                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Loans<span>:</span></label>                                                    
                                        <div class="col-lg-7">                                                     
                                            <input type="text" name="loans" class="form-control">                                                    </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-lg-4 control-label">Cash<span>:</span></label>                                                    
                                        <div class="col-lg-7">                                                     
                                            <input type="text" name="cash" class="form-control">                                                    </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Year End Process- Credit<span>:</span></label>                                                    
                                        <div class="col-lg-7">                                                   
                                            <input type="text" name="credit" class="form-control">                                                 </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Year End Process- Debit <span>:</span></label>                                                    
                                        <div class="col-lg-7">                                                     
                                            <input type="text" name="debit"class="form-control">                                                    </div>
                                    </div>
                                    
                                
                                 <div class="submit-buttons-wrapper">     
                                    <div class="span12">                
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
        <!-- /2 columns form -->                    <!-- Footer -->                    
    </div>
    <!-- /main content -->     
</div>
<script>
    jQuery(document).ready(function () {
        jQuery("#formID").validationEngine();
    });
</script>
