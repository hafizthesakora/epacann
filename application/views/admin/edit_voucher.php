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
                <li><a href="voucher_display">Voucher</a></li>
                <li class="active">Edit Voucher</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal" action="#" method="post" autocomplete="off">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a href="voucher_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Edit Voucher</h4></div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-4 control-label">Vch. Type<span>:</span></label>                                                    
                                        <div class="col-lg-5">
                                             <input type="text" name="vch_type" class="form-control" value="Journal" value="<?php echo $result->vch_type; ?>" >   
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-3 control-label">Vch. No<span>:</span></label>                                                    
                                        <div class="col-lg-6">
                                            <input type="text" name="vch_no" class="form-control" value="<?php echo $result->vch_no; ?>"  >         
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-3 control-label">Date<span>:</span></label>                                                    
                                        <div class="col-lg-6">
                                            <input name="vch_date" class="form-control validate[required]" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($result->vch_date)); ?>"   type="text"  >                                                  
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                </div>
                </fieldset>
            </div>
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="trans-table">
                            <div class="form-group narration">
                                <label class="col-lg-12">Narration <span>:</span></label>                                                    
                                <div class="col-lg-12">
                                    <textarea rows="4" cols="50"  type="text" name="narration"><?php echo $result->narration; ?></textarea>
                                </div>
                            </div>
                            <table class="transactions-table trans-margin">
                                <thead class="transactions-table-head">
                                    <tr>
                                         <th>Type</th>
                                        
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Remarks</th>
                                        <th>Particulars</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                         <td> <select name="type" id="type" class="form-control validate[required]">
                                                <option value="<?php echo $result->type; ?>" ><?php echo $result->type; ?></option>
                                                <option value="Dr">Dr</option>
                                                <option value="Cr">Cr</option>
                                            </select>
                                        </td>
                                        
                                       <td><input name="credit" value="<?php echo $result->credit ?>" id="credit" type="text" class="description-input validate[required]" ></td>
                                        <td><input name="debit" id="debit" type="text" class="description-input validate[required]" value="<?php echo $result->debit ?>"  ></td>
                                        <td><input name="remarks" id="remarks" type="text" class="description-input" value="<?php echo $result->remarks?>"></td>
                                       <td><select class="form-control chosen validate[required] input-height" name="particulars" id="particulars">
                                                <option value="">Select Particulars...</option>
                                                <?php 
                                                $getname=$this->db->select('*')->get_where('ledger', array('ledger_id'=>$result->particulars,'status != ' => 'Trash'))->row(); 
                                                // print_r($getname);exit; ?> 
                                                <option selected="selected" value="<?php echo $getname->ledger_id; ?>"><?php echo $getname->name; ?></option>
                                                <?php
                                              //  foreach ($nameresults as $result) {
                                                    ?>
                                                    <!--<option value="<?php echo $result->group_name; ?>"><?php echo $result->group_name; ?></option>-->
                                                <?php //} 
                                                     foreach ($nl_results as $nlresults) {  
                                                    if($nlresults->name != $result->group_name){?>
                                                    <option value="<?php echo $nlresults->ledger_id; ?>"><?php echo $nlresults->name; ?></option>
                                                     <?php } } ?>
                                            </select>  
                                            </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                             <input type="hidden" name="under" id="under" value="<?php echo $result->under ?>" >
                        </div>
                    </div>
                    <div class="submit-buttons-wrapper row-fluid">
                        <div class="span12 align-center">
                            <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Submit </button>
                        </div>
                    </div>
                </div>      
            </div>   
        </form>
    </div>
    <!-- /2 columns form -->
</div>
<script>
    $('#particulars').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/store_category')?>",
            data: 'particulars=' + $(this).val(),
            dataType: "json",
            success: function (data) {
                $('#under').val(data.under);
                alert('Balance is ' + data.balance); 
             }
        });
    });
</script>