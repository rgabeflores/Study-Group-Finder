<?php

	$title = "Register or Login";

	session_start();

	if(isset($_POST['login-submit'])){
		require 'connect.php';
		$email = $_POST['login-email'];
		$password = $_POST['login-password'];
		$sql = 'SELECT * FROM user WHERE email="' . $email . '" and password="' . $password . '"';
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 1){
			$info = $result->fetch_assoc();
			$_SESSION['email'] = $info['email'];
			$_SESSION['ID'] = $info["ID"];
			header('Location: profile.php');
		}
		else{
			echo 'Invalid Email or Password';
		}
	}
	if(isset($_POST['register-submit'])){
		require 'connect.php';
		$name = $_POST['register-name'];
		$email = $_POST['register-email'];
		$password = $_POST['register-password'];
		$sql = 'SELECT * FROM user WHERE email="' . $email . '"';
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 1){
			echo 'This email is already taken.';
		}
		else{
			$sql = 'INSERT INTO user (name, email, password) VALUES ("' . $name . '", "'. $email . '", "' . $password . '")';
			if(mysqli_query($conn, $sql)){
				$sql = 'SELECT * FROM user WHERE email="' . $email . '" and password="' . $password . '"';
				$result = mysqli_query($conn, $sql);
				$info = $result->fetch_assoc();
				$_SESSION['ID'] = $info['ID'];
				$_SESSION['email'] = $email;
				$_SESSION['name'] = $name;
				$_SESSION['password'] = $password;
				header('Location: register.php');
			}
			else{
				echo 'There was an error registering your name, email and password.';
			}
		}
	}

	$content = '
			<div class="col-sm-12" header-wrapper">
				<h1 class="title-header">Study Group Finder</h1>
				<hr/>
			</div>
			<div class="col-sm-12 index-wrapper">
                <div class="col-sm-3 text-center index-content">
                	<h1>Register</h1>
                	<hr/>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#register">
					  Register
					</button>
                </div>
                <div class="col-sm-2 text-center">
                	<h3>OR</h3>
                </div>
                <div class="col-sm-3 text-center index-content">
                	<h1>Login</h1>
                	<hr/>
                 	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login">
					  Login
					</button>
                </div>
            </div>
            <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    	<form method="post">
				      <div class="modal-header">
				        <h5 class="modal-title" id="register-modal-label">Register</h5>
				      </div>
				      <div class="modal-body">
				      	<div class="form-group text-left">
							<label for="register-name">Name:</label>
							<input type="text" class="form-control" id="register-name" name="register-name" aria-describedby="nameHelp" placeholder="Enter Name">
						</div>
				        <div class="form-group text-left">
							<label for="register-email">Email Address:</label>
							<input type="email" class="form-control" id="register-email" name="register-email" aria-describedby="emailHelp" placeholder="Enter Email">
						</div>
						<div class="form-group text-left">
							<label for="register-password">Password:</label>
							<input type="password" class="form-control" id="register-password" name="register-password" placeholder="Password">
						</div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary" name="register-submit">Submit</button>
				      </div>
			      </form>
			    </div>
			  </div>
			</div>
			<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    	<form method="post">
				      <div class="modal-header">
				        <h5 class="modal-title" id="login-modal-label">Login</h5>
				      </div>
				      <div class="modal-body">
						<div class="form-group text-left">
							<label for="login-email">Email address:</label>
							<input type="email" class="form-control" id="login-email" name="login-email" aria-describedby="emailHelp" placeholder="Enter Email">
						</div>
						<div class="form-group text-left">
							<label for="login-password">Password:</label>
							<input type="password" class="form-control" id="login-password" name="login-password" placeholder="Password">
						</div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary" name="login-submit">Submit</button>
				      </div>
			      </form>
			    </div>
			  </div>
			</div>
    ';

    include 'base.php';

?>