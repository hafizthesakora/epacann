<?php
$date = date('Y-m-d');
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
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href=""><i class="icon-home2 position-left"></i>Entry</a></li>
                <li>Deposit Payment</li>
                <li class="active">Add Deposit Payment</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat  loan-panel">
            <div class="panel-body">
                <fieldset>
                    <legend>
                        <div class="button-style-2 invoice-button back-btn">
                            <a href="deposit_pymt_display"><span class="trans-icons-3"></span>Back</a>     
                        </div>
                    </legend>
                    <div class="trans-table">
                        <div class="trans-table-head"><h4>Add Deposit Payment</h4></div>
                        <form action="#" class="receipt-form form-validation" id="formID" method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-flat loan-panel">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pymt. No</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="pymt_no" id="pymt_no" placeholder="" class="form-control validate[required]" value="<?php if (!empty($idresults->pymt_no)) { echo $idresults->pymt_no + 1; } else { $count=0; echo $count+1; } ?>" >           
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pymt. Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="pymt_date" id="pymt_date" class="form-control validate[required] datepicker" data-date-format="dd-mm-yyyy"  value="<?php echo $date ?>" placeholder="Payment Date" type="text"  >                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Paid Upto Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="int_paid_upto_date" id="int_paid_upto_date" class="form-control validate[required] datepicker" data-date-format="dd-mm-yyyy"  value="<?php echo $yesdate ?>" placeholder="Interest Paid Upto Date" type="text"  >                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Dep No</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="dep_no" id="dep_no" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-lg-4 control-label">Party Name</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="party_name" id="party_name" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                              <div class="form-group">
                                                <label class="col-lg-4 control-label">Total Deposit Amount</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="total_dep_amt" id="total_dep_amt" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Dep Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="dep_amt" id="dep_amt" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                           <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="int_amt"  id="int_amt" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="pre_bal_int_amt" id="pre_bal_int_amt" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Paid Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="paid_int_amt"  id="paid_int_amt" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Add/Less (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="add_less" id="add_less" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label"><strong>Total Amt (GHS )</strong></label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="total_amt" id="total_amt" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pay To</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="pay_to" id="pay_to" placeholder="" value="CASH" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Remarks</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="remarks" id="remarks" placeholder="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">A/c Close</label>  
                                                <div class="col-lg-8"> 
                                                    <select name="ac_close" id="ac_close" class="form-control validate[required]">
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
                                                <label class="col-lg-4 control-label">Dep Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="dep_date" id="dep_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd"  value="<?php echo $date ?>" placeholder="Receipt Date" type="text"  >                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Dep Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="dep_amount" id="dep_amount" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Per ( % )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="int_per" id="int_per" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Last Paid Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="class input-group date">
                                                        <input name="last_paid_date" id="last_paid_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd"  value="<?php echo $date ?>" placeholder="Last Paid Date" type="text"  >                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Total Days</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="total_days" id="total_days" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="int_amount" id="int_amount" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Paid Dep Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="paid_dep_amt" id="paid_dep_amt" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text"  id="pre_bal_int_amount" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Bal Dep Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="bal_dep_amt" id="bal_dep_amt" placeholder="" class="form-control form-space validate[required]">
                                                </div>
                                            </div>
                                            <input type="hidden" name="prebal_calc" id="prebal_calc" placeholder="" class="form-control form-space"> 
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
        <!-- /2 columns form -->

        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<script>
    $('#dep_no').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/deposit_showdata')?>",
            data: 'dep_no=' + $(this).val(),
            dataType: "json",
            success: function (data) {
                $('#dep_date').val(data.dep_date);
                $('#party_name').val(data.party_name);
                $('#dep_amt').val(data.dep_amt);
                $('#int_amt').val(data.int_amt);
                $('#paid_int_amt').val(data.paid_int_amt);
                $('#total_amt').val(data.dep_amount);
                $('#dep_amount').val(data.dep_amount);
                $('#int_per').val(data.int_per); 
                $('#int_amount').val(data.int_amount);
                $('#total_days').val(data.total_days);
                $('#bal_dep_amt').val(data.bal_dep_amt);
                $('#paid_dep_amt').val(data.paid_dep_amt);
                $('#total_dep_amt').val(data.total_dep_amt);
                  $('#pre_bal_int_amount').val(data.pre_bal_int_amount);
                    $('#pre_bal_int_amt').val(data.pre_bal_int_amt);
                    $('#last_paid_date').val(data.last_paid_date);
                      if( data.bal_dep_amt  == 0){
                  alert("Account Closed");
                  }
            }
        });
    });
</script>
<script>
    $('#dep_no').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/deposit_showdata')?>",
            data: 'dep_no=' + $(this).val(),
            dataType: "json",
            success: function (data) {
                $('#party_name').val(data.party_name);
                $('#dep_amt').val(data.dep_amt);
                $('#int_amt').val(data.int_amt);
                $('#pre_bal_int_amt').val(data.pre_bal_int_amt);
                $('#total_amt').val(data.total_amt);
                $('#dep_date').val(data.dep_date);
                $('#dep_amount').val(data.dep_amount);
                $('#int_per').val(data.int_per);
                $('#last_paid_date').val(data.last_paid_date);
                 $('#total_days').val(data.total_days);
                  $('#int_amount').val(data.int_amount);
                  $('#paid_dep_amt').val(data.paid_dep_amt);
                  $('#pre_bal_int_amount').val(data.pre_bal_int_amt);
                   $('#total_dep_amt').val(data.total_dep_amt);
                  $('#bal_dep_amt').val(data.bal_dep_amt);
                    $('#total_dep_amt').val(data.total_dep_amt);
                    if( data.bal_dep_amt  == 0){
                  alert("Account Closed");
                  }
            }
        });
    });
</script>
<script>
jQuery(function () {
$("#dep_amt, #paid_int_amt, #pre_bal_int_amt, #add_less , #bal_dep_amt").on("keydown keyup", sum);
function sum() {
$("#total_amt").val(Number($("#dep_amt").val()) + Number($("#pre_bal_int_amt").val()) + Number($("#paid_int_amt").val())+ Number($("#add_less").val()) );
var calc =Number($("#total_dep_amt").val()) + Number($("#dep_amt").val()) + Number($("#pre_bal_int_amt").val()) + Number($("#paid_int_amt").val()) + Number($("#add_less").val());
    calc = parseFloat(calc).toFixed(2);
$("#bal_dep_amt").val(calc);
}
});
</script>
<!--<script>
    jQuery(function () {
    $("#dep_amt, paid_int_amt , #add_less").on("keydown keyup", sum);
    function sum() {
    $("#total_dep_amt").val(Number($("#dep_amt").val()) + Number($("#paid_int_amt").val()));
    }
    });
</script>-->
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
