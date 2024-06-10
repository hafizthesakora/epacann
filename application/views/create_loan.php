<?php
require_once("config/config.php");
//if (isset($_POST['submit'])) {
//  $sql = "INSERT INTO loans (loan_no,loan_date,party_name,loan_amount,interest,adv_interest,other_charges,bal_amount,pay_from,remarks) VALUES('" . $_POST['loan_no'] . "','" . $_POST['loan_date'] . "','" . $_POST['party_name'] . "','" . $_POST['loan_amount'] . "','" . $_POST['interest'] . "','" . $_POST['adv_interest'] . "','" . $_POST['other_charges'] . "','" . $_POST['bal_amount'] . "','" . $_POST['pay_from'] . "','" . $_POST['remarks'] . "')";
//   $user = $mysql->insertdata($sql);
//   if ($user === TRUE) {
//       header("Location: loan_display.php");
//  } else {
//      echo "error" . $sql . "<br>" . $con->error;
//   }
//}
?>
<html>
    <?php include ("includes/header.php"); ?>
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            <?php include ("includes/sidebar.php"); ?>
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
                            <li><a href="loan_display.php">Loans</a></li>
                            <li class="active">Loan Creation</li>
                        </ul>
                    </div>
                </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- Horizontal form options -->
                    <!-- /fieldset legend -->
                    <!-- 2 columns form -->
                    <form class="form-horizontal" action="#">
                        <div class="panel panel-flat  loan-panel">
                            <div class="panel-body">
                               <fieldset>
                                    <legend class="text-semibold">Loan Creation</legend>
                                    <div class="trans-table">
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-8">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Loan No<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <input type="text" name="loan_no" class="form-control">
                                                            </div>

                                                            <div class="col-md-8">
                                                                <input type="text" name="loan_no" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Loan Date<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <input name="loan_date" class="validate[required] picker startdate hasDatepicker" value="" type="text" id="BillDate">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Party name<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="party_name" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Loan Amount<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="loan_amount" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Interest<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control">
                                                            </div>

                                                            <div class="col-md-8">
                                                                <input type="text" name="interest" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Adv Interest<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="adv_interest" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Other Charges<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="other_charges" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Bal Amount<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="bal_amount" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Pay From<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="pay_from" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Remarks<span>:</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="remarks" placeholder="" class="form-control bg-slate ">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <div class="trans-table">
                                            <table class="transactions-table trans-margin">
                                                <thead class="transactions-table-head">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Qty</th>
                                                        <th>Weight</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td></td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-buttons-wrapper row-fluid">
                                    <div class="span12 align-center">
                                        <div class="button-wrapper">
                                            <button class="enhanced_submit btn btn-success btn-large" type="submit" id="Save"> <i class="icon-check gutter-left"></i> <span class="gutter-right">Save</span> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /2 columns form -->
                    <!-- Footer -->
                    <div class="footer text-muted">
                        &copy;<a href="#">Copyright 2018</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">project.rayaztech.com</a>
                    </div>
                    <!-- /footer -->
                </div>
                <!-- /content area -->
            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->
    </div>
    <?php include ("includes/footer.php"); ?>
</body>
<!-- Mirrored from radixtouch.in/templates/admin/smart/source/light/add_professor.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 14 Oct 2018 05:21:34 GMT -->
<script>
    jQuery(document).ready(function(){
    jQuery("form").submit(function(){
    alert("Added Successfully");
    });
    });
</script>
</html>
