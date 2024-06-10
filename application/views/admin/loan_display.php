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
                <li>Loans</li>
                <li class="active">Loan Display</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-9" style="float:right">
                        <div class="button-style-2 invoice-button add-btn"> 
                            <a href="create_loan">  
                                <span class="trans-icons-2"></span>Create Loan</a>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="pane-search">
                    <div class="table-responsive">
                        <div class="trans-table-display">
                            <table class="transactions-table trans-margin table-striped table-bordered dataTable display" id="example">
                                <style type="text/css">
                                    @media buttons-print {

                                        tr{
                                            border:1px solid #ccc;
                                        }
                                        a[href]:after {
                                            content: none !important;
                                        }
                                        .hidden-print {
                                            display:none;
                                        }
                                        td {
                                            border: 1px solid #bad8b0 !important;
                                        }
                                    }
                                </style>
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th>#</th>
                                        <th>Loan No</th>
                                        <th>Loan Date</th>
                                        <th>Party Name</th>
                                        <th class="text-right">Loan Amt (GHS )</th>
                                        <th class="hidden-print">Int Per (%)</th>
                                       <!-- <th>Int Amt</th>-->
                                        <th class="text-right hidden-print">Adv Int Amt (GHS )</th>
                                        <th class="text-right hidden-print">Other Amt (GHS )</th>
                                        <th class="hidden-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->load->helper('app_helper');
                                    $i = 1;
                                     $loan_tot = 0;
                                    foreach ($results as $result) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $result->loan_no; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></td>
                                            <?php $getname = $this->db->order_by('party_id', "asc")->select('party_name')->get_where('parties', array('party_id' => $result->party_name, 'status !=' => 'Trash'))->row();
                                            ?><td><?php echo $getname->party_name; ?></td>
                                            <td class="text-right">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                            <td class="hidden-print"><?php echo $result->interest_per; ?></td>
                                            <td class="text-right hidden-print">GHS <?php echo moneyformat($result->adv_interest) ?></td>
                                            <td class="text-right hidden-print">GHS <?php echo $result->other_charges; ?></td>
                                            <td class="text-center hidden-print">
                                                <a href="view_loan?loan_id=<?php echo $result->loan_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="edit_loan?loan_id=<?php echo $result->loan_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="delete btn btn-tbl-delete btn-xs" href="<?php echo base_url(); ?>admin/delete_loan/<?php echo $result->loan_id; ?>" title="Delete" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o "></i></a>       
                                            </td>
                                        </tr>    
                                        <?php
                                        $i++;
                                         $loan_tot += $result->loan_amount;
                                    }
                                    ?>
                                </tbody>
                                <tfoot align="right">
                                        <tr class="foot"><td colspan="4" class="text-center"><b>Total</b></td>
                                            <td class="text-right"> GHS <b><?php echo moneyformat($loan_tot) ?></b></td>
                                            <td colspan="4"></td>
                                    </tfoot>
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
