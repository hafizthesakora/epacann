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
                <li>Ledger Category</li>
                <li class="active">Ledger Category Display</li>
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
                            <a href="add_ledgercategory">  
                                <span class="trans-icons-2"></span>Create Ledger Category</a>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="pane-search">
                <div class="table-responsive">   
                   <div class="trans-table-display">
                        <!-- <div class="trans-table">-->
                        <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example4">
                            <thead class="transactions-table-head">
                                <tr>
                                    <th>#</th>
                                    <th class="text-left" style="width: 89%;">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($results as $result) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td class="text-left"><?php echo $result->name; ?></td>
<!--                                        <td class="text-center">
                                            <a href="edit_ledgercategory?ledgercat_id=<?php echo $result->ledgercat_id; ?>" class="btn btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="delete btn btn-tbl-delete btn-xs" href="<?php echo base_url(); ?>admin/delete_ledgercategory/<?php echo $result->ledgercat_id; ?>" title="Delete" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o "></i></a>       
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
