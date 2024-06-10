 <?php $date = $this->input->get('date');?>
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
                <li>Voucher</li>
                <li class="active">Voucher Display</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-3">
<!--                        <input type="button" onclick="printDiv('table')" class="button-style-2 submit-btn" value="Print"/>                                -->
                    </div>
                    <div class="col-md-9" style="float:right">
                        <div class="button-style-2 invoice-button add-btn"> 
                            <a href="voucher_create">  
                                <span class="trans-icons-2"></span>Create Voucher</a>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="pane-search">
                    <!--Serach form-->
                    <div class="table-responsive">

                        <div class="trans-table-display">
                            <form action="" method="get" id="search"  autocomplete="off">
                                <div class="col-md-12">
                                    <div class="form-group"  style="float:right">
                                        <label class="col-lg-3 control-label">Date<span>:</span></label>                                                    
                                        <div class="col-lg-9">
                                            <input id="vch_date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd" type="text" name="date" value="<?php echo (!empty($date)) ? $date : "Choose Date" ?>">                                                  
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example">
                                  <style type="text/css">
                                @media print {
                                   
                                    tr{
                                        border:1px solid #ccc;
                                    }
                                     a[href]:after {
                                                content: none !important;
                                            }
                                }
                            </style>
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th>#</th>
                                        <!--<th>Vch. No</th>-->
                                        <th>Date</th>
                                        <th>Particulars</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Debit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php 
                                if ($date == '') {
                                    ?>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($results as $result) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <!--<td><?php echo $result->vch_no; ?></td>-->
                                                <td style="width: 6%;"><?php echo date('d-m-Y', strtotime($result->vch_date)); ?></td>
        <?php $getname = $this->db->get_where('ledger', array('ledger_id' => $result->particulars, 'status != ' => 'Trash'))->row(); ?>
                                                <td style="width: 30%;"><?php echo $getname->name; ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat( $result->credit); ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat( $result->debit); ?></td>
                                                <td class="text-center">
                                                    <a href="view_voucher?voucher_id=<?php echo $result->voucher_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="edit_voucher?voucher_id=<?php echo $result->voucher_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="delete btn btn-tbl-delete btn-xs" href="<?php echo base_url(); ?>admin/delete_voucher/<?php echo $result->voucher_id; ?>" title="Delete" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o "></i></a>       
                                                </td>
                                            </tr>    
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                <?php
                                } else { ?>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($dateresults as $dateresult) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <!--<td><?php echo $dateresult->vch_no; ?></td>-->
                                                <td style="width: 6%;"><?php echo date('d-m-Y', strtotime($dateresult->vch_date)); ?></td>
        <?php $getname = $this->db->get_where('ledger', array('ledger_id' => $dateresult->particulars, 'status != ' => 'Trash'))->row(); ?>
                                                <td style="width: 30%;"><?php echo $getname->name; ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat( $dateresult->credit); ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat( $dateresult->debit); ?></td>
                                                <td class="text-center">
                                                    <a href="view_voucher?voucher_id=<?php echo $dateresult->voucher_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="edit_voucher?voucher_id=<?php echo $dateresult->voucher_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="delete btn btn-tbl-delete btn-xs" href="<?php echo base_url(); ?>admin/delete_voucher/<?php echo $dateresult->voucher_id; ?>" title="Delete" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o "></i></a>        </tr>    
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
<?php } ?>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /2 columns form -->            
</div>
<!-- /content area -->    
<!--<script>
    $('#vch_date').change(function() {
        $.ajax({
            url: "<?php echo base_url('admin/voucher_date_filter') ?>",
            data: 'vch_date=' + $(this).val(),
            dataType: "json",
            success: function (data) {
                  $('#table').val(data);
             
            }
        });
    });
</script>-->
<script>
    $('#vch_date').change(function () {
        $('#search').submit();
    });
</script>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] //Your Colume value those you want
                    }

                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] //Your Colume value those you want
                    }
                },
            ],
        });
    });
</script>
