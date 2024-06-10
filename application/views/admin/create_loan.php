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
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Entry</a></li>
                <li><a href="loan_display">Loans</a></li>
                <li class="active">Loan Creation</li>
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
                                <a href="loan_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Add Loan</h4></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Loan No</label>                                                    
                                        <div class="col-lg-7">
                                            <?php $count=0;  ?>
                                            <input type="text" name="loan_no" id="loan_no" class="form-control validate[required]"  value="<?php if (!empty($idresults->loan_no)) { echo $idresults->loan_no + 1; } else { echo $count+1; } ?>" >        
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                         <label class="col-lg-4 control-label">Loan Date</label>  
                                         <div class="input-group date form_date col-lg-7 " id="joidate">
                                             <input class="validate[required] form-control input-height" name="loan_date" placeholder="Loan Date" type="text" value="" id="form-validation-field-4" id="datePicker" aria-invalid="false">
                                             <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                         </div>
                                     </div>-->
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Loan Date</label>                                                    
                                        <div class="col-lg-7"> 
                                            <div class="class input-group date">
                                                <input name="loan_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd"  value="<?php echo $date ?>" placeholder="Loan Date" type="text"  >                                                    </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Party name</label>                                                    
                                        <div class="col-lg-7">  
                                            <select class="form-control chosen validate[required] input-height" name="party_name">
                                                <option value="">Select Party Name...</option>  
                                                <?php
                                                foreach ($partyresults as $result) {
                                                    ?>
                                                    <option value="<?php echo $result->party_id; ?>"><?php echo $result->party_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> </div> 
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Loan Amount (GHS)
                                            </label>                                                    
                                        <div class="col-lg-7"> 
                                            <input type="text" name="loan_amount" id="loan" placeholder="" class="form-control validate[required]">  
                                       <!-- <input type="hidden" name="loan_amount" id="loan_amount_id" placeholder="" class="form-control"> -->   </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Interest (%)</label>                                                    
                                        <div class="col-lg-7">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-4"> 
                                                    <select class="form-control validate[required]"  name="interest_per"  id="interest">
                                                        <option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
                                                        <option value="27">27</option>
                                                        <option value="48">48</option>
                                                    </select>                             
                                                </div>
                                                <div class="col-md-8 col-xs-8"> 
                                                    <input type="text" name="interest" id="interest_per" class="form-control validate[required]"  maxlength="255"  maxlength="4">                                                            </div>
                                            </div>
                                        </div>
                                    </div></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Adv Interest (GHS)</label>                                                    
                                        <div class="col-lg-7">                                                 
                                            <input type="text" name="adv_interest" id="adv_int" placeholder="" value="0" class="form-control validate[required]">                                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Other Charges (GHS)</label>                                                    
                                        <div class="col-lg-7">     
                                            <input type="text" name="other_charges" placeholder="" id="other_charges" value="0" class="form-control validate[required]">                                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Bal Amount (GHS)</label>                                                    
                                        <div class="col-lg-7">
                                            <input type="tet" name="bal_amount" placeholder=""  id="loan_amount_id" class="form-control validate[required]">                                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Pay From</label>                                                    
                                        <div class="col-lg-7"> 
                                            <input type="text" name="pay_from" placeholder="" value="CASH" class="form-control validate[required]">                                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Remarks</label>                                                    
                                        <div class="col-lg-7">     
                                            <input type="text" name="remarks" placeholder="" class="form-control">                                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-flat">
                            <div class="table-responsive">
                                <div class="trans-table">
                                    <table class="transactions-table trans-margin">
                                        <thead class="transactions-table-head">
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Qty</th>
                                                <th>Weight ( g )</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center">1</td>
                                        <div  id="output" ></div><td> <select multiple class="form-control validate[required] chosen-select" name="name[]" id="item_name">
<!--                                                        <option value="">Select Item Name...</option>  -->
                                                        <?php
                                                        foreach ($itemresults as $result) {
                                                            ?>
                                                            <option value="<?php echo $result->item_name; ?>"><?php echo $result->item_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="text-center"><input name="quantity" class="description-input validate[required]" value="" maxlength="255" type="number" step='0' value='0' placeholder='0' id="products0EstimateproductDescription" style="padding: 3px !important;"></td>
                                                <td><input name="weight" class="description-input validate[required]" style="padding: 3px !important;"></td>
                                                <td><input name="remark" class="description-input" value="-" maxlength="255" type="text" id="products0EstimateproductDescription"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
        <!-- /2 columns form -->                    <!-- Footer -->                    
    </div>
    <!-- /main content -->     
</div>
<script>
    jQuery(function () {
        $("#loan, #interest, #adv_int, #other_charges").on("keydown keyup", sum);
        function sum() {
            var calc = (Number($("#loan").val()) * Number($("#interest").val()) * 30) / 36000;
            calc = parseFloat(calc).toFixed(2);
            $("#interest_per").val(calc);
            $("#loan_amount_id").val(Number($("#loan").val()) - Number($("#adv_int").val()) - Number($("#other_charges").val()));
        }
    });
</script>
<script>
    jQuery(document).ready(function () {
        jQuery("#formID").validationEngine();
    });
</script>
<!--<script>
    $(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!"
    });
</script>-->
<script>
    $('#loan_no').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/check_loanno')?>",
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
<script>
    document.getElementById('output').innerHTML = location.search;
$(".chosen-select").chosen();
</script>
<style>
    .btn-group, .btn-group-vertical {
    display: none;
    }
    td{
        text-align: left;
    }
    </style>