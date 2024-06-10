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
                <li><a href="replace_loan_display">Replace Loans</a></li>
                <li class="active">Add Replace Loan</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal form-validation" id="formID" action="#" method="post" autocomplete="off">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a href="replace_loan_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Add Replace Loan</h4></div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-md-offset-3 col-lg-3 control-label">S.No</label>                                                    
                                        <div class="col-lg-5">
                                            <input type="text" name="sno" class="form-control "value="<?php echo $result->sno; ?>">       
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Bank Name</label>                                                    
                                        <div class="col-lg-5">
                                            <select class="form-control chosen validate[required] input-height" name="bank_name">
                                                <option value="">Select Bank...</option>  
                                                <?php $getname = $this->db->select('*')->get_where('banks', array('bank_id' => $result->bank_name, 'status!=' => 'Trash'))->row(); ?>
                                                <option selected="selected" value="<?php echo $getname->bank_id; ?>"><?php echo $getname->bank_name; ?></option>
                                                <?php
                                                foreach ($bankresults as $results) {
                                                    if ($results->bank_name != $result->bank_name) {
                                                        ?>
                                                        <option value="<?php echo $results->bank_id; ?>"><?php echo $results->bank_name; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>     
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-md-offset-3 col-lg-3 control-label">Date</label>                                                    
                                        <div class="col-lg-5"> 
                                            <div class="class input-group date">
                                                <input name="date" class="form-control validate[required]" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($result->date )); ?>"placeholder="Loan Date" type="text"  >                                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Bank Loan No</label>                                                    
                                        <div class="col-lg-5">
                                            <input type="text" name="bank_loan_no" id="bank_loan_no" class="form-control validate[required]" value="<?php echo $result->bank_loan_no; ?>">       
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="trans-table">
                            <table class="transactions-table trans-margin">
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th>A/c No.</th>
                                        <th>Party Name</th>
                                        <th>Remark</th>
                                        <th>Add More</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $replaceloan_id = $this->input->get('replaceloan_id');

                                    $get = $this->db->select('*')->get_where('replaceloans_additional', array('replaceloan_id' => $replaceloan_id , 'status !='=>'Trash'))->result();
                                    if (!empty($get)) {
                                    foreach ($get as $res) {
                                        ?>
                                        <tr> 

                                            <td><input name="ac_no[]" id="ac_no" class="description-input ac_no" value="<?php echo $res->ac_no; ?>"  maxlength="255" type="text" id="products0EstimateproductDescription"></td>
                                            <td><input name="party_name[]" id="party_name" class="description-input  party_name" value="<?php echo $res->party_name; ?>"   maxlength="255" type="text" id="products0EstimateproductDescription"></td>
                                            <td><input name="remark[]" id="remark" class="description-input remark"  maxlength="255" type="text" value="<?php echo $res->remark; ?>" id="products0EstimateproductDescription"></td>
                                         <td> <button class="btn btn-success addmore add-btn" type="button"><i class="la la-plus"></i><i class="fa fa-plus" aria-hidden="true"></i>
                                            </button></td>
                                        </tr>   
                                    <?php }  ?>
                                      <div class="add-moresec">
                                </div>
                                    <?php } else  { ?>
                                <tr> 

                                            <td><input name="ac_no[]" id="ac_no" class="description-input validate[required] ac_no"maxlength="255" type="text" id="products0EstimateproductDescription"></td>
                                            <td><input name="party_name[]" id="party_name" class="description-input validate[required] party_name"   maxlength="255" type="text" id="products0EstimateproductDescription"></td>
                                            <td><input name="remark[]" id="remark" class="description-input remark"  maxlength="255" type="text"  id="products0EstimateproductDescription"></td>
                                         <td> <button class="btn btn-success addmore add-btn" type="button"><i class="la la-plus"></i><i class="fa fa-plus" aria-hidden="true"></i>
                                            </button></td>
                                        </tr> 
                                         <div class="add-moresec">
                                </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>      
            </div>
            <div class="panel panel-flat loan-panel">
                <div class="panel-body">
                    <div class="trans-table">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-md-offset-3 col-lg-3 control-label"><b>Loan Amt (GHS )</b></label>                                                    
                                    <div class="col-lg-5">
                                        <input type="text" name="loan_amount" id="loan_amount" class="form-control validate[required]" value="<?php echo $result->loan_amount; ?>" >       
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Other Amt (GHS )</label>                                                    
                                    <div class="col-lg-5">
                                        <input type="text" name="other_amt" id="other_amt" class="form-control validate[required]" value="<?php echo $result->other_amt; ?>" >       
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-md-offset-3 col-lg-3 control-label">Interest (%)</label>                                                    
                                    <div class="col-lg-5">
                                        <div class="row">
                                            <div class="col-md-4 col-xs-4">  
                                                <input type="text" class="form-control validate[required]" name="interest_per"  id="interest_per" name="interest" value="<?php echo $result->interest_per; ?>" >                                                            </div>
                                            <div class="col-md-8 col-xs-8"> 
                                                <input type="text" name="interest" id="interest" class="form-control validate[required]"  maxlength="255"  maxlength="4" value="<?php echo $result->interest; ?>" >                                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><b>Bal Amount</b><span>:</span></label>                                                    
                                    <div class="col-lg-5">
                                        <input type="text" name="bal_amt" id="bal_amt" class="form-control validate[required]" value="<?php echo $result->bal_amt; ?>" >       
                                    </div>
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
            </div>
        </form>
    </div>
    <!-- /2 columns form -->  
</div>
<!-- /content area -->    
<script>
    jQuery(function () {
        $("#loan_amount, #interest_per, #other_amt").on("keydown keyup", sum);
        function sum() {
            var calc = (Number($("#loan_amount").val()) * Number($("#interest_per").val()) * 30) / 36000;
            calc = parseFloat(calc).toFixed(2);
            $("#interest").val(calc);
            $("#bal_amt").val(Number($("#loan_amount").val()) - Number($("#other_amt").val()));
        }
    });
</script>
<script>
    jQuery(document).ready(function () {
        jQuery("#formID").validationEngine();
    });
</script>
<script>
    $(document).on('change','.ac_no',function () {
        var no = $(this);
        $.ajax({

            url: "<?php echo base_url('admin/replaceloan_show_data') ?>",
            data: 'ac_no=' + no.val(),
            dataType: "json",
            success: function (data) {
                no.closest('tr').find('.party_name').val(data.party_name);
                no.closest('tr').find('.remark').val(data.remark);
            }
        });
    });
</script>
<script>
    $('#bank_loan_no').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/check_bankloanno') ?>",
            data: 'bank_loan_no=' + $(this).val(),
            dataType: "json",
            success: function (data) {
                if (data.bank_loan_no != '') {
                    alert("Loan no already exist !");
                }
            }
        });
    });
</script>
<script>
    $(document).on('click', '.addmore', function () {
        var file_i = $('.ac_no').length;
        var html = '<tr>';
        html += '<td>';
        html += '<input name="ac_no[' + file_i + ']" id="ac" type="text" class="description-input ac_no" >';
        html += '</td>';
        html += '<td>';
        html += '<input name="party_name[' + file_i + ']" id="party" type="text" class="description-input party_name" >';
        html += '</td>';
        html += '<td>';
        html += '<input name="remark[' + file_i + ']" id="remrk" type="text" class="description-input remark">';
        html += '</td>';
        html += '<td>';
        html += '<button class="btn btn-danger remove" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>';
        html += '</td>';
        html += '</tr>';
        $('table tbody').append(html);
    });
    $(document).on('click', '.remove', function () {
        $(this).parents('tr').remove();
    });
</script>