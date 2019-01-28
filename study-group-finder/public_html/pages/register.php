<?php

	$title = 'Get Started';

	session_start();

	require 'include/connect.php';
	$sql = 'SELECT name FROM user WHERE email="' . $_SESSION["email"] . '"';
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();

	$classes = array('CECS 229','CECS 277','CECS 282','CECS 323','CECS 326','CECS 328','CECS 341','CECS 343','CECS 378');

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

	if(isset($_POST["classes-submit"])){
		require 'include/connect.php';

		for($i = 0; $i < 4; $i++){
			$class = "class" . ($i+1);
			$sql = 'UPDATE user SET ' . $class . '="' . mysqli_real_escape_string($conn, $_POST[$class]) . '" WHERE email="' . $_SESSION["email"] . '"';
			if(mysqli_query($conn, $sql)){
				header('Location: register2.php');
			}
			else{
				echo $sql;
				echo 'There was an error registering you for ' .  $_POST[$class];
			}
		}
	}

	$content = '
		<div class="col-sm-12 app-wrapper">
			<div class="col-sm-12 app-header-wrapper">
				<h1 class="title-header">Welcome, ' . $row['name'] . '.</h1>
				<hr/>
			</div>
			<div class="col-sm-12">
                    <h3>To get started, fill out the information.</h3>
                    <form method="POST">
                    	<div class="container" id="classes">
                        ' . get_dropdowns($classes) . '
                        </div>
                        <div class="col-sm-12">
                        	<button class="btn btn-primary" type="submit" name="classes-submit">Submit</button>
                        </div>
                    </form>
                </div>
		</div>
		';

	require_once(TEMPLATES_PATH . "/base.php");
?>
