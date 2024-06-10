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
                <li><a href=""><i class="icon-home2 position-left"></i>Report</a></li>
                <li>A/C Closed List</li>
                <li class="active">Replace Loan Closed List</li>
            </ul>
            <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn print" value="Print"/>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="pane-search">
                    <div class="table-responsive">   
                        <div class="trans-table-display">
                            <!-- <div class="trans-table">-->
                            <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example4">
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
                                        <th style="width: 35% !important;">Bank Loan No</th>
                                        <th>Bank Name</th>
                                        <th>Loan Date</th>
                                        <th>Closed Date</th>
                                        <th>Loan Amt (GHS )</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($results as $result) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $result->bank_loan_no; ?></td>
                                            <?php $getbname=$this->db->get_where('banks',array('bank_id'=>$result->bank_name ,'status !='=>'Trash'))->row(); ?>
                                            <td><?php echo $result->bank_name; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></td>
                                            <td style="width:15%;"><?php echo date('d-m-Y', strtotime($result->pymt_date)); ?></td> 
                                            <td class="text-right" style="width:15%;">GHS <?php echo moneyformat($result->loan_amount); ?></td>
        <!-- <td style="text-align: center">
               <a href="view_loan?loan_id=<?php // echo $result->loan_id;    ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
        <a href="edit_loan?loan_id=<?php //echo $result->loan_id;    ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
               <a class="delete btn btn-tbl-delete btn-xs" href="<?php //echo base_url();    ?>admin/delete_loan/<?php //echo $result->loan_id;    ?>" title="Delete" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o "></i></a>       
           </td>-->
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
    <!-- /2 columns form -->
</div>
