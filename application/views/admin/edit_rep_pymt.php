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
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>   
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>  
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>      
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Entry</a></li>
                <li><a href="replace_pymt_display">Replace Payment</a></li>
                <li class="active">Edit Replace Payment</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <fieldset>
                    <legend>
                        <div class="button-style-2 invoice-button back-btn">
                            <a href="replace_pymt_display"><span class="trans-icons-3"></span>Back</a>     
                        </div>
                    </legend>
                    <div class="trans-table">
                        <div class="trans-table-head"><h4>Edit Replace Payment</h4></div>
                        <form action="#" class="receipt-form form-validation" id="formID" method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-flat loan-panel">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pymt. No</label>                                                            
                                                <div class="col-lg-8">  
                                                    <input type="text" name="pymt_no" id="pymt_no" placeholder="" class="form-control validate[required]" value="<?php echo $result->pymt_no; ?>" >                                                              </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-lg-4 control-label">Pymt Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="pymt_date" id="pymt_date" class="form-control validate[required]" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($result->pymt_date)); ?>" type="text"  >       
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Paid Upto Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="int_paid_upto_date" id="int_paid_upto_date" class="form-control validate[required]" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($result->int_paid_upto_date)); ?>"  type="text"  >   
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Bank Loan No</label>                                                            
                                                <div class="col-lg-8">         
                                                    <input type="text" name="bank_loan_no" id="bank_loan_no" placeholder="" class="form-control validate[required]" value="<?php echo $result->bank_loan_no; ?>">                                                            </div>
                                            </div>
  <div class="form-group">
                                                <label class="col-lg-4 control-label">Bank name</label>                                                            
                                                <div class="col-lg-8">   
                                                    <input type="text" name="bank_name" id="bank_name" placeholder="" class="form-control validate[required]" value="<?php echo $result->bank_name; ?>"  readonly=""> 
                                                           </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8"> 
                                                    <input type="text" name="loan_amt" id="loan_amt" placeholder="" class="form-control validate[required]" value="<?php echo $result->loan_amt; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">  
                                                    <input type="text" name="int_amt"  id="int_amt" placeholder="" class="form-control validate[required]" value="<?php echo $result->int_amt; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8"> 
                                                    <input type="text" name="pre_bal_int_amt" id="pre_bal_int_amt" placeholder="" class="form-control validate[required]" value="<?php echo $result->pre_bal_int_amt; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Paid Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">        
                                                    <input type="text" name="paid_int_amt" id="paid_int_amt" placeholder="" class="form-control validate[required]" value="<?php echo $result->paid_int_amt; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Add/Less (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">  
                                                    <input type="text" name="add_less" id="add_less" placeholder="" class="form-control validate[required]" value="<?php echo $result->add_less; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label"><strong>Total Amt (GHS
                                                        )</strong></label>                                                            
                                                <div class="col-lg-8">  
                                                    <input type="text" name="total_amt" id="total_amt"  placeholder="" class="form-control validate[required]" value="<?php echo $result->total_amt; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pay To</label>                                                            
                                                <div class="col-lg-8">     
                                                    <input type="text" name="pay_to" id="pay_to" placeholder="" value="CASH" class="form-control validate[required]" value="<?php echo $result->pay_to; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Remarks</label>                                                            
                                                <div class="col-lg-8">    
                                                    <input type="text" name="remarks"  id="remarks" placeholder="" class="form-control" value="<?php echo $result->remarks; ?>">                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">A/c Close</label>  
                                                <div class="col-lg-8"> 
                                                    <select name="ac_close"  id="ac_close" class="form-control validate[required]">
                                                        <option value="<?php echo $result->ac_close; ?>"><?php echo $result->ac_close; ?></option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select> 

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="panel panel-flat loan-panel">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="loan_date" id="loan_date" class="form-control validate[required]"  value="<?php echo date('d-m-Y',strtotime($result->loan_date)); ?>" data-date-format="dd-mm-yyyy" type="text"  >      
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Amount (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">    
                                                    <input type="text" name="loan_amount" id="loan_amount" placeholder="" class="form-control validate[required]" value="<?php echo $result->loan_amount; ?>">   
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Per ( % )</label>                                                            
                                                <div class="col-lg-8">      
                                                    <input type="text" name="int_per" id="int_per" placeholder="" class="form-control validate[required]" value="<?php echo $result->int_per; ?>">   
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Last Paid Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="last_paid_date" id="last_paid_date" class="form-control validate[required]" data-date-format="dd-mm-yyyy"  value="<?php echo date('d-m-Y',strtotime($result->last_paid_date)); ?>" placeholder="Last Paid Date" type="text"  >    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Total Days<span>:</span></label>                                                            
                                                <div class="col-lg-8">     
                                                    <input type="text" name="total_days" id="total_days" placeholder="" class="form-control validate[required]" value="<?php echo $result->total_days; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">         
                                                    <input type="text" id="int_amount" placeholder="" class="form-control validate[required]" value="<?php echo $result->int_amt; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Paid Loan Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">    
                                                    <input type="text" name="paid_loan_amt" id="paid_loan_amt" placeholder="" class="form-control  validate[required]" value="<?php echo $result->paid_loan_amt; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">     
                                                    <input type="text" id="pre_bal_int_amount" placeholder="" class="form-control  validate[required]" value="<?php echo $result->pre_bal_int_amt; ?>">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Bal Loan Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">  
                                                    <input type="text" name="bal_loan_amt" id="bal_loan_amt" placeholder="" class="form-control form-spacing  validate[required]" value="<?php echo $result->bal_loan_amt; ?>">                                                            </div>
                                            </div>
                                            <input type="hidden" name="prebal_calc" id="prebal_calc" placeholder="" class="form-control form-space">   
                                        <input type="hidden" name="rcvd_loan_calc" id="rcvd_loan_calc" placeholder="" class="form-control form-space">
                                       <input type="hidden" name="bal_loan_calc" id="bal_loan_calc" placeholder="" class="form-control form-space"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-buttons-wrapper row-fluid">
                                <div class="span12 align-center">
                                    <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Submit </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
            <!-- /content area -->                    
        </div>
        <!-- /2 columns form -->                  <!-- /main content -->                
    </div>
    <!-- /page content -->    
</div>
<script>
    $('#bank_loan_no').change(function () {
         var bank_loan_no=$(this).val();
        var pymt_date= $('#pymt_date').val();
        $.ajax({
            url: "<?php echo base_url('admin/replacepymt_show_data') ?>",
            data: 'bank_loan_no=' + bank_loan_no + "&pymt_date=" + pymt_date,
            dataType: "json",
            success: function (data) {
                $('#bank_name').val(data.bank_name);
                $('#last_paid_date').val(data.last_paid_date);
                $('#loan_amt').val(data.loan_amt);
                $('#int_amt').val(data.int_amt);
                $('#int_amount').val(data.int_amount);
                $('#loan_date').val(data.loan_date);
                $('#loan_amount').val(data.loan_amount);
                $('#total_amt').val(data.total_amt);
                $('#bal_loan_amt').val(data.bal_loan_amt);
                $('#int_per').val(data.int_per);
                $('#total_days').val(data.total_days);
                $('#paid_loan_amt').val(data.paid_loan_amt);
                $('#pre_bal_int_amount').val(data.pre_bal_int_amount);
                $('#pre_bal_int_amt').val(data.pre_bal_int_amt);
                if (data.bal_loan_amt == 0) {
                    alert("Account Closed");
                }
            }
        });
    });
</script>
<script>
    $('#bank_loan_no').change(function () {
         var bank_loan_no=$(this).val();
        var pymt_date= $('#pymt_date').val();
        $.ajax({
            url: "<?php echo base_url('admin/replacepymt_show_data') ?>",
             data: 'bank_loan_no=' + bank_loan_no + "&pymt_date=" + pymt_date,
            dataType: "json",
            success: function (data) {
                $('#bank_name').val(data.bank_name);
                $('#loan_amt').val(data.loan_amt);
                $('#int_amt').val(data.int_amt);
                $('#pre_bal_int_amt').val(data.pre_bal_int_amt);
                $('#total_amt').val(data.total_amt);
                $('#loan_date').val(data.loan_date);
                $('#loan_amount').val(data.loan_amount);
                $('#int_per').val(data.int_per);
                $('#last_paid_date').val(data.last_paid_date);
                $('#total_days').val(data.total_days);
                $('#int_amount').val(data.int_amount);
                $('#paid_loan_amt').val(data.paid_loan_amt);
                $('#pre_bal_int_amount').val(data.pre_bal_int_amount);
                $('#bal_loan_amt').val(data.bal_loan_amt);
                if (data.bal_loan_amt == 0) {
                    alert("Account Closed");
                }
            }
        });
    });
</script>
<script>
    jQuery(function () {
    $("#loan_amt, #pre_bal_int_amt, #paid_int_amt, #add_less").on("keydown keyup", sum);
    function sum() {
    $("#total_amt").val(Number($("#loan_amt").val()) + Number($("#pre_bal_int_amt").val()) + Number($("#paid_int_amt").val())+ Number($("#add_less").val()));
   $("#rcvd_loan_calc").val(Number($("#loan_amt").val()));
    $("#bal_loan_calc").val(Number($("#bal_loan_amt").val()) - Number($("#loan_amt").val())) ;
    }
    });
</script>
<script>
    jQuery(document).ready(function () {
    jQuery("#formID").validationEngine();
    });
</script>
<script>
    jQuery(function () {
    $("#int_amt, #paid_int_amt").on("keydown keyup", sum);
    function sum() {
    $("#prebal_calc").val(Number($("#int_amt").val()) - Number($("#paid_int_amt").val()));
    }
    });
</script>