<?php  $getdate = $this->input->get('date');
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
                <li><a href=""><i class="icon-home2 position-left"></i>Entry</a></li>
                <li>Loan Pending</li>
                <li class="active">Replace Loan Pending Summary </li>
            </ul>
            <form action="" method="get" id="search"  autocomplete="off">
                <div class="form-group"  style="float:right">
                    <label class="col-lg-3 control-label">Date<span>:</span></label>                                                    
                    <div class="col-lg-9">
                        <input id="date" class="form-control validate[required] datepicker" data-date-format="yyyy-mm-dd" type="text" name="date"  value="<?php echo (!empty($getdate)) ? $getdate : date('Y-m-d')?>" >                                                 
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
                            <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example">
                                <style type="text/css">
                                    @media print {

                                        tr{
                                            border:1px solid #ccc;
                                        }
                                        a[href]:after {
                                            content: none !important;
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
                                        .date-size{
                                            width:150px;
                                        }
                                    </style>
                                    <thead class="transactions-table-head">
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Bank Name / No</th>
                                            <th>Party No</th>
                                            <th style="width: 20% !important;">Party Name</th>
                                            <th style="text-align: right;">Loan Amt (GHS )</th>
                                            <th>Remarks</th>

                                        </tr>
                                    </thead>
                                    <?php  if (!empty($getdate)) { ?>
                                    <tbody>
                                        <?php
                                        $loan_tot = 0;
                                        $bal_tot = 0;
                                        $i = 1;
                                        foreach ($results as $result) {
                                            $tdy = date_create(date('Y-m-d'));
                                            $date = date_create($result->date);
                                            $diff = date_diff($tdy, $date);
                                            $d_diff = $diff->format("%R%a");
                                           //  print_r($getdate);
                                            $details = $this->db->order_by("replace_payment_id", "desc")->get_where('replace_payments', array('pymt_date<='=>$getdate ,'bank_loan_no' => $result->bank_loan_no, 'status !=' => 'Trash'))->row();
                                            if (!empty($details) && $details->ac_close == 'Yes') {
                                                continue;
                                            }

                                            if ($d_diff < '-365') {
                                                ?> <tr style="background: #d7f6a6 !important;">
                                                <?php
                                                $get = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $result->bank_name, 'status !=' => 'Trash'))->row();
                                                $getdetails = $this->db->select('*')->get_where('replaceloans_additional', array('replaceloan_id' => $result->replaceloan_id, 'status !=' => 'Trash'))->result();
                                                //print_r($result);exit;
                                                $num = '';
                                                $party = '';
                                                $remarks = '';
                                                foreach ($getdetails as $detres) {
                                                    $num .= '<p>' . $detres->ac_no . ',';
                                                    $party .= '<p>' . $detres->party_name . ',';
                                                    if ($detres->remark != '') {
                                                        $remarks .= '<p>' . $detres->remark . ',';
                                                    } else {
                                                        $remarks .= '-';
                                                    }
                                                }
                                                ?>
                                                    <td><?php echo $i; ?></td>
                                                    <td class="date-size" style="width:100px"><a href="edit_rep_loan?replaceloan_id=<?php echo $result->replaceloan_id; ?>" ><?php echo date('d-m-y', strtotime($result->date)); ?></a></td>
                                                    <td><?php echo $get->bank_name . " - " . $result->bank_loan_no; ?></td>
                                                    <td><?php echo rtrim($num, ','); ?></td>
                                                    <td class="party"><?php echo rtrim($party, ','); ?></td>
                                                    <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                                    <td><?php echo rtrim($remarks, ','); ?></td>  
                                                </tr>   <?php } else { ?>
                                                <tr>
                                                    <?php
                                                    $get = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $result->bank_name, 'status !=' => 'Trash'))->row();
                                                    $getdetails = $this->db->select('*')->get_where('replaceloans_additional', array('replaceloan_id' => $result->replaceloan_id, 'status !=' => 'Trash'))->result();
                                                    //print_r($result);exit;
                                                    $num = '';
                                                    $party = '';
                                                    $remarks = '';
                                                    foreach ($getdetails as $detres) {
                                                        $num .= '<p>' . $detres->ac_no . ',';
                                                        $party .= '<p>' . $detres->party_name . ',';
                                                        if ($detres->remark != '') {
                                                            $remarks .= '<p>' . $detres->remark . ',';
                                                        } else {
                                                            $remarks .= '-';
                                                        }
                                                    }
                                                    ?>
                                                    <td><?php echo $i; ?></td>
                                                    <td class="date-size" style="width:100px"><a href="edit_rep_loan?replaceloan_id=<?php echo $result->replaceloan_id; ?>" ><?php echo date('d-m-y', strtotime($result->date)); ?></a></td>
                                                    <td><?php echo $get->bank_name . " - " . $result->bank_loan_no; ?></td>
                                                    <td><?php echo rtrim($num, ','); ?></td>
                                                    <td class="party"><?php echo rtrim($party, ','); ?></td>
                                                    <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                                    <td><?php echo rtrim($remarks, ','); ?></td>  
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

                                    </tbody>
                                    <?php } else { ?>
                                    <tbody>
                                        <?php
                                        $loan_tot = 0;
                                        $bal_tot = 0;
                                        $i = 1;
                                        foreach ($results as $result) {
                                            $tdy = date_create(date('Y-m-d'));
                                            $date = date_create($result->date);
                                            $diff = date_diff($tdy, $date);
                                            $d_diff = $diff->format("%R%a");
                                            // print_r($d_diff);
                                            $details = $this->db->order_by("replace_payment_id", "desc")->get_where('replace_payments', array('','bank_loan_no' => $result->bank_loan_no, 'status !=' => 'Trash'))->row();
                                            if (!empty($details) && $details->ac_close == 'Yes') {
                                                continue;
                                            }

                                            if ($d_diff < '-365') {
                                                ?> <tr style="background: #d7f6a6 !important;">
                                                <?php
                                                $get = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $result->bank_name, 'status !=' => 'Trash'))->row();
                                                $getdetails = $this->db->select('*')->get_where('replaceloans_additional', array('replaceloan_id' => $result->replaceloan_id, 'status !=' => 'Trash'))->result();
                                                //print_r($result);exit;
                                                $num = '';
                                                $party = '';
                                                $remarks = '';
                                                foreach ($getdetails as $detres) {
                                                    $num .= '<p>' . $detres->ac_no . ',';
                                                    $party .= '<p>' . $detres->party_name . ',';
                                                    if ($detres->remark != '') {
                                                        $remarks .= '<p>' . $detres->remark . ',';
                                                    } else {
                                                        $remarks .= '-';
                                                    }
                                                }
                                                ?>
                                                    <td><?php echo $i; ?></td>
                                                    <td class="date-size" style="width:100px"><a href="edit_rep_loan?replaceloan_id=<?php echo $result->replaceloan_id; ?>" ><?php echo date('d-m-y', strtotime($result->date)); ?></a></td>
                                                    <td><?php echo $get->bank_name . " - " . $result->bank_loan_no; ?></td>
                                                    <td><?php echo rtrim($num, ','); ?></td>
                                                    <td class="party"><?php echo rtrim($party, ','); ?></td>
                                                    <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                                    <td><?php echo rtrim($remarks, ','); ?></td>  
                                                </tr>   <?php } else { ?>
                                                <tr>
                                                    <?php
                                                    $get = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $result->bank_name, 'status !=' => 'Trash'))->row();
                                                    $getdetails = $this->db->select('*')->get_where('replaceloans_additional', array('replaceloan_id' => $result->replaceloan_id, 'status !=' => 'Trash'))->result();
                                                    //print_r($result);exit;
                                                    $num = '';
                                                    $party = '';
                                                    $remarks = '';
                                                    foreach ($getdetails as $detres) {
                                                        $num .= '<p>' . $detres->ac_no . ',';
                                                        $party .= '<p>' . $detres->party_name . ',';
                                                        if ($detres->remark != '') {
                                                            $remarks .= '<p>' . $detres->remark . ',';
                                                        } else {
                                                            $remarks .= '-';
                                                        }
                                                    }
                                                    ?>
                                                    <td><?php echo $i; ?></td>
                                                    <td class="date-size" style="width:100px"><a href="edit_rep_loan?replaceloan_id=<?php echo $result->replaceloan_id; ?>" ><?php echo date('d-m-y', strtotime($result->date)); ?></a></td>
                                                    <td><?php echo $get->bank_name . " - " . $result->bank_loan_no; ?></td>
                                                    <td><?php echo rtrim($num, ','); ?></td>
                                                    <td class="party"><?php echo rtrim($party, ','); ?></td>
                                                    <td style="text-align: right;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                                    <td><?php echo rtrim($remarks, ','); ?></td>  
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

                                    </tbody>
                                    <?php } ?>
                                    <tfoot align="right">
                                        <tr class="foot"><td colspan="4" class="text-center"><b>Total</b></td><td> GHS <b><?php echo moneyformat($loan_tot) ?></b></td>
                                            <td> GHS <b><?php echo moneyformat($bal_tot) ?></b></td>
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
                        title: '<h2>Kundrakudian Finance</h2><h6>540, South car street ,</h6><h6>Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;"><b>As on date</b> :  <?php echo (!empty($getdate)) ? $getdate : date('d-m-Y');?></h6><br><h5 class="text-right" style="position:absolute; top:80px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h5><h3 class="text-center">Replace Pending</h3>',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] //Your Colume value those you want
                        }

                    },
                    {
                        extend: 'excel',
                title: '<h2>Kundrakudian Finance</h2><h6>540, South car street ,</h6><h6>Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;"><b>As on date</b> :  <?php echo (!empty($getdate)) ? $getdate : date('d-m-Y');?></h6><br><h5 class="text-right" style="position:absolute; top:80px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h5><h3 class="text-center">Replace Pending</h3>',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] //Your Colume value those you want
                        }
                    },
                ],
                "columnDefs": [
                    {"width": "10px", "targets": 0},
                    {"width": "40px", "targets": 1},
                    {"width": "100px", "targets": 2},
                    {"width": "70px", "targets": 3},
                    {"width": "70px", "targets": 4},
                    {"width": "70px", "targets": 5},
                    {"width": "70px", "targets": 6}
                ],
            });
        });
    </script>
    <script>
        $('#date').change(function () {
            $('#search').submit();
        });
    </script>
