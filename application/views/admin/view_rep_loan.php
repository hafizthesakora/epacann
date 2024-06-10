<?php
$date = date('Y-m-d');
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
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Entry</a></li>
                <li><a href="replace_loan_display">Replace Loans</a></li>
                <li class="active">Add Replace Loan</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal form-validation" id="formID" action="#" method="post">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a onclick="window.history.back();"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Add Replace Loan</h4></div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-md-offset-3 col-lg-3 control-label">S.No</label>                                                    
                                        <div class="col-lg-5">
                                            <div class="view"><h5> <?php echo $result->sno; ?> </h5> </div>    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Bank Name</label>                                                    
                                        <div class="col-lg-5">
                                              <?php $getname=$this->db->select('bank_name')->get_where('banks',array('bank_id'=>$result->bank_name, 'status!='=>'Trash'))->row(); ?>
                                            <div class="view"><h5> <?php echo $getname->bank_name; ?> </h5> </div>   
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-md-offset-3 col-lg-3 control-label">Date</label>                                                    
                                        <div class="col-lg-5"> 
                                            <div class="view"><h5> <?php echo date('d-m-Y', strtotime($result->date)); ?> </h5> </div>
                                        </div>
                                    </div></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Bank Loan No</label>                                                    
                                        <div class="col-lg-5">
                                            <div class="view"><h5> <?php echo $result->bank_loan_no; ?> </h5> </div>    
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="trans-table">
                            <table class="transactions-table trans-margin">
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th>A/c No.</th>
                                        <th>Party Name</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                    $replaceloan_id = $this->input->get('replaceloan_id');

                                    $get = $this->db->select('*')->get_where('replaceloans_additional', array('replaceloan_id' => $replaceloan_id , 'status !='=>'Trash'))->result();
                                    foreach ($get as $res) {
                                        ?>
                                        <tr> 

                                           <td><div class="view"><h5> <?php echo $res->ac_no; ?> </h5> </div></td>
                                        <td><div class="view"><h5> <?php echo $res->party_name; ?> </h5> </div></td>
                                        <td><div class="remark"><h5> <?php echo $res->remark; ?> </h5> </div></td>
                                        </tr>   
                                    <?php }  ?>
                                                 
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>      
            </div>
            <div class="panel panel-flat loan-panel">
                <div class="panel-body">
                    <div class="trans-table">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-md-offset-3 col-lg-4 control-label"><b>Loan Amt (GHS )</b></label>                                                    
                                    <div class="col-lg-4">
                                        <div class="view"><h5> <?php echo $result->loan_amount; ?> </h5> </div>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Other Amt (GHS )</label>                                                    
                                    <div class="col-lg-5">
                                        <div class="view"><h5> <?php echo $result->other_amt; ?> </h5> </div>   
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-md-offset-3 col-lg-4 control-label">Interest Per (%)</label>                                                    
                                    <div class="col-lg-4">
                                          <div class="view"><h5> <?php echo $result->interest_per; ?> </h5> </div>      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><b>Bal Amount</b><span>:</span></label>                                                    
                                    <div class="col-lg-5">
                                        <div class="view"><h5> <?php echo $result->bal_amt; ?> </h5> </div>   
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-md-offset-3 col-lg-4 control-label">Interest (GHS )</label>                                                    
                                    <div class="col-lg-4">
                                        <div class="view"><h5> <?php echo $result->interest; ?> </h5> </div>    
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /2 columns form -->  
</div>
<!-- /content area -->    
<style>
    .view h5 {
        margin-top: 7px;
    }
    label {
        font-weight: bold;
    }
</style>