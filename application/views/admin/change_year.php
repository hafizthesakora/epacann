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
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>                            </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href=""><i class="icon-home2 position-left"></i>Features</a></li>
                <li>Financial Year</li>
                <li class="active">Change Year</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal form-validation" id="formID" action="#" method="post">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                   
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Year End Process</h4></div>
                            <div class="row">        
                                <div class="col-md-6">    
                                    <div class="form-group">   
                                        <label class="col-lg-4 control-label">Current Year</label>  
                                        <div class="col-lg-8">         
                                            <input type="text" name="curent_year" id="curent_year" class="form-control validate[required]">       
                                        </div>          
                                    </div>                   
                                     <div class="form-group">
                                        <label class="col-lg-4 control-label">Change Year To</label>                                                    
                                        <div class="col-lg-4"> 
                                            <div class="class input-group date">
                                                <input name="change_year" id="change_year" class="form-control validate[required]" data-date-format="yyyy-mm-dd" placeholder="From" type="text"  >       
                                            </div>
                                        </div>
                                        <div class="col-lg-4"> 
                                            <div class="class input-group date">
                                                <input name="change_year" id="change_year" class="form-control validate[required]" data-date-format="yyyy-mm-dd" placeholder="To" type="text"  >       
                                            </div>
                                        </div>
                                    </div>
                                                                   
                            <div class="submit-buttons-wrapper row">     
                                <div class="span12 align-center">                
                                    <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Ok </button>     
                                </div>                               
                            </div>                                
                        </div>   </div> 
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

