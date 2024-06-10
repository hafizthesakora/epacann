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
                <li class="active">Edit Loan</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal" action="#" method="post" autocomplete="off">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a href="loan_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Edit Loan</h4></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Loan No</label>                                                    
                                        <div class="col-lg-7">
                                            <input type="text" name="loan_no" id="loan_no" class="form-control"  value="<?php echo $result->loan_no; ?>">       
                                        </div>
                                    </div>
                                   <div class="form-group">
                                        <label class="col-lg-4 control-label">Loan Date</label>                                                    
                                        <div class="col-lg-7"> 
                                            <div class="class input-group date">
                                                <input name="loan_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd"  value="<?php echo date('Y-m-d', strtotime($result->loan_date)); ?>" type="text"  >                                                    </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-lg-4 control-label">Party name</label>                                                    
                                        <div class="col-lg-7">  
                                            <select class="form-control chosen input-height" name="party_name">
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
                                        <div class="col-lg-7"> 
                                            <input type="text" name="loan_amount" id="loan" placeholder=""  value="<?php echo $result->loan_amount; ?>" class="form-control">                    
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Interest ( % )</label>                                                    
                                        <div class="col-lg-7">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-4">  
                                                    <input type="text" name="interest_per" id="interest" class="form-control" value="<?php echo $result->interest_per; ?>">                                          
                                                </div>
                                                <div class="col-md-8 col-xs-8"> 
                                                    <input type="text" name="interest" id="interest_per" class="form-control"  value="<?php echo $result->interest; ?>">                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Adv Interest (GHS
                                            )</label>                                                    
                                        <div class="col-lg-7">                                                 
                                            <input type="text" name="adv_interest" id="adv_int" placeholder=""  value="<?php echo $result->adv_interest; ?>" class="form-control">                                 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Other Charges (GHS
                                            )</label>                                                    
                                        <div class="col-lg-7">     
                                            <input type="text" name="other_charges" id="other_charges" placeholder=""  value="<?php echo $result->other_charges; ?>" class="form-control">                                     
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Pay From</label>                                                    
                                        <div class="col-lg-7"> 
                                            <input type="text" name="pay_from" placeholder=""  value="<?php echo $result->pay_from; ?>" class="form-control">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Remarks</label>                                                    
                                        <div class="col-lg-7">     
                                            <input type="text" name="remarks" placeholder=""  value="<?php echo $result->remarks; ?>" class="form-control">                                               
                                        </div>
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
                                                <th>Weight (g)</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center">1</td>
                                                <div  id="output" ></div><td><select multiple class="form-control validate[required] input-height chosen-select" name="name[]" id="item_name">
                                            <option value="">Select...</option>                                 
                                            <option selected="selected" value="<?php echo $result->name; ?>"><?php echo $result->name; ?></option>
                                            <?php
                                            foreach ($itemresults as $results) {
                                                ?>
                                                <option value="<?php echo $results->item_name; ?>"><?php echo $results->item_name; ?></option>
                                            <?php } ?>
                                                    </select></td>
                                                <td><input name="quantity" class="description-input" maxlength="255" type="number" step='0' type="text" value="<?php echo $result->quantity; ?>" id="products0EstimateproductDescription"  style="padding: 3px !important;"></td>
                                                <td><input name="weight" class="description-input validate[required]" value="<?php echo $result->weight; ?>"  style="padding: 3px !important;"></td>
                                                <td><input name="remark" class="description-input" maxlength="255" type="text" value="<?php echo $result->remark; ?>" id="products0EstimateproductDescription"></td>
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
    var calc =(Number($("#loan").val()) *  Number($("#interest").val()) * 30) / 36000;
    calc = parseFloat(calc).toFixed(2);
    $("#interest_per").val(calc);
    $("#loan_amount_id").val(Number($("#loan").val()) -  Number($("#adv_int").val()) - Number($("#other_charges").val()));
    }
    });
</script>
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
    #output{
        display: none;
        
    }
    </style>