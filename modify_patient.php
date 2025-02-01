<!-- Modify Patient Page -->
<!-- Programmer name: 97 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<!-- Link CSS sheet -->
<link rel="stylesheet" href="stylesheet.css">
<title>Modify Patient</title>
</head>
<body>

<!-- Home button -->
<a href="mainmenu.html" style="display: inline-block; text-decoration: none; margin-bottom: 20px; background-color: black; color: white; font-family: 'Comic Sans MS', 'Comic Sans', cursive; font-size: 16px; padding: 10px 20px; border-radius: 0;"
   onmouseover="this.style.backgroundColor='red';"
   onmouseout="this.style.backgroundColor='black';">Home</a>

<h1>Modify Patient</h1>

<!-- Form for Modify patient -->
<form action="modify_patient.php" method="post">
	<!-- Select patient-->
	<label for="patient"> Please select a patient for modification: </label>
	<select id="patient" name="patient" required>
	<option value="">Select Patient</option>
	<?php
        // Include database connection
        include 'connectdb.php';

        // Fetch patients from the database
        $query = "SELECT * FROM patient";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($result)){
			echo "<option value='{$row['ohip']}'>{$row['firstname']} {$row['lastname']}</option>";
        }
        mysqli_free_result($result);
        mysqli_close($connection);
    ?>
	</select><br><br>

	<!-- Enter weight with radio buttons for units-->
	<label for="weight">Enter New Weight:</label>
    <input type="number" id="weight" name="weight" step="0.1" required><br>
    <label for="unit">Select Unit:</label>
    <input type="radio" id="kg" name="unit" value="kg" required>
    <label for="kg">Kilograms</label>
    <input type="radio" id="lbs" name="unit" value="lbs" required>
    <label for="lbs">Pounds</label><br><br>

    <button type="submit" name="submit">Submit Modification</button>
</form>

<!-- Modify patient from table -->
	<?php
		include 'connectdb.php';
		// Confirmation Block
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
			// Get OHIP number from the initial form submission
			$ohip = $_POST['patient'];
			$weight = $_POST['weight'];
   			$unit = $_POST['unit'];
			// Convert weight to kilograms if entered in pounds
			if ($unit === 'lbs') {
				$weight = round($weight / 2.2046, 2); // Convert pounds to kilograms
			}
			//Update query
			$updateQuery = "UPDATE patient SET weight = $weight WHERE ohip = '$ohip'";
			if (mysqli_query($connection, $updateQuery)) {
				echo "<p>Patient's weight has been updated successfully.</p>";
			} else {
				echo "<p>Error updating weight: " . mysqli_error($connection) . "</p>";
			}

			mysqli_close($connection);
		}
	?>
</body>
</html>