<?php

	$title = 'Welcome';

	session_start();

	require 'include/connect.php';
	$sql = 'SELECT name FROM user WHERE email="' . $_SESSION["email"] . '"';
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();


	$content = '
		<div class="col-sm-2 side-wrapper">
			<h3>Your Account</h3>
			<hr/>
			<ul class="nav flex-column">
			  <li class="nav-item">
			    <a class="nav-link btn btn-primary" href="#">Edit Profile</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link btn btn-primary" href="#">Logout</a>
			  </li>
			</ul>
		</div>
		<div class="col-sm-10 app-wrapper">
			<div class="col-sm-12 app-header-wrapper">
				<h1 class="title-header">Welcome, ' . $row['name'] . '.</h1>
				<hr/>
			</div>
			<div class="col-sm-12">
				<h3>Which class are you looking to find a group for?</h3>
				<div class="dropdown">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Select A Class
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				    <a class="dropdown-item" href="#">CECS 343</a>
				    <a class="dropdown-item" href="#">CECS 378</a>
				    <a class="dropdown-item" href="#">CECS 476</a>
				  </div>
				</div>
			</div>
		</div>
	';

	require_once(TEMPLATES_PATH . "/base.php");
?>
