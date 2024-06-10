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
                <li>Loan Pending</li>
                <li class="active">PLoan Pending Summary</li>
            </ul>
<!--            <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn print" value="Print"/>-->
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <div class="panel panel-flat">
            
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
                                        <th>Loan No</th>
                                        <th>Loan Date</th>
                                        <th style="width: 20% !important;">Party Name</th>
                                        <th style="text-align: right;">Loan Amt (GHS )</th>
                                        <th style="text-align: right;">Bal Loan (GHS )</th>
                                        <th style="text-align: right;">Led Bal (GHS )</th>
                                    </tr>
                            </thead>
                             <tbody>
                                    <?php
                                    $i = 1;
                                     $loan_tot = 0;
                                        $bal_tot = 0;
                                     foreach ($results as $result) {
                                        $details = $this->db->order_by("receipt_id", "desc")->get_where('personalloan_receipts', array('loan_no' => $result->loan_no , 'status !=' => 'Trash'))->row();
                                      if (!empty($details) && $details->ac_close == 'Yes') {
                                            continue;
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $result->loan_no; ?></td>
                                            <td><a href="view_ploan?personal_loan_id=<?php echo $result->personal_loan_id; ?>"><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></a></td>
                                             <?php $getname = $this->db->select('party_name')->get_where('parties',array('party_id'=>$result->party_name,'status!='=>'Trash'))->row();                                        
                                    ?>
                                            <td><?php echo $getname->party_name; ?></td>
                                            <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                           <td style="text-align: right;">
                                                GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt ) : moneyformat($result->loan_amount);?></td>    
                                       <td style="text-align: right;">
                                                GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount);?></td> 
                                        </tr>    
                                        <?php
                                        $i++;
                                         $loan_tot += $result->loan_amount;
                                            if (!empty($details)) {
                                                $bal_tot += $details->bal_loan_amt;
                                            } else {
                                                $bal_tot += $result->loan_amount;
                                            }
                                    }
                                    ?>
                                </tbody>
                                <tfoot align="right">
                                        <tr class="foot"><td colspan="4" class="text-center"><b>Total</b></td><td class="text-right"> GHS <b><?php echo moneyformat($loan_tot) ?></b></td>
                                            <td class="text-right"> GHS <b><?php echo moneyformat($bal_tot) ?></b></td>
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

