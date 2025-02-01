<!-- Delete Patient Page -->
<!-- Programmer name: 97 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<!-- Link CSS sheet -->
<link rel="stylesheet" href="stylesheet.css">
<title>Delete Patient</title>
</head>
<body>

<!-- Home button -->
<a href="mainmenu.html" style="display: inline-block; text-decoration: none; margin-bottom: 20px; background-color: black; color: white; font-family: 'Comic Sans MS', 'Comic Sans', cursive; font-size: 16px; padding: 10px 20px; border-radius: 0;"
   onmouseover="this.style.backgroundColor='red';"
   onmouseout="this.style.backgroundColor='black';">Home</a>

<h1>Delete Patient</h1>

<!-- Form for delete patient -->
<form action="delete_patient.php" method="post">
	<label for="patient"> Please select a patient for deletion: </label>
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
	<button type="submit" name="submit">Submit for Deletion </button>
</form>

<!-- Delete patient from table -->
	<?php
		include 'connectdb.php';
		// Confirmation Block
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
			// Get OHIP number from the initial form submission
			$ohip = $_POST['patient'];
			// Display confirmation form
			echo "<p>Are you sure you want to delete the patient with OHIP number: $ohip?</p>";
			echo '<form method="post">';
			echo "<input type='hidden' name='patient' value='$ohip'>";
			echo '<button type="submit" name="confirm" value="yes">Delete</button>';
			echo '<button type="submit" name="confirm" value="no">Cancel</button>';
			echo '</form>';
			// Close connection and wait for form submission
			mysqli_close($connection);
			exit;
		}
	?>
	<?php
		include 'connectdb.php';
		// Deletion Block
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
			// Get OHIP number from the confirmation form submission
			$ohip = $_POST['patient'];
			// Process the confirmation response
			if ($_POST['confirm'] === 'yes') {
				// Execute the deletion
				$deleteQuery = "DELETE FROM patient WHERE ohip = '$ohip'";
				if (mysqli_query($connection, $deleteQuery)) {
					echo "<p>Patient (OHIP: $ohip) has been deleted successfully.</p>";
				} else {
					echo "<p>Error deleting patient: " . mysqli_error($connection) . "</p>";
				}
			}
			elseif ($_POST['confirm'] === 'no') {
				echo "<p>Deletion cancelled.</p>";
			}
			// Close the database connection
			mysqli_close($connection);
		}
	?>
</body>
</html>