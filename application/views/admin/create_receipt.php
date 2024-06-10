<?php
$date = date('Y-m-d');
?>
<?php
$yesdate = date('Y-m-d', strtotime("-1 days"));
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
                <li>Receipt</li>
                <li class="active">Add Receipt</li>
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
                            <a href="receipt_display"><span class="trans-icons-3"></span>Back</a>     
                        </div>
                    </legend>
                    <div class="trans-table">
                        <div class="trans-table-head"><h4>Add Receipt</h4></div>
                        <form action="#" class="receipt-form form-validation" id="formID" method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-flat loan-panel">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Rept. No</label>                                                            
                                                <div class="col-lg-8"> 
                                                     <?php $count=0;  ?>
                                                    <input type="text" name="receipt_no" placeholder="" class="form-control validate[required]"  value="<?php if (!empty($idresults->receipt_no)) { echo $idresults->receipt_no + 1; } else { echo $count+1; } ?>" >   
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Rcpt. Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="receipt_date" id="receipt_date" class="form-control validate[required] datepicker validate[required]" data-date-format="yyyy-mm-dd"  value="<?php echo $date ?>" placeholder="Receipt Date" type="text"  >                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Rcd Upto Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="int_rcvd_upto_dt" id="int_rcvd_upto_dt" class="form-control validate[required] datepicker-prev validate[required]" data-date-format="yyyy-mm-dd"  placeholder="Received Date" type="text"  >                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan No</label>                                                            
                                                <div class="col-lg-8"> 
                                                    <input type="text" name="loan_no" placeholder="" id="loan_no" class="form-control validate[required]">      
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Party name</label>                                                            
                                                <div class="col-lg-8">                                         
                                                    <input type="text" name="party_name" id="party_name" placeholder="" class="form-control validate[required]">         
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan Amount (GHS
                                                    )</label>                   
                                                <div class="col-lg-8">                                                         
                                                    <input type="text" name="loan_amt" id="loan_amt" placeholder="" class="form-control validate[required]">         
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">                                                  
                                                    <input type="text" name="int_amt" id="int_amt" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">                                                        
                                                    <input type="text" name="pre_bal_int_amt" id="pre_bal_int_amt" placeholder="" class="form-control validate[required]" maxlength="255"  maxlength="4">  
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Rcvd Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">                                                          
                                                    <input type="text" name="rcvd_int_amt" id="rcvd_int_amt" placeholder="" class="form-control validate[required]">   
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Adv Int Amt  (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">                   
                                                    <input type="text" name="adv_int_amt" id="adv_int" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Add/Less</label>                                                            
                                                <div class="col-lg-8">    
                                                    <input type="text" name="add_less" id="add_less" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label"><strong>Total Amt (GHS
                                                        )</strong></label>                                                            
                                                <div class="col-lg-8">    
                                                    <input type="text" name="total_amt" id="total_amt" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pay To</label>                                                            
                                                <div class="col-lg-8">               
                                                    <input type="text" name="pay_to" placeholder="" value="CASH" class="form-control validate[required]">        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Remarks</label>                                                            
                                                <div class="col-lg-8">                                                                <input type="text" name="remarks" placeholder="" class="form-control">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">A/c Close</label>  
                                                <div class="col-lg-8"> 
                                                    <select name="ac_close" id="ac_close" class="form-control validate[required]">
                                                        <option hidden disabled selected value>Select option</option>
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
                                                        <input name="loan_date" id="loan_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd" type="text"  >                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan Amount (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8"> 
                                                    <input type="text" name="loan_amount" id="loan_amount" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Per ( % )</label>                                                            
                                                <div class="col-lg-8">   
                                                    <input type="text" name="int_per" id="int_per" placeholder="" class="form-control validate[required]">                           
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Last Rcvd Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="last_rcvd_date" id="last_rcvd_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd" placeholder="Last Received Date" type="text"  >                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Adv Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">      
                                                    <input type="text" id="adv_interest" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Total Days</label>                                                            
                                                <div class="col-lg-8">           
                                                    <input type="text" name="total_days"  id="total_days" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">                                     
                                                    <input type="text" id="int_amount" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Rcvd Loan Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">      
                                                    <input type="text" name="rcvd_loan_amt" id="rcvd_loan_amt" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Rcvd Adv Int (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">  
                                                    <input type="text" name="rcvd_adv_int" id="rcvd_adv_int" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">  
                                                    <input type="text" id="pre_bal_int_amount" placeholder="" class="form-control validate[required]">                                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Bal Loan Amt (GHS
                                                    )</label>                                                            
                                                <div class="col-lg-8">      
                                                    <input type="text" name="bal_loan_amt" id="bal_loan_amt" placeholder="" class="form-control form-space validate[required]">                                                            </div>
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
                                    <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Submit </button>                                                 </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
            <!-- /content area -->                    
        </div>
        <!-- /2 columns form -->                   <!-- /main content -->                
    </div>
    <!-- /page content -->            
</div>
<script>
    $('#loan_no').change(function () {
        var loan_no=$(this).val();
        var receipt_date= $('#receipt_date').val();
        $.ajax({
            url: "<?php echo base_url('admin/show_data') ?>",
            data: 'loan_no=' + loan_no + "&receipt_date=" + receipt_date,
            dataType: "json",
            success: function (data) {
                $('#party_name').val(data.party_name);
                $('#loan_amt').val(data.loan_amt);
                $('#int_amt').val(data.int_amt);
                $('#adv_int').val(data.adv_int);
                $('#adv_interest').val(data.adv_interest);
                $('#int_amount').val(data.int_amount);
                $('#loan_date').val(data.loan_date);
                $('#last_rcvd_date').val(data.last_rcvd_date);
                $('#loan_amount').val(data.loan_amount);
                $('#total_amt').val(data.total_amt);
                $('#total_amt').val(data.loan_amount);
                $('#int_per').val(data.int_per);
                $('#total_days').val(data.total_days);
                $('#bal_loan_amt').val(data.loan_amount);
                $('#pre_bal_int_amt').val(data.pre_bal_int_amt);
                $('#pre_bal_int_amount').val(data.pre_bal_int_amount);
                $('#rcvd_loan_amt').val(data.rcvd_loan_amt);
                $('#rcvd_adv_int').val(data.rcvd_adv_int);
                if (data.bal_loan_amt == 0) {
                    alert("Account Closed");
                }

            }
        });
    });
</script>
<script>
    $('#loan_no').change(function () {
          var loan_no=$(this).val();
        var receipt_date= $('#receipt_date').val();
        $.ajax({
            url: "<?php echo base_url('admin/show_data') ?>",
           data: 'loan_no=' + loan_no + "&receipt_date=" + receipt_date,
            dataType: "json",
            success: function (data) {
                $('#party_name').val(data.party_name);
                $('#loan_amt').val(data.loan_amt);
                $('#int_amt').val(data.int_amt);
                $('#adv_int').val(data.adv_int);
                $('#pre_bal_int_amt').val(data.pre_bal_int_amt);
                $('#total_amt').val(data.total_amt);
                $('#loan_date').val(data.loan_date);
                $('#loan_amount').val(data.loan_amount);
                $('#int_per').val(data.int_per);
                $('#last_rcvd_date').val(data.last_rcvd_date);
                $('#adv_interest').val(data.adv_interest);
               // $('#total_days').val(data.total_days);
                $('#int_amount').val(data.int_amount);
                $('#rcvd_loan_amt').val(data.rcvd_loan_amt);
                $('#rcvd_adv_int').val(data.rcvd_adv_int);
                $('#pre_bal_int_amount').val(data.pre_bal_int_amt);
                $('#bal_loan_amt').val(data.bal_loan_amt);
                if (data.bal_loan_amt == 0) {
                    alert("Account Closed");
                }
            }
        });
    });
</script>
<script>
    $('#receipt_date').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/find_prev_date') ?>",
            data: 'receipt_date=' + $(this).val(),
            dataType: "json",
            success: function (data) {
                $('#int_rcvd_upto_dt').val(data.int_rcvd_upto_dt);
            }
        });
    });
</script>
<script>
    jQuery(function () {
        $("#loan_amt, #adv_int, #pre_bal_int_amt, #rcvd_int_amt, #add_less").on("keydown keyup", sum);
        function sum() {
            $("#total_amt").val(Number($("#loan_amt").val()) + Number($("#adv_int").val()) + Number($("#rcvd_int_amt").val()) + Number($("#add_less").val()));
            $("#rcvd_loan_calc").val(Number($("#loan_amt").val()));
            $("#bal_loan_calc").val(Number($("#bal_loan_amt").val()) - Number($("#loan_amt").val()));
        }
    });
</script>
<script>
    jQuery(function () {
        $("#int_amt, #rcvd_int_amt").on("keydown keyup", sum);
        function sum() {
            $("#prebal_calc").val(Number($("#int_amt").val()) - Number($("#rcvd_int_amt").val()));
        }
    });
</script>
<script>
    jQuery(document).ready(function () {
        jQuery("#formID").validationEngine();
    });
</script>

