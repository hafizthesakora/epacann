<body class="login-cover  pace-done">
    <div class="pace  pace-inactive">
        <div class="pace-progress" style="transform: translate3d(100%, 0px, 0px);" data-progress-text="100%" data-progress="99">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity">
        </div>
    </div>
    <!-- Main navbar -->
    <!-- /main navbar -->
    <!-- Page container -->
    <div class="page-container login-container" style="min-height:372px">
        <!-- Page content -->
        <div class="page-content">
            <!-- Main sidebar -->
            <!-- /main sidebar -->
            <!-- Main content -->
            <!-- Main content -->
            <div class="content-wrapper">
                <!-- Content area -->
                <div class="content">
                    <!-- Advanced login -->
                    <form action="" method="post" class="validation_form" autocomplete="off">
                        <div class="panel panel-body login-form">
                            <div class="text-center login-head">
                                <h4 class="text-blue">EPACANN MANAGEMENT SYSTEM</h4>

                            </div>
                            <div class="login-body">
                                <div class="form-group has-feedback has-feedback-left wrap-input100">
                                    <input type="text" class="input100 admin-login-form" placeholder="Enter User Name" name="user_name" autocomplete="off">
                                    <span class="focus-input100" data-placeholder="&#xf207;"> <i class="fa fa-user" aria-hidden="true"></i></span>
                                </div>
                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="password"  class="input100 admin-login-form"  placeholder="Enter Password" name="password">
                                    <span class="focus-input100" data-placeholder="&#xf207;"><i class="fa fa-key icon" aria-hidden="true"></i></span>
                                </div>
<!--                                <div class="form-group login-options hide">
                                    <div class="row">
                                        <div class="col-sm-12 col-sm-offset-6 text-right">
                                            <a href="forgotpassword">Forgot password?</a>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <button type="submit" class="btn bg-blue btn-block">Login</button>
                                </div>
                                <div class="form-group" style="text-align: center;">
                                    <span class="small">Copyright &copy; EPACANN MICRO CREDIT LIMITED. All Rights Reserved.</span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /advanced login -->
                    <!-- Footer -->
                    <!-- /footer -->
                </div>
                <!-- /content area -->
            </div>
        </div> </div>
    <!-- /main content -->
    <style>
        .form-control-feedback .text-muted {
            margin-top: 0;
        }
    </style>                <!-- /main content -->
    <!-- /page content -->
    <script>
        $('.validation_form').validationEngine({scroll: false});
        $("#flashMessage").click(function () {
        $("#flashMessage").fadeOut(1000);
        });
        setTimeout(function () {
        $('#flashMessage').fadeOut(1000);
        }, 5000);
    </script>
    <!-- /page container -->
<style>
.login-container .login-form {
    width: 500px;
}
</style>
