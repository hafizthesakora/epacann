<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="Responsive Admin Template" />
        <meta name="author" content="Sunray" />
        <title>Finance Management System</title>
        <!-- google font -->        
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
        <!-- icons -->        
        <link href="../theme/light/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!--bootstrap -->        
        <link href="../theme/assets1/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../theme/assets/css/bootstrap-datepicker3.css"/>
        <!-- data tables -->        
        <link href="../theme/assets1/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        <!-- Material Design Lite CSS -->        
        <link href="../theme/assets1/plugins/material/material.min.css" rel="stylesheet"/>
        <link href="../theme/assets1/css/material_style.css" rel="stylesheet"/>
        <!-- Theme Styles -->        
        <link href="../theme/assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets/css/custome.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets1/css/plugins.min.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets1/css/pages/formlayout.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets1/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets1/css/theme-color.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets1/plugins/jquery-validation/css/validationEngine.jquery.css" rel="stylesheet" type="text/css"/>
        <link href="../theme/assets1/css/sweetalert.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" type="image/png" href="../theme/assets/images/favicon.ico">


       <script src="../theme/assets1/plugins/moment/moment.min.js" ></script>   
        <script src="../theme/assets1/plugins/jquery/jquery.min.js" ></script> 
        <script src="../theme/assets1/plugins/popper/popper.min.js" ></script>  
        <script src="../theme/assets1/plugins/jquery-blockui/jquery.blockui.min.js" ></script> 
        <script src="../theme/assets1/plugins/jquery-validation/js/jquery.validate.min.js" ></script> 
        <script src="../theme/assets1/plugins/jquery-validation/js/jquery.validationEngine.js" ></script>   
        <script src="../theme/assets1/plugins/jquery-validation/js/jquery.validationEngine-en.js" ></script>   
        <script src="../theme/assets1/plugins/jquery-validation/js/additional-methods.min.js" ></script>  
        <script src="../theme/assets1/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
        <!-- bootstrap -->
        <script src="../theme/assets1/plugins/bootstrap/js/bootstrap.min.js" ></script> 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>   
        <!-- data tables --> 
        <!-- Material -->      
        <script src="../theme/assets1/plugins/material/material.min.js"></script>       
        <script src="../theme/assets1/js/dataTables.buttons.min.js" ></script>        
        <script src="../theme/assets1/js/jszip.min.js" ></script>      
        <script src="../theme/assets1/js/pdfmake.min.js" ></script>    
        <script src="../theme/assets1/js/vfs_fonts.js" ></script>     
        <script src="../theme/assets1/js/buttons.html5.min.js" ></script>       
        <!-- Common js-->       
        <script src="../theme/assets1/js/pages/validation/form-validation.js" ></script>    
        <script src="../theme/assets1/js/layout.js" ></script>   
        <script src="../theme/assets1/js/sweetalert.min.js" ></script>  
        <script src="../theme/assets1/js/theme-color.js" ></script>    
        <!-- end js include path -->    
    </head>
    <body class="login-cover  pace-done">
        <div id="main">
            <?php $this->load->view($template); ?>       
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
        </div>
 <script>
    jQuery(document).ready(function () {
    jQuery("#formID").validationEngine();
    });
</script>
    </body>
</html>

