<?php
	
	$title = 'Welcome';
	$classes = array('CECS 229','CECS 277','CECS 282','CECS 323','CECS 326','CECS 328','CECS 341','CECS 343','CECS 378');

	session_start();

	require 'connect.php';
	$sql = 'SELECT ID,name,class1,class2,class3,class4,freeday,startHour,endHour FROM user WHERE ID="' . $_SESSION["ID"] . '" OR email="' . $_SESSION["email"] . '"';
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();

	$ID = $row["ID"];
	$name = $row["name"];
	$freeday = $row["freeday"];
	$startHour = $row["startHour"];
	$endHour = $row["endHour"];

	function get_student_classes($row){
		$class_list = '';
		for($i = 0; $i < 4; $i++){
			$class_list .= '<option class="dropdown-item" value="' . $row[('class' . ($i + 1))] . '">' . $row[('class' . ($i + 1))] . '</option>';
		}
		return $class_list;
	}
	function get_classes($arr){
		$str = '';
		foreach( $arr as $class ) {
    		$str .= '<option value="' . $class . '"">' . $class . '</option>';
        }
        return $str;
	}
	function get_dropdowns($arr){
		$str = '';
		for($i = 0; $i < 4; $i++){
			$str .= '
			<select class="class-menu" name="class' . ($i + 1) . '">
				<option value="0" selected="selected">Select Class ' . ($i + 1) . '</option>
                ' . 
                get_classes($arr)
                 . '
            </select>
            ';
		}
		return $str;
	}
	if(isset($_POST["logout"])){
		session_destroy();
		header("Location: index.php");
	}
	if(isset($_POST["save-edit"])){
		$sql = 'UPDATE user SET ';
		if(!empty($_POST["new-name"])){
			$sql .= 'name="' . $_POST["new-name"] . '",';
		}
		if(!empty($_POST["new-email"])){
			$sql .= 'email="' . $_POST["new-email"] . '",';
		}
		if(isset($_POST["new-pass"])){
			$sql .= 'password="' . $_POST["new-pass"] . '",';
		}
		for($i = 0; $i < 4; $i++){
			$ref = ('class' . ($i + 1));
			if(!empty($_POST[$ref])){
				$sql .= $ref .'="' . $_POST[$ref] . '",'; 
			}
		}
		$sql = substr($sql, 0, strlen($sql) - 1);
		$sql .= ' WHERE ID="' . $ID . '"';

		if(mysqli_query($conn, $sql)){
			header('Location: profile.php');
		}
		else{
			echo 'There was an error saving your changes.';
			echo $sql;
		}
	}
	if(isset($_POST["class-search"])){
		$input = $_POST["search-class"];
		$sql = 'SELECT ID, name, email,freeday,startHour,endHour FROM user WHERE (class1="' . $input . '" OR class2="' . $input . '" OR class3="' . $input . '" OR class4="' . $input . '") AND (NOT ID="' . $ID . '")';
		$query = mysqli_query($conn, $sql);
		if($query){
			$students = "";
			while($results = mysqli_fetch_assoc($query)){
				if($results["freeday"] == $freeday and (
					(($startHour <= $results["startHour"]) and ($endHour > $results["startHour"])) || 
					(($results["startHour"] <= $startHour) and ($results["endHour"] > $endHour)))) {
					$students .= '<li class="list-group-item col-sm-4"><h4>' . $results["name"] . '</h4><p>' . $results["email"] . '</p></li>';
				}
			}
			if(strlen($students) <= 0){
				$students = '<li class="list-group-item"><h4>No Results Found</h4></li>';
			}
		}
		$app_body = '
			<div class="col-sm-12 app-header-wrapper">
				<h1 class="title-header">Results</h1>
				<hr/>
			</div>
			<div class="col-sm-12 text-center app-body">
				<ul class="list-group">
				  ' . $students . '
				</ul>
			</div>
			<div class="col-sm-12 text-center">
				<h4>Search Another Class:</h4>
				<form method="POST">
					<select name="search-class">
						' . get_student_classes($row) . '
					</select>
					<button type="submit" class="btn btn-primary" name="class-search">Search</button>
				</form>
			</div>
		';
	}
	else{
		$app_body = '
			<div class="col-sm-12 app-header-wrapper">
				<h1 class="title-header">Welcome, ' . $name . '.</h1>
				<hr/>
			</div>
			<div class="col-sm-12 text-center">
				<h3>Which class are you looking to find a group for?</h3>
				<form method="POST">
					<select name="search-class">
						' . get_student_classes($row) . '
					</select>
					<button type="submit" class="btn btn-primary" name="class-search">Search</button>
				</form>
			</div>
		</div>
	';
	}
	$content = '
		<div class="col-sm-2 side-wrapper">
			<h3>Your Account</h3>
			<hr/>
			<ul class="nav flex-column">
			  <li class="nav-item">
			    <a class="nav-link btn btn-primary" data-toggle="modal" data-target="#edit-profile">Edit Profile</a>
			  </li>
			  <li class="nav-item">
			  	<form method="POST">
			    	<button type="submit" class="nav-link btn btn-primary" id="logout" name="logout">Logout</button>
			    </form>
			  </li>
			</ul>
		</div>
		<div class="col-sm-10 app-wrapper">
	';
	

	$content .= $app_body . '
		<div class="modal" tabindex="-1" id="edit-profile" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
			    <form method="POST">
			      <div class="modal-header">
			        <h5 class="modal-title">Edit Profile</h5>
			      </div>
			      <div class="modal-body">
			        <div class="form-group col-sm-12 text-left">
						<label for="new-name">Name:</label>
						<input type="text" class="form-control" id="new-name" name="new-name" aria-describedby="nameHelp" placeholder="Enter Name">
					</div>
			        <div class="form-group col-sm-12 text-left">
						<label for="new-email">Email Address:</label>
						<input type="email" class="form-control" id="new-email" name="new-email" aria-describedby="emailHelp" placeholder="Enter Email">
					</div>
					<div class="form-group col-sm-12 text-left">
						<label for="new-password">Password:</label>
						<input type="password" class="form-control" id="new-pass" name="new-password" placeholder="Password">
					</div>
					<div class="form-group col-sm-12 text-center">
						<div class="container" id="classes">
	                        ' . get_dropdowns($classes) . '
                        </div>
					</div>
			      </div>
			      <div class="modal-footer">
			        <button type="submit" class="btn btn-primary" name="save-edit">Save changes</button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>
		      	</form>
		    </div>
		  </div>
		</div>
	';

	include 'base.php';
?>