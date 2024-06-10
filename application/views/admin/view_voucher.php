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
                <li class="active">View Voucher</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal" action="#" method="post">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a onclick="window.history.back();"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>View Voucher</h4></div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-4 control-label">Vch. Type<span>:</span></label>                                                    
                                        <div class="col-lg-5">
                                            <div class="view"><h5> <?php echo $result->vch_type; ?> </h5> </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-3 control-label">Vch. No<span>:</span></label>                                                    
                                        <div class="col-lg-6">
                                            <div class="view"><h5> <?php echo $result->vch_no; ?> </h5> </div>      
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-md-offset-1 col-lg-3 control-label">Date<span>:</span></label>                                                    
                                        <div class="col-lg-6">
                                            <div class="view"><h5> <?php echo date('d-m-Y',strtotime($result->vch_date)); ?> </h5> </div>                                                
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
                                    <tr>
                                        <td><div class="view"><h5> <?php echo $result->type; ?> </h5> </div>
                                        </td><?php $get=$this->db->select('name')->get_where('ledger',array('ledger_id'=>$result->particulars))->row(); ?>
                                           <td><div class="view">
                                                   <?php $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $result->particulars, 'status!=' => 'Trash'))->row(); ?>
                                                   <h5> <?php echo $getname->name; ?> </h5> </div> 
                                            </td>
                                       <td><div class="view"><h5> <?php echo $result->credit; ?> </h5> </div></td>
                                        <td><div class="view"><h5> <?php echo $result->debit; ?> </h5> </div></td>
                                        <td><div class="view"><h5> <?php if (!empty($result->remarks)) echo $result->remarks; else echo '-'; ?> </h5> </div></td>
                                      
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
                                    <div class="view"><h5> <?php echo $result->narration; ?> </h5> </div>
                                </div>
                            </div>
                             <input type="hidden" name="under" id="under">
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