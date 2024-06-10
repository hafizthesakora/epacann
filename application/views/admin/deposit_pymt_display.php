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
                <li>Deposit Payment</li>
                <li class="active">Deposit Payment Display</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-3">
<!--                        <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn" value="Print"/>       -->
                    </div>
                    <div class="col-md-9" style="float:right">
                        <div class="button-style-2 invoice-button add-btn">
                            <a href="deposit_pymt_create">
                                <span class="trans-icons-2"></span>Create Deposit Payment</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="pane-search">
                    <!--Serach form-->
                    <div class="table-responsive">   
                        <div class="trans-table-display">
                            <!-- <div class="trans-table">-->
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
                                        <th>Pymt No</th>
                                        <th>Pymt Date</th>
                                        <th>Dep No</th>
                                        <th>Party Name</th>
                                        <th class="text-right">Dep Amt (GHS )</th>
                                        <th class="text-right">Int Amt (GHS )</th>
                                        <th class="text-right">Less Amt (GHS )</th>
                                        <th class="text-right">Paid Int (GHS )</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($results as $result) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $result->pymt_no; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($result->pymt_date)); ?></td>
                                            <td><?php echo $result->dep_no; ?></td>
                                            <td><?php echo $result->party_name; ?></td>
                                            <td class="text-right">GHS <?php echo $result->dep_amt; ?></td>
                                            <td class="text-right">GHS <?php echo $result->int_amt; ?></td>
                                            <td class="text-right">GHS <?php echo moneyformat($result->add_less) ?></td>
                                            <td class="text-right">GHS <?php echo $result->paid_int_amt; ?></td>
                                           <td style="text-align: center">
                                               <a href="edit_dep_pymt?pymt_id=<?php echo $result->pymt_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                                 <a href="view_dep_pymt?pymt_id=<?php echo $result->pymt_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                  <!--<a class="delete btn btn-tbl-delete btn-xs" href="<?php echo base_url(); ?>admin/delete_loan/<?php echo $result->loan_id; ?>" title="Delete" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o "></i></a>-->       
                                            </td>
                                        </tr>    
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>	
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /2 columns form -->
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5] //Your Colume value those you want
                    }

                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5] //Your Colume value those you want
                    }
                },
            ],
        });
    });
</script>