<?php $get = $this->input->get('date');
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
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>                            </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href=""><i class="icon-home2 position-left"></i>Report</a></li>
                <li>Loan Pending</li>
                <li class="active">Loan Pending Summary</li>
            </ul>
            <form action="" method="get" id="search"  autocomplete="off">
                <div class="form-group"  style="float:right">
                    <label class="col-lg-3 control-label">Date<span>:</span></label>                                                    
                    <div class="col-lg-9">
                        <input id="date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd" type="text" name="date"  value="<?php echo (!empty($get)) ? $get : date('Y-m-d') ?>" >                                                  
                    </div>
                </div>
            </form>
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
                            <div class="" >
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
                                    <style type="text/css">
                                        @media print {
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
                                    <thead class="transactions-table-head" >
                                        <tr>
                                            <th>#</th>
                                            <th>Loan No</th>
                                            <th>Loan Date</th>
                                            <th>Party Name</th>
                                            <th style="text-align: right;">Loan Amt (GHS )</th>
                                            <th style="text-align: right;">Bal Loan (GHS )</th>
                                            <th style="text-align: right;">Led Bal (GHS )</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (!empty($get)) {
                                        ?>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $loan_tot = 0;
                                            $bal_tot = 0;
                                            foreach ($results as $result) {
                                                $check_details = $this->db->order_by('receipt_id',"desc")->group_by('loan_no')->get_where('receipts', array('receipt_date<='=>$get,'loan_no' => $result->loan_no, 'ac_close' => 'Yes', 'status !=' => 'Trash'))->result();
                                                //print_r($details);
                                                if (!empty($check_details)) {
                                                    continue;
                                                }
                                                $details = $this->db->order_by('receipt_id',"desc")->get_where('receipts', array('receipt_date<='=>$get,'loan_no' => $result->loan_no, 'status !=' => 'Trash'))->row();
                                                $tdy = date_create(date('Y-m-d'));
                                                $date = date_create($result->loan_date);
                                                $diff = date_diff($tdy, $date);
                                                $d_diff = $diff->format("%R%a");
                                                if ($d_diff < '-365') {
                                                    ?>
                                                    <tr style="background: #ffbf08 !important;">
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $result->loan_no; ?></td>
                                                         <?php if(!empty($details)) { ?>
                                                        <td><a href="edit_receipt?receipt_id=<?php echo $details->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></a></td>
                                                        <?php } else { ?>
                                                        <td><a href="edit_loan?loan_id=<?php echo $result->loan_id; ?>" ><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></a></td>
                                                        <?php } ?>
                                                        <?php $getname = $this->db->select('party_name')->get_where('parties', array('party_id' => $result->party_name, 'status!=' => 'Trash'))->row();
                                                        ?>
                                                        <td style="width:150px"><?php echo $getname->party_name; ?></td>
                                                        <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                                        <td style="text-align: right;">
                                                            GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount); ?></td>    
                                                        <td style="text-align: right;">
                                                            GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount); ?></td> 
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $result->loan_no; ?></td>
                                                         <?php if(!empty($details)) { ?>
                                                        <td><a href="edit_receipt?receipt_id=<?php echo $details->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></a></td>
                                                        <?php } else { ?>
                                                        <td><a href="edit_loan?loan_id=<?php echo $result->loan_id; ?>" ><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></a></td>
                                                        <?php } ?>
                                                        <?php $getname = $this->db->select('party_name')->get_where('parties', array('party_id' => $result->party_name, 'status!=' => 'Trash'))->row();
                                                        ?>
                                                        <td style="width:150px"><?php echo $getname->party_name; ?></td>
                                                        <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                                        <td style="text-align: right;">
                                                            GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount); ?></td>    
                                                        <td style="text-align: right;">
                                                            GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount); ?></td> 
                                                    </tr>
                                                    <?php
                                                }
                                                $i++;
                                                $loan_tot += $result->loan_amount;
                                                if (!empty($details)) {
                                                    $bal_tot += $details->bal_loan_amt;
                                                } else {
                                                    $bal_tot += $result->loan_amount;
                                                }
                                            }
                                            ?>
                                        <tfoot align="right">
                                            <tr class="foot"><td colspan="4" class="text-center"><b>Total</b></td><td class="text-right"> GHS <b><?php echo moneyformat($loan_tot) ?></b></td>
                                                <td class="text-right"> GHS <b><?php echo moneyformat($bal_tot) ?></b></td>
                                                <td class="text-right"> GHS <b><?php echo moneyformat($bal_tot) ?></b></td></tr>
                                        </tfoot>
                                        </tbody>
                                    <?php } else { ?>
                                        <tbody >
                                            <?php
                                            $i = 1;
                                            $loan_tot = 0;
                                            $bal_tot = 0;
                                            foreach ($results as $result) {
                                                $details = $this->db->order_by("receipt_id", "desc")->get_where('receipts', array('loan_no' => $result->loan_no, 'status !=' => 'Trash'))->row();
                                                if (!empty($details) && $details->ac_close == 'Yes') {
                                                    continue;
                                                }
                                                $tdy = date_create(date('Y-m-d'));
                                                $date = date_create($result->loan_date);
                                                $diff = date_diff($tdy, $date);
                                                $d_diff = $diff->format("%R%a");
                                                if ($d_diff < '-365') {
                                                    ?>
                                                    <tr style="background: #ffbf08 !important;">
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $result->loan_no; ?></td>
                                                        <td><a href="edit_loan?loan_id=<?php echo $result->loan_id; ?>" ><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></a></td>
                                                        <?php $getname = $this->db->select('party_name')->get_where('parties', array('party_id' => $result->party_name, 'status!=' => 'Trash'))->row();
                                                        ?>
                                                        <td style="width:150px"><?php echo $getname->party_name; ?></td>
                                                        <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                                        <td style="text-align: right;">
                                                            GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount); ?></td>    
                                                        <td style="text-align: right;">
                                                            GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount); ?></td> 
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $result->loan_no; ?></td>
                                                        <td><a href="edit_loan?loan_id=<?php echo $result->loan_id; ?>" ><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></a></td>
                                                        <?php $getname = $this->db->select('party_name')->get_where('parties', array('party_id' => $result->party_name, 'status!=' => 'Trash'))->row();
                                                        ?>
                                                        <td style="width:150px"><?php echo $getname->party_name; ?></td>
                                                        <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                                        <td style="text-align: right;">
                                                            GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount); ?></td>    
                                                        <td style="text-align: right;">
                                                            GHS <?php echo (!empty($details)) ? moneyformat($details->bal_loan_amt) : moneyformat($result->loan_amount); ?></td> 
                                                    </tr>
                                                    <?php
                                                }
                                                $i++;
                                                $loan_tot += $result->loan_amount;
                                                if (!empty($details)) {
                                                    $bal_tot += $details->bal_loan_amt;
                                                } else {
                                                    $bal_tot += $result->loan_amount;
                                                }
                                            }
                                            ?>
                                        <tfoot align="right">
                                            <tr class="foot"><td colspan="4" class="text-center"><b>Total</b></td><td class="text-right"> GHS <b><?php echo moneyformat($loan_tot) ?></b></td>
                                                <td class="text-right"> GHS <b><?php echo moneyformat($bal_tot) ?></b></td>
                                                <td class="text-right"> GHS <b><?php echo moneyformat($bal_tot) ?></b></td></tr>
                                        </tfoot>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = '<h2>Kundrakudian Finance</h2><h6>540, South car street ,</h6><h6>Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;"><b>As on date</b> :  <?php echo (!empty($get)) ? $get : date('d-m-Y'); ?></h6><br><h5 class="text-right" style="position:absolute; top:80px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h5><h3 class="text-center">Loan Pending</h3><table>' + document.getElementById(divName).innerHTML + '</table>';
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    title: '<h2>Kundrakudian Finance</h2><h6>540, South car street ,</h6><h6>Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;"><b>As on date</b> :  <?php echo (!empty($get)) ? $get : date('d-m-Y'); ?></h6><br><h5 class="text-right" style="position:absolute; top:80px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h5><h3 class="text-center">Loan Pending</h3>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want
                    }
                },
                {
                    extend: 'excel',
                    title: '<h2>Kundrakudian Finance</h2><h6>540, South car street ,</h6><h6>Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;"><b>As on date</b> :  <?php echo (!empty($get)) ? $get : date('d-m-Y'); ?></h6><br><h5 class="text-right" style="position:absolute; top:80px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h5><h3 class="text-center">Loan Pending</h3>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want
                    }
                },
            ],
        });
    });
</script>
<script>
    $('#date').change(function () {
        $('#search').submit();
    });
</script>
