<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
header("location: <?php  echo base_url()?>/login/users/user_login_process");
}
?>
<head>
<title>Login Form</title>
<link rel="stylesheet" type="text/css" href="<?php  echo base_url('dist')?>/css/style.css">
</head>
<body style="background-size:cover /*1263px 399px*/;margin: 0;
    padding: 0;
    height: 100%;
    background: url(<?php  echo base_url('dist')?>/img/bg.jpg) no-repeat center center fixed;">
<div id="main" class="form-container">
    <div id="login" class="form-title">
        <h2>Sign In or Sign Up</h2>
<?php echo form_open('users/user_login_process'); ?>
<?php
echo "<div class='error_msg'>";
if (isset($error_message)) {
echo $error_message;
}
echo validation_errors();
echo "</div>";
?>
<div class="form-title">Email :</div>
<input type="text" class="form-field" name="username" value="test" id="name" placeholder="username"/><br />
<div class="form-title">Password :</div>
<input type="password" class="form-field" name="password" id="password" value="test" placeholder="**********"/><br />
<div class="submit-container">
    <input class="submit-button" type="submit" name="submit" value="Sign In">
    <input class="reg-button" type="button" onclick="location.href='index.php/users/user_registration_show';" name="submit" value="Sign Up">
</div>
<?php echo form_close(); ?>
</div>
</div>
</body>
</html>

