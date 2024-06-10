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
                <li><a href=""><i class="icon-home2 position-left"></i>Report</a></li>
                <li>Loan Pending</li>
                <li class="active">Deposit Pending Summary</li>
            </ul>
<!--            <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn print" value="Print"/>-->
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <div class="panel panel-flat">
            <!--<div class="panel-heading">
                <div class="row">
                    <div class="col-md-3">
            <!--<h5 class="panel-title">Loan Display</h5>-->                              
            <!-- </div>
             <div class="col-md-9" style="float:right">
                 <div class="button-style-2 invoice-button add-btn"> 
                     <a href="create_deposit">  
                         <span class="trans-icons-2"></span>Create Deposit</a>    
                 </div>
             </div>
         </div>
     </div>-->
            <div class="panel-body">
                <div class="pane-search">
                    <!--Serach form-->  
                    <div class="table-responsive">
                        <div class="trans-table-display">
                            <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example">
                                <style type="text/css">
                                    @media print {

                                        tr{
                                            border:1px solid #ccc;
                                        }
                                        a[href]:after {
                                            content: none !important;
                                        }
                                        table{
                                            table-layout: fixed;

                                        }
                                        td{
                                            font-size:9px;
                                        }
                                        tfoot> tr:nth-child{
                                            display:none;
                                        }
                                        tfoot > tr:last-child{
                                            display:table-row;
                                        }
                                    }
                                </style>
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th>#</th>
                                        <th>SUSU No</th>
                                        <th>SUSU Date</th>
                                        <th>Party Name</th>
                                        <th class="text-right">Dep Amt (GHS )</th>
                                        <th class="text-right">Bal Amount (GHS )</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $loan_tot = 0;
                                    $bal_tot = 0;
                                    foreach ($results as $result) {
                                        $details = $this->db->order_by("pymt_id", "desc")->get_where('deposit_payments', array('dep_no' => $result->dep_no, 'status !=' => 'Trash'))->row();
                                        // print_r($result);
                                        if (!empty($details) && $details->ac_close == 'Yes') {
                                            continue;
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $result->dep_no; ?></td>
                                            <td><a href="view_deposit?deposit_id=<?php echo $result->deposit_id; ?>"><?php echo date('d-m-Y', strtotime($result->dep_date)); ?></a></td>
                                            <?php $getname = $this->db->select('party_name')->get_where('deposit_parties', array('dep_party_id' => $result->party_name, 'status!=' => 'Trash'))->row();
                                            ?>
                                            <td><?php echo $getname->party_name; ?></td>
                                            <td class="text-right">GHS <?php echo moneyformat($result->dep_amount); ?></td>
                                            <td class="text-right">
                                                GHS <?php echo (!empty($details)) ? moneyformat($details->bal_dep_amt) : moneyformat($result->dep_amount); ?></td>    
                                        </tr>    
                                        <?php
                                        $i++;
                                         $loan_tot += $result->dep_amount;
                                            if (!empty($details)) {
                                                $bal_tot += $details->bal_dep_amt;
                                            } else {
                                                $bal_tot += $result->dep_amount;
                                            }
                                    }
                                    ?>
                                </tbody>
                                 <tfoot align="right">
                                        <tr class="foot"><td colspan="4" class="text-center"><b>Total</b></td><td class="text-right"> GHS <b><?php echo moneyformat($loan_tot) ?></b></td>
                                            <td class="text-right"> GHS <b><?php echo moneyformat($bal_tot) ?></b></td></tr>
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
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want
                    }

                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want
                    }
                },
            ],
        });
    });
</script>
