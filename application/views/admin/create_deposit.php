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
                <li><a href=""><i class="icon-home2 position-left"></i>Entry</a></li>
                <li>Deposit</li>
                <li class="active">Deposit Creation</li>
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
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a href="deposit_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Deposit Creation</h4></div>
                            <div class="row">        
                                <div class="col-md-6">    
                                    <div class="form-group">   
                                        <label class="col-lg-4 control-label">Dep No</label>  
                                        <div class="col-lg-8">         
                                            <input type="text" name="dep_no" id="dep_no" class="form-control validate[required]" value="<?php if (!empty($idresults->dep_no)) { echo $idresults->dep_no + 1; } else { $count=0; echo $count+1; } ?>" >      
                                        </div>          
                                    </div>                   
                                     <div class="form-group">
                                        <label class="col-lg-4 control-label">Dep Date</label>                                                    
                                        <div class="col-lg-8"> 
                                            <div class="class input-group date">
                                                <input name="dep_date" id="dep_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd"  value="<?php echo date('Y-m-d') ?>" placeholder="Loan Date" type="text"  >                                                    </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Party name</label>                                                    
                                        <div class="col-lg-8">  
                                           <select class="form-control chosen validate[required] input-height" name="party_name" style="color: #999;">
                                                <option value="">Select Party Name...</option>  
                                                <?php
                                                foreach ($partyresults as $result) {
                                                    ?>
                                                    <option value="<?php echo $result->dep_party_id; ?>"><?php echo $result->party_name; ?></option>
                                                <?php } ?>
                                            </select>  
                                        </div>
                                    </div>                                       
                                    <div class="form-group">                        
                                        <label class="col-lg-4 control-label">Dep Amount (GHS)
                                            </label>     
                                        <div class="col-lg-8">                         
                                            <input type="text" name="dep_amount" id="dep_amount" id="loan" placeholder="" class="form-control validate[required]">        
                                        </div>                                                
                                    </div>                                             
                                    <div class="form-group">                             
                                        <label class="col-lg-4 control-label">Interest (%)</label>       
                                        <div class="col-lg-8">                                       
                                            <div class="row">                                     
                                                <div class="col-md-4 col-xs-6">                         
                                                    <input type="text"  name="interest_per" id="interest_per" class="form-control validate[required]">      
                                                </div>                                            
                                                <div class="col-md-8 col-xs-6">                             
                                                    <input type="text" name="interest" id="interest" class="form-control">    
                                                </div>                                     
                                            </div>                                        
                                        </div>                                              
                                    </div>                                                 
                                    <div class="form-group">                                        
                                        <label class="col-lg-4 control-label">Pay From</label> 
                                        <div class="col-lg-8">                                 
                                            <input type="text" name="pay_from" placeholder="" value="CASH" class="form-control">  
                                        </div>                                               
                                    </div>                                             
                                    <div class="form-group">                               
                                        <label class="col-lg-4 control-label">Remarks</label>         
                                        <div class="col-lg-8">                               
                                            <input type="text" name="remarks" placeholder="" class="form-control">              
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
<!-- /main content -->
<script>
    jQuery(function () {
    $("#dep_amount, #interest_per").on("keydown keyup", sum);
    function sum() {
    var calc =(Number($("#dep_amount").val()) *  Number($("#interest_per").val()) * 30) / 36000;
    calc = parseFloat(calc).toFixed(2);
    $("#interest").val(calc);
    }
    });
</script>
<script>
    jQuery(document).ready(function () {
        jQuery("#formID").validationEngine();
    });
</script>
<script>
    $('#dep_no').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/check_depno')?>",
            data: 'dep_no=' + $(this).val(),
            dataType: "json",
            success: function (data) {
               if( data.dep_no  != ''){
                  alert("Deposit number already exist !");
                  }
             }
        });
    });
</script>

