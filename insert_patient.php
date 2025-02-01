<!-- Insert Patient Page -->
<!-- Programmer name: 97 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="stylesheet.css">
<title>Insert Patient</title>
</head>
<body>
<!-- Insert home button -->
<a href="mainmenu.html" style="display: inline-block; text-decoration: none; margin-bottom: 20px; background-color: black; color: white; font-family: 'Comic Sans MS', 'Comic Sans', cursive; font-size: 16px; padding: 10px 20px; border-radius: 0;"
   onmouseover="this.style.backgroundColor='red';"
   onmouseout="this.style.backgroundColor='black';">Home</a>

<h1>Insert Patient</h1>

<!-- Forms for insert doctor -->
<form action="insert_patient.php" method="post">
    <label for="ohip">OHIP Number:</label>
    <input type="text" id="ohip" name="ohip" required>

    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" required>

    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" required>

    <label for="weight">Weight (kg):</label>
    <input type="number" id="weight" name="weight" step="0.1" required>

    <label for="height">Height (m):</label>
    <input type="number" id="height" name="height" step="0.01" required>

    <label for="birthdate">Birthdate:</label>
    <input type="date" id="birthdate" name="birthdate" required>

    <label for="doctor">Assign Doctor:</label>
	<select id="doctor" name="doctor" required>
    <option value="">Select a Doctor</option>
	<?php
        // Include database connection
        include 'connectdb.php';

        // Fetch doctors from the database
        $query = "SELECT docid, firstname, lastname FROM doctor";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($result)){
			echo "<option value='{$row['docid']}'>{$row['firstname']} {$row['lastname']}</option>";
        }
        mysqli_free_result($result);
        mysqli_close($connection);
    ?>
	</select><br><br>
	<button type="submit" name="submit">Insert Patient</button>
</form>

<ol>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
			//Connect database
			include 'connectdb.php';
			//Collect data in variables
			$ohip = $_POST['ohip'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$weight = $_POST['weight'];
			$height = $_POST['height'];
			$birthdate = $_POST['birthdate'];
			$doctor = $_POST['doctor'];

			//Check if ohip number exists
			$checkQuery = "SELECT ohip FROM patient WHERE ohip = '$ohip'";
			$checkResult = mysqli_query($connection, $checkQuery);
			if (mysqli_num_rows($checkResult) > 0) {
			// If OHIP already exists
				echo "<p style='color: red; text-align: center;'>Error: Could not insert patient, OHIP number is not unique.</p>";
			}
			else {
			// Insert the new patient into the database
			$insertQuery = "INSERT INTO patient (ohip, firstname, lastname, weight, height, birthdate, treatsdocid)
							VALUES ('$ohip', '$firstname', '$lastname', $weight, $height, '$birthdate', '$doctor')";

				if (mysqli_query($connection, $insertQuery)) {
					echo "<p> New patient added successfully!</p>";
				}
				else {
					echo "<p>Error: " . mysqli_error($connection) . "</p>";
				}
			}

			mysqli_close($connection);
		}
	?>
</ol>
</body>
</html>
