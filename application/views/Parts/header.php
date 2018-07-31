<html>
        <head>
        <meta charset="utf-8">
		<script type="text/javascript" charset="utf-8" src="<?php  echo base_url('dist')?>/js/jquery-3.3.1.js"></script>
		<script type="text/javascript" charset="utf-8" src="<?php  echo base_url('dist')?>/js/bootstrap.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="<?php  echo base_url('dist')?>/js/moment.js"></script>
		<script type="text/javascript" charset="utf-8" src="<?php  echo base_url('dist')?>/js/moment-with-locales.js"></script>
		<script type="text/javascript" charset="utf-8" src="<?php  echo base_url('dist')?>/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" charset="utf-8" src="<?php  echo base_url('dist')?>/js/my.js"></script>
		<link href="<?php  echo base_url('dist')?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php  echo base_url('dist')?>/css/bootstrap-datepicker.css" rel="stylesheet">
		<link href="<?php  echo base_url('dist')?>/css/min.css" rel="stylesheet">
        <title>*</title>
        </head>
        <body>
        <div class="menu"><?php
if (isset($this->session->userdata['logged_in'])) {
$email = ($this->session->userdata['logged_in']['email']);
echo $email.', ';
} ?>
<a href="logout" id="logout">Log out</a></div>
        <div class="container">
            <div class="container-header">
                <div class="smpl">SIMPLE TODO LIST</div>
                <div class="rby">FROM RUBY GARAGE</div>
            </div>