<!-- Doctor Patient Page -->
<!-- Programmer name: 97 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<!-- Link CSS sheet -->
<link rel="stylesheet" href="stylesheet.css">
<title>Doctors' Patients</title>
</head>
<body>

<!-- Home button -->
<a href="mainmenu.html" style="display: inline-block; text-decoration: none; margin-bottom: 20px; background-color: black; color: white; font-family: 'Comic Sans MS', 'Comic Sans', cursive; font-size: 16px; padding: 10px 20px; border-radius: 0;"
   onmouseover="this.style.backgroundColor='red';"
   onmouseout="this.style.backgroundColor='black';">Home</a>

<h1>Doctors' Patients</h1>
<p> Please select a doctor to see a list of their patients...</p>

<!-- Form for selecting a doctor -->
<form method="post" action="">
    <select id="doctor" name="doctor" required>
        <option value="">Select Doctor</option>
        <?php
        include 'connectdb.php';

        // Fetch all doctors from the database
        $query = "SELECT docid, firstname, lastname FROM doctor";
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['docid']}'>{$row['firstname']} {$row['lastname']}</option>";
        }

        mysqli_free_result($result);
        ?>
    </select>
    <button type="submit" name="submit">Show Patients</button>
</form>


<ul>
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
		include 'connectdb.php';

		// Get selected doctor ID
		$doctorId = $_POST['doctor'];

		// Fetch the patients of the selected doctor
		$query = "SELECT
					patient.firstname,
					patient.lastname
					FROM patient
					WHERE patient.treatsdocid = '$doctorId'";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			echo mysqli_error($connection);
			die("Database query failed");
		}

		// Display the list of patients
		echo "<p>Patient List for Doctor with ID # $doctorId...</p>";
		echo "<ul>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<li>" . $row["firstname"] . " " . $row["lastname"] . "</li>";
		}
		echo "</ul>";

		mysqli_free_result($result);
		mysqli_close($connection);
}?>
	</ul>
	</body>
	</html>