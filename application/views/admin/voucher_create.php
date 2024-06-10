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
                <li class="active">Add Voucher</li>
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
                            <div class="trans-table-head"><h4>Add Voucher</h4></div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-4 control-label">Vch. Type<span>:</span></label>                                                    
                                        <div class="col-lg-5">
                                             <input type="text" name="vch_type" class="form-control" value="Journal">   
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-3 control-label">Vch. No<span>:</span></label>                                                    
                                        <div class="col-lg-6">
                                            <input type="text" name="vch_no" class="form-control" value="<?php if (!empty($idresults->vch_no)) { echo $idresults->vch_no + 1; } else { $count=0; echo $count+1; } ?>" >      
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-3 control-label">Date<span>:</span></label>                                                    
                                        <div class="col-lg-6">
                                            <input name="vch_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd"  value="<?php echo date('Y-m-d'); ?>"  type="text"  >                                                  
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
                            <table class="transactions-table trans-margin">
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th>Type</th>
                                        <th>Particulars</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
 <col width="100"></col>
                                    <col width="300"></col>
                                    <col width="5"></col>
                                    <col width="5" ></col>
                                    <col width="5" ></col>
                                    <tr>
                                        <td> <select name="type" id="type" class="form-control validate[required]">
                                                <option value="Dr">Dr</option>
                                                <option value="Cr">Cr</option>
                                            </select>
                                        </td>
                                           <td class="text-left"><select class="form-control chosen validate[required] input-height" name="particulars" id="particulars">
                                                <option value="">Select Particulars...</option>  
                                                <?php
                                                //foreach ($nameresults as $result) {
                                                    ?>
                                                    <!--<option value="<?php echo $result->name; ?>"><?php echo $result->name; ?></option>-->
                                                <?php //} 
                                                     foreach ($nl_results as $nlresult) {
                                                    ?>
                                                    <option value="<?php echo $nlresult->ledger_id; ?>"><?php echo $nlresult->name; ?></option>
                                                <?php } ?>
                                            </select>  
                                            </td>
                                       <td><input name="credit" id="credit" type="text" class="description-input validate[required]" ></td>
                                        <td><input name="debit" id="debit" type="text" class="description-input validate[required]" ></td>
                                        <td><input name="remarks" id="remarks" type="text" class="description-input"></td>
                                      
                                    </tr>
                                     <!--<tr>
                                        <td> <select name="type_two" id="type_two" class="form-control validate[required]">
                                                <option value="Cr">Cr</option>
                                                <option value="Dr">Dr</option>
                                            </select>
                                        </td>
                                         <td>
                                                <select class="form-control validate[required] input-height" name="particulars_two">
                                                <option value="">Select Particulars...</option>  
                                                <?php
                                             //   foreach ($nameresults as $result) {
                                                    ?>
                                                    <option value="<?php //echo $result->name; ?>"><?php //echo $result->name; ?></option>
                                                <?php// } ?>
                                            </select>  
                                            </td>
                                       <td><input name="credit_two" id="credit_two" type="text" class="description-input validate[required]" ></td>
                                        <td><input name="debit_two" id="debit_two" type="text" class="description-input validate[required]" ></td>
                                        <td><input name="remarks_two" id="remarks_two" type="text" class="description-input"></td>
                                        <!--<td> <button class="btn btn-success add_more add-btn" type="button"><i class="la la-plus"></i><i class="fa fa-plus" aria-hidden="true"></i>
                                            </button></td>
                                    </tr>-->
                                </tbody>
                            </table>
                            <div class="form-group narration">
                                <label class="col-lg-12">Narration <span>:</span></label>                                                    
                                <div class="col-lg-12">
                                    <textarea rows="4" cols="50"  type="text" name="narration"></textarea>
                                </div>
                            </div>
                             <input type="hidden" name="under" id="under">
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
<!-- /content area -->    
<!--<script>
    $(document).on('click', '.add_more', function () {
    var file_i = $('.particulars').length;
    var html = '<tr>';
    html += '<td>';
    html += '<select name="type[' + file_i + ']" id="type" class="form-control validate[required]"><option value="Dr">Dr</option><option value="Cr">Cr</option></select>';
    html += '</td>';
    html += '<td>';
    html += '<select class="form-control validate[required] input-height" name="particulrs[' + file_i + ']"><option value="">Select Particulars...</option><?php foreach ($nameresults as $result) { ?><option value="<?php echo $result->name; ?>"><?php echo $result->name; ?></option><?php } ?></select>';
    html += '</td>';
    html += '<td>';
    html += '<input name="credit[' + file_i + ']" id="creadit" type="text" class="description-input validate[required]" >';
    html += '</td>';
    html += '<td>';
    html += '<input name="debit[' + file_i + ']" id="debit" type="text" class="description-input validate[required]" >';
    html += '</td>';
    html += '<td>';
    html += '<input name="remarks[' + file_i + ']" id="remarks" type="text" class="description-input">';
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
</script>-->
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