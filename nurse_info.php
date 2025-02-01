<!-- Nurse Info Page -->
<!-- Programmer name: 97 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<!-- Link CSS sheet -->
<link rel="stylesheet" href="stylesheet.css">
<title>Nurse Info</title>
</head>
<body>

<!-- Home button -->
<a href="mainmenu.html" style="display: inline-block; text-decoration: none; margin-bottom: 20px; background-color: black; color: white; font-family: 'Comic Sans MS', 'Comic Sans', cursive; font-size: 16px; padding: 10px 20px; border-radius: 0;"
   onmouseover="this.style.backgroundColor='red';"
   onmouseout="this.style.backgroundColor='black';">Home</a>

<h1>Nurse Info</h1>
<p> Please select a nurse to see their info...</p>

<!-- Form for selecting a nurse -->
<form method="post" action="">
    <select id="nurse" name="nurse" required>
        <option value="">Select A Nurse</option>
        <?php
        include 'connectdb.php';

        // Fetch all nurses from the database
        $query = "SELECT nurseid, firstname, lastname FROM nurse";
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['nurseid']}'>{$row['firstname']} {$row['lastname']}</option>";
        }

        mysqli_free_result($result);
        ?>
    </select>
    <button type="submit" name="submit">Show Info</button>
</form>

<!-- Output results of query -->
<ul>
	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
			include 'connectdb.php';

			// Get the selected nurse ID directly from $_POST
			$nurseId = $_POST['nurse'];

			//Query to fetch all relevant details
			$query = "SELECT
						nurse.firstname AS nurse_firstname,
						nurse.lastname AS nurse_lastname,
						supervisor.firstname AS supervisor_firstname,
						supervisor.lastname AS supervisor_lastname,
						doctor.firstname AS doctor_firstname,
						doctor.lastname AS doctor_lastname,
						workingfor.hours
					FROM nurse
					LEFT JOIN workingfor ON nurse.nurseid = workingfor.nurseid
					LEFT JOIN doctor ON workingfor.docid = doctor.docid
					LEFT JOIN nurse AS supervisor ON nurse.reporttonurseid = supervisor.nurseid
					WHERE nurse.nurseid = '$nurseId'";

			$result = mysqli_query($connection, $query);

			if (!$result) {
				echo mysqli_error($connection);
				die("Database query failed");
			}

			$totalHours = 0;

			// Output the result of the query with the relevant info
			$row = mysqli_fetch_assoc($result);
			if ($row) {
				echo "<p> <strong> Nurse: </strong>" . $row['nurse_firstname'] . " " . $row['nurse_lastname'] . "</p>";
				echo "<p><strong>Supervisor: </strong>" . ($row['supervisor_firstname'] ? $row['supervisor_firstname'] . " " . $row['supervisor_lastname'] : "No supervisor") . "</p>";
				echo "<p> <strong> Doctors Worked Under... </strong> </p>";
				echo "<ul>";

				// Output doctors with hours
				while ($row = mysqli_fetch_assoc($result)) {
					if ($row['doctor_firstname'] && $row['doctor_lastname']) {
						echo "<li>Dr. " . $row['doctor_firstname'] . " " . $row['doctor_lastname'] . " - " . $row['hours'] . " hours</li>";
						$totalHours += $row['hours'];
					}
				}

				echo "</ul>";
				echo "<p> <strong> Total Hours Worked: </strong>  $totalHours </p>";
			}
			else {
				echo "<p>No details found for the selected nurse.</p>";
			}

			mysqli_free_result($result);
			mysqli_close($connection);
		}
	?>
</ul>
</body>
</html>