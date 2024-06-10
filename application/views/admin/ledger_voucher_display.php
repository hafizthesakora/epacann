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
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Accounts</a></li>
                <li>Ledger</li>
                <li class="active">Ledger Vouchers</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                 <fieldset>
                  <legend style="margin-bottom:unset ;">
                        <div class="button-style-2 invoice-button back-btn">
                            <a onclick="window.history.back();"><span class="trans-icons-3"></span>Back</a>     
                        </div>
                    </legend>
                <div class="pane-search">
                    <div class="table-responsive">   
                        <div class="trans-table-display">
                            <!-- <div class="trans-table">-->
                            <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example">
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th class="text-right">Credit (GHS )</th>
                                        <th class="text-right">Debit (GHS )</th>
                                        <th class="text-right">Balance (GHS )</th>
                                         </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $balance=0;
                                    $i = 1;
                                   foreach ($vch_details as $result) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($result->vch_date)); ?></td>
                                            <td class="text-right">GHS <?php echo  moneyformat($result->credit); ?></td>
                                            <td class="text-right">GHS <?php echo  moneyformat($result->debit) ?></td>
                                          <?php 
                                          $balance += $result->credit - $result->debit;
                                          ?> 
                                            <td class="text-right">GHS <?php echo moneyformat($balance) ?></td>
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
                      </fieldset>
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
