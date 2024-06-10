<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="Responsive Admin Template" />
        <meta name="author" content="Sunray" />
        <title>Sunray | Hospital Admin Template</title>
        <!-- google font -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
        <!-- icons -->
        <link href="../theme/light/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!--bootstrap -->
        <link href="../theme/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
        <!-- data tables -->
        <link href="../theme/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        <!-- Material Design Lite CSS -->
        <link href="../theme/assets/plugins/material/material.min.css" rel="stylesheet"/>
        <link href="../theme/assets/css/material_style.css" rel="stylesheet"/>
        <!-- Theme Styles -->
        <link href="../theme/assets/css/style.css" rel="stylesheet" type="text/css"/>	
        <link href="../theme/assets/css/custome.css" rel="stylesheet" type="text/css"/>	
        <link href="../theme/assets/css/plugins.min.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets/css/pages/formlayout.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets/css/theme-color.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets/plugins/jquery-validation/css/validationEngine.jquery.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets/css/sweetalert.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <link href="../theme/assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <!--<link href="../theme/assets/plugins/fullcalendar/scheduler.css" rel="stylesheet" type="text/css" />
        <link href="../theme/assets/plugins/fullcalendar/scheduler.min.css" rel="stylesheet" type="text/css" />-->
        <!-- favicon -->
        <link rel="shortcut icon" href="http://radixtouch.in/templates/admin/sunray/source/assets/img/favicon.ico"/> 
        <!-- start js include path -->
        <script src="../theme/assets/plugins/moment/moment.min.js" ></script>
        <script src="../theme/assets/plugins/jquery/jquery.min.js" ></script>

        <script src="../theme/assets/plugins/popper/popper.min.js" ></script>
        <script src="../theme/assets/plugins/jquery-blockui/jquery.blockui.min.js" ></script>
        <script src="../theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" ></script>
        <script src="../theme/assets/plugins/jquery-validation/js/jquery.validationEngine.js" ></script>
        <script src="../theme/assets/plugins/jquery-validation/js/jquery.validationEngine-en.js" ></script>
        <script src="../theme/assets/plugins/jquery-validation/js/additional-methods.min.js" ></script>
        <script src="../theme/assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<!--<script src="../theme/assets/plugins/fullcalendar/jquery-ui.min.js" ></script>-->
<!-- <script src="../theme/assets/plugins/fullcalendar/fullcalendar.js" ></script>-->
        <script src="../theme/assets/plugins/fullcalendar/fullcalendar.min.js" ></script>

<!-- <script src="../theme/assets/plugins/fullcalendar/scheduler.js" ></script>
 <script src="../theme/assets/plugins/fullcalendar/scheduler.min.js" ></script>
 <script src="../theme/assets/plugins/fullcalendar/gcal.min.js" ></script>-->
 <!--<script src="../theme/assets/js/pages/calendar/calendar.min.js" ></script>-->
        <!-- bootstrap -->
        <script src="../theme/assets/plugins/bootstrap/js/bootstrap.min.js" ></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script> 
        <script src="../theme/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker-init.js"></script>
        <!-- data tables -->
        <script src="../theme/assets/plugins/datatables/jquery.dataTables.min.js" ></script>
        <script src="../theme/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js" ></script>
       
        <!-- Material -->
        <script src="../theme/assets/plugins/material/material.min.js"></script>
        
        <script src="../theme/assets/js/dataTables.buttons.min.js" ></script>
      
        <script src="../theme/assets/js/jszip.min.js" ></script>
        <script src="../theme/assets/js/pdfmake.min.js" ></script>
        <script src="../theme/assets/js/vfs_fonts.js" ></script>
        <script src="../theme/assets/js/buttons.html5.min.js" ></script>
     
         <!-- Common js-->
        <script src="../theme/assets/js/app.js" ></script>
        <script src="../theme/assets/js/custome.js" ></script>
        <script src="../theme/assets/js/pages/validation/form-validation.js" ></script>
        <script src="../theme/assets/js/layout.js" ></script>
        <script src="../theme/assets/js/sweetalert.min.js" ></script>
        <script src="../theme/assets/js/theme-color.js" ></script>

        <!-- end js include path -->
    </head>
    <body>
        <div id="main">
            <?php $this->load->view('includes/header'); ?>
            <?php $this->load->view($template); ?>
            <?php $this->load->view('includes/footer'); ?>
        </div>
    </body>
</html>
