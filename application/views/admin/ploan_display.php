<div class="content-wrapper">
    <!-- Page header -->                         
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i>       
                    <span class="text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">       
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>                            </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Entry</a></li>
                <li>Personal Loan</li>
                <li class="active">Personal Loan Display</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                         
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-3">
<!--                         <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn" value="Print"/>                                                         -->
                    </div>
                    <div class="col-md-9" style="float:right">
                        <div class="button-style-2 invoice-button add-btn">          
                            <a href="ploan_create">                                      
                                <span class="trans-icons-2 add-btn"></span>Create Personal Loan</a>        
                        </div>
                    </div>
                </div>
            </div>
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
                                }
                            </style>
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th style="padding: 10px 9px;">Loan No</th>
                                        <th>Loan Date</th>
                                        <th>Party Name</th>
                                        <th style="width: 17%;">Loan Amt ( GHS )</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($results as $result) {
                                        ?>
                                        <tr>
<!--                                            <td><?php echo $i; ?></td>-->
                                            <td style="width:15%;"><?php echo $result->loan_no; ?></td>
                                            <td style="width:15%;"><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></td>
                                            <?php $getname = $this->db->select('party_name')->get_where('parties',array('party_id'=>$result->party_name,'status!='=>'Trash'))->row();                                         ?>
                                            <td><?php echo $getname->party_name; ?></td>
                                            <td>GHS <?php echo moneyformat($result->loan_amount); ?></td>
                                            <td class="text-center">
                                                <a href="view_ploan?personal_loan_id=<?php echo $result->personal_loan_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>  <a href="edit_ploan?personal_loan_id=<?php echo $result->personal_loan_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="delete btn btn-tbl-delete btn-xs" href="<?php echo base_url(); ?>admin/delete_ploan/<?php echo $result->personal_loan_id; ?>" title="Delete" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o "></i></a>       
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
    <!-- /2 columns form --> 
</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3] //Your Colume value those you want
                    }

                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3] //Your Colume value those you want
                    }
                },
            ],
        });
    });
</script>



