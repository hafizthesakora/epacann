<?phprequire_once("../config/config.php");admincheck($mysql);if (!isset($_REQUEST['save'])) {    extract($_REQUEST);    $sql = "select * from `admins` where `admin_id`='" . $_SESSION['adminid'] . "'";    $check = $mysql->selectdata($sql);    if ($check[0]['password'] == $oldpassword) {        if ($newpassword == $confirmpassword) {            $pwdupdate = "UPDATE `admins` SET `password`='" . $confirmpassword . "' WHERE `admin_id`='" . $_SESSION['adminid'] . "'";            //print_r($pwdupdate);exit;            $pwd = $mysql->updatedata($pwdupdate);            $msg->add('s', 'Password updated successfully');            header("Location:changepassword.php");            exit();        } else {            $msg->add('e', 'Confirm Password mismatch');            header("Location:changepassword.php");            exit();        }    } else {        $msg->add('e', 'Old Password mismatch');        header("Location:changepassword.php");        exit();    }}include("includes/header.php");?><div id="content"  class="clearfix">    <div class="container">        <div align="right" style="padding-right:50px;"></div>        <form name="loginform" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="myForm" autocomplete="off">             <fieldset>                <legend>Change Password</legend>                <p><span class="error">* required field</span></p>                <dl class="inline">                    <dt>                        <label for="oldpassword">Old Password <span class="required">*</span></label>                    </dt>                    <dd>                        <input type="password" id="oldpassword" name="oldpassword" class="validate[required,minSize[6]]" size="50" value="" />                    </dd>                    <dt>                        <label for="name">New Password <span class="required">*</span></label>                    </dt>                    <dd>                        <input type="password" id="newpassword" name="newpassword" class="validate[required,minSize[6]]"  size="50" value=""  />                    </dd>                    <dt>                        <label for="name">Confirm Password <span class="required">*</span></label>                    </dt>                    <dd>                        <input type="password" id="confirmpassword" name="confirmpassword" class="validate[required,equals[newpassword]]]]"  size="50"  value="" />                    </dd>                    <div class="buttons" >                        <input type="hidden" name="login" value="1" />                        <input type="submit" name="save" id="submit" class="button" value="Change Password"/>                    </div>                </dl>            </fieldset>        </form>    </div></div><?php include("includes/footer.php"); ?>