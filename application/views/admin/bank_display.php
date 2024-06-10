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
                <li><a href=""><i class="icon-home2 position-left"></i>Master</a></li>
                <li>Bank Name</li>
                <li class="active">Bank Display</li>
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
                        <!--<h5 class="panel-title">Loan Display</h5>-->
                    </div>
                    <div class="col-md-9" style="float:right">
                        <div class="button-style-2 invoice-button add-btn">
                            <a href="add_bankname">
                                <span class="trans-icons-2"></span>Add Bank</a>
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
                        <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example4">
                            <thead class="transactions-table-head">
                                <tr>
                                    <th>#</th>
                                    <th>Bank Name</th>
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
                                        <td style="width:50%"><?php echo $result->bank_name; ?></td>
                                        <td>
                                            <a href="view_bank?bank_id=<?php echo $result->bank_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
                                            </a><a href="edit_bank?bank_id=<?php echo $result->bank_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="delete btn btn-tbl-delete btn-xs" href="<?php echo base_url(); ?>admin/delete_bank/<?php echo $result->bank_id; ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o "></i></a>       
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
    <!-- /2 columns form -->
</div>
  </div>
              
