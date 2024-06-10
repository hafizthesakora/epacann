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
                <li><a href="ploan_display">Personal Loan</a></li>
                <li class="active">View Personal Loan</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal" action="#" method="post">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a onclick="window.history.back();"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>View Personal Loan</h4></div>
                            <div class="row">
                                <div class="col-md-offset-1 col-md-5">
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Loan No <span>:</span></label>                                                    
                                        <div class="col-lg-7"> <div class="view"><h5><?php echo $result->loan_no; ?></h5> </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Loan Date <span>:</span></label>                                                    
                                        <div class="col-lg-7">                
                                            <div class="view"><h5><?php echo date('d-m-Y', strtotime($result->loan_date)); ?></h5> </div>
                                        </div>
                                    </div>
                                    <?php $getname = $this->db->select('party_name')->get_where('parties',array('party_id'=>$result->party_name,'status!='=>'Trash'))->row();                                         ?>
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Party name <span>:</span></label>                                                    
                                        <div class="col-lg-7">  <div class="view"><h5> <?php echo $getname->party_name; ?> </h5> </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Loan Amount (GHS
                                            ) <span>:</span></label>                                                    
                                        <div class="col-lg-7"> <div class="view"><h5> <?php echo $result->loan_amount; ?> </h5> </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Interest (GHS
                                            ) <span>:</span></label>                                                    
                                        <div class="col-lg-7"> <div class="view"><h5> <?php echo $result->interest; ?> </h5> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Other Charges (GHS ) <span>:</span></label>                                                    
                                        <div class="col-lg-7">  <div class="view"><h5>  <?php echo $result->other_charges; ?> </h5> </div>   
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Pay From <span>:</span></label>                                                    
                                        <div class="col-lg-7"> <div class="view"><h5>  <?php echo $result->pay_from; ?> </h5> </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Remarks <span>:</span></label>                                                    
                                        <div class="col-lg-7">  <div class="view"><h5> <?php echo $result->remarks; ?> </h5> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
        <!-- /2 columns form -->                    <!-- Footer -->                    
    </div>
    <!-- /main content -->     
</div>
