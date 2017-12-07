<?php
	
	$title = 'Get Started';

	session_start();

	require 'connect.php';

	if(isset($_POST["freetime-submit"])){
		require 'connect.php';

		$sql = 'UPDATE user SET freeday="' . $_POST["free-day"] . '", startHour="' . $_POST["start-hour"] . '", endHour="' . $_POST["end-hour"] . '" WHERE email="' . $_SESSION["email"] . '"';
		if(mysqli_query($conn, $sql)){
			header('Location: profile.php');
		}
		else{
			echo $sql;
			echo 'There was an error registering your free time. ';
		}
	}

	$content = '
		<div class="col-sm-12 app-wrapper">
			<div class="col-sm-12 app-header-wrapper">
				<h1>We also need to know your free time</h1>
				<hr/>
			</div>
			<div class="col-sm-12">
				<form class="form-inline" method="POST">
					<div class="form-group">
						<select name="free-day">
							<option value="0">Select a Day</option>
							<option value="SUN">Sunday</option>
							<option value="MON">Monday</option>
							<option value="TUE">Tuesday</option>
							<option value="WED">Wednesday</option>
							<option value="THU">Thursday</option>
							<option value="FRI">Friday</option>
							<option value="SAT">Saturday</option>
						</select>
					</div>
					<div class="form-group">
						<label for="start-hours">Starting Hour:</label>
						<input class="form-control" type="text" name="start-hour"/>
					</div>
					<div class="form-group">
						<label for="start-hours">Ending Hour:</label>
						<input class="form-control type="text" name="end-hour"/>
					</div>
					<button type="submit" class="btn btn-primary" name="freetime-submit">Submit</button>
				</form>
			</div>
		</div>

		';

	include 'base.php';
?>