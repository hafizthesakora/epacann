<div class="content-wrapper">
    <!-- Page header -->                
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group"> 
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>                            
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href=""><i class="icon-home2 position-left"></i>Entry</a></li>
                <li>Personal Loan</li>
                <li class="active">Edit Personal Loan</li>
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
                                <a href="ploan_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Edit Personal Loan</h4></div>
                            <div class="row">                                 
                                <div class="col-md-6">                             
                                    <div class="form-group">                             
                                        <label class="col-lg-4 control-label">Loan No</label>     
                                        <div class="col-lg-8">                                             
                                            <input type="text" name="loan_no" id="loan_no" class="form-control validate[required]" value="<?php echo $result->loan_no; ?>">          
                                        </div>                                            
                                    </div>                                              
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Loan Date</label>                                                    
                                        <div class="col-lg-8"> 
                                            <div class="class input-group date">
                                                <input name="loan_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd"  value="<?php echo date('Y-m-d', strtotime($result->loan_date)); ?>" type="text"  >                                                    </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Party name</label>                                                    
                                        <div class="col-lg-8">  
                                            <select class="form-control chosen validate[required] input-height" name="party_name">
                                                <option value="">Select Party Name</option>                                 
                                                <?php $getname = $this->db->select('*')->get_where('parties',array('party_id'=>$result->party_name,'status!='=>'Trash'))->row();
                                            ?><option selected="selected" value="<?php echo $getname->party_id; ?>"><?php echo $getname->party_name; ?></option>
                                                <?php
                                                foreach ($partyresults as $results) {
                                                    if($results->party_name != $result->party_name){?>
                                                    <option value="<?php echo $results->party_id; ?>"><?php echo $results->party_name; ?></option>
                                                <?php } ?>
                                                     <?php } ?>
                                            </select>
                                        </div> 
                                    </div>                                                  
                                    <div class="form-group">                                              
                                        <label class="col-lg-4 control-label">Loan Amount (GHS
                                            )</label>  
                                        <div class="col-lg-8">                                                
                                            <input type="text" name="loan_amount" id="loan" placeholder=""  value="<?php echo $result->loan_amount; ?>" class="form-control validate[required]"> 
                                        </div>                                                
                                    </div>                                                 
                                    <div class="form-group">                                 
                                        <label class="col-lg-4 control-label">Interest ( % )</label>        
                                        <div class="col-lg-8">                                                
                                            <div class="row">                                             
                                                <div class="col-md-4 col-xs-4">                          
                                                    <input type="text"  name="interest_per" id="interest_per" value="<?php echo $result->interest_per; ?>" class="form-control validate[required]">    
                                                </div>                                                          
                                                <div class="col-md-8 col-xs-8">                              
                                                    <input type="text" name="interest" id="interest" value="<?php echo $result->interest; ?>" class="form-control">       
                                                </div>                                                     
                                            </div>                                                      
                                        </div>                                                  
                                    </div>    
                                    <div class="form-group">                                  
                                        <label class="col-lg-4 control-label">Other Charges (GHS
                                            )</label>    
                                        <div class="col-lg-8">                                            
                                            <input type="text" name="other_charges" placeholder=""  value="<?php echo $result->other_charges; ?>" class="form-control validate[required]">  
                                        </div>                                                 
                                    </div>                                                 
                                    <div class="form-group">                                 
                                        <label class="col-lg-4 control-label">Pay From</label>      
                                        <div class="col-lg-8">                                            
                                            <input type="text" name="pay_from" placeholder=""  value="<?php echo $result->pay_from; ?>" class="form-control">    
                                        </div>                                                
                                    </div>                                                   
                                    <div class="form-group">                                      
                                        <label class="col-lg-4 control-label">Remarks</label>         
                                        <div class="col-lg-8">                                                 
                                            <input type="text" name="remarks" placeholder=""  value="<?php echo $result->remarks; ?>" class="form-control">     
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
    jQuery(function () {
    $("#loan, #interest_per").on("keydown keyup", sum);
    function sum() {
    var calc =(Number($("#loan").val()) *  Number($("#interest_per").val()) * 30) / 36000;
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
    $('#loan_no').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/check_ploanno')?>",
            data: 'loan_no=' + $(this).val(),
            dataType: "json",
            success: function (data) {
               if( data.loan_no  != ''){
                  alert("Loan no already exist !");
                  }
             }
        });
    });
</script>
