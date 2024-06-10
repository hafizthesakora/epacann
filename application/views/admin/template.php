<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Finance Management System</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="../theme/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="../theme/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../theme/assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="../theme/assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="../theme/assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="../theme/assets/css/custome.css" rel="stylesheet" type="text/css">
        <link href="../theme/assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="../theme/assets/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">  
        <link href="../theme/assets1/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="../theme/assets1/plugins/jquery-validation/css/validationEngine.jquery.css" />
        <link rel="stylesheet" href="../theme/assets/css/chosen.min.css">
        <link rel="stylesheet" href="../theme/assets/css/bootstrap-datepicker3.css"/>
        <link rel="stylesheet" href="../theme/assets/css/bootstrap-multiselect.css">
       <link rel="shortcut icon" type="image/png" href="../theme/assets/images/favicon.ico">

        <!-- Main content -->
        <script type="text/javascript" src="../theme/assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="../theme/assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="../theme/assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="../theme/assets/js/plugins/loaders/blockui.min.js"></script>
        <script src="../theme/assets1/plugins/datatables/jquery.dataTables.min.js" ></script>
        <script src="../theme/assets1/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js" ></script>
        <script src="../theme/assets1/js/dataTables.buttons.min.js" ></script> 
        <script src="../theme/assets1/plugins/jquery-validation/js/jquery.validationEngine.js" type="text/javascript"></script>
        <script src="../theme/assets1/plugins/jquery-validation/js/jquery.validationEngine-en.js" type="text/javascript"></script>
        <script src="../theme/assets1/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="../theme/assets1/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="../theme/assets1/plugins/jquery-validation/js/form-validation.js" type="text/javascript"></script>
        <script src="../theme/assets/js/chosen.jquery.min.js"></script>
        <script src="../theme/assets/js/bootstrap-multiselect.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="../theme/assets/js/plugins/velocity/velocity.min.js"></script>
        <script type="text/javascript" src="../theme/assets/js/plugins/velocity/velocity.ui.min.js"></script>
        <script src="../theme/assets1/js/custome.js" ></script> 
        <script type="text/javascript" src="../theme/assets/js/core/app.js"></script>
        <script type="text/javascript" src="../theme/assets/js/pages/animations_velocity_ui.js"></script>
        <script src="../theme/assets1/js/sweetalert.min.js" ></script>
        <script type="text/javascript" src="../theme/assets1/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../theme/assets1/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="../theme/assets/js/jquery.matchHeight.js"></script>
        <script type="text/javascript" src="../theme/assets/js/bootstrap-datepicker.min.js"></script> 
	<script type="text/javascript" src="../theme/assets/js/jquery.czMore.js"></script>
        
        <script type="text/javascript" src="../theme/assets/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="../theme/assets/js/buttons.print.min.js"></script>
    </head>

    <?php setlocale(LC_MONETARY, 'en_IN');
    $this->load->view('admin/include/header');
    ?>
    <div class="page-container">
        <div class="page-content">
            <?php $this->load->view('admin/include/sidebar'); ?>
<?php $this->load->view($template); ?>
        </div>
    </div>
<?php if (!empty($this->session->flashdata('error'))) { ?> 
        <script>
            swal("Error!", "<?php echo $this->session->flashdata('error'); ?>", "error")
        </script>   
    <?php } ?> 
<?php if (!empty($this->session->flashdata('success'))) { ?>   
        <script>
            swal("Success!", "<?php echo $this->session->flashdata('success'); ?>", "success")
        </script> 
<?php } ?>   

</html>
<script>
    $(document).ready(function () {
        $('#example4').DataTable();
    });
</script>
<script>
    $('.datepicker').datepicker({
        // startDate: "0 days"
    });
</script>
<script>
    $('.datepicker-prev').datepicker({
        //   startDate: "-1 days"
    });
</script>
<script type="text/javascript">

    $(".chosen").chosen();

</script>
<script type="text/javascript">
    $("#item_name").multiselect(
            {
                title: "Select Item",
                maxSelectionAllowed: 5
            });
</script>

<style type="text/css">
    @media print {
        a[href]:after {
            content: none !important;
        }
    }
</style>