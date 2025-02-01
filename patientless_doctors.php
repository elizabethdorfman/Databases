<!-- Patientless Page -->
<!-- Programmer name: 97 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<!-- Link CSS sheet -->
<link rel="stylesheet" href="stylesheet.css">
<title>Patientless Doctors</title>
</head>
<body>

<!-- Home button -->
<a href="mainmenu.html" style="display: inline-block; text-decoration: none; margin-bottom: 20px; background-color: black; color: white; font-family: 'Comic Sans MS', 'Comic Sans', cursive; font-size: 16px; padding: 10px 20px; border-radius: 0;"
   onmouseover="this.style.backgroundColor='red';"
   onmouseout="this.style.backgroundColor='black';">Home</a>

<h1>Patientless Doctors</h1>
<p> The following is a list of the doctors without any patients...</p>
<ul>
	<?php
		include 'connectdb.php';
		$query = "SELECT
					doctor.docid,
					doctor.firstname,
					doctor.lastname
					FROM doctor
					LEFT JOIN patient
					ON patient.treatsdocid = doctor.docid
					WHERE patient.ohip is NULL";

		//Extract result of query
		$result = mysqli_query($connection, $query);

		//If query failed
		if (!$result) {
			echo mysqli_error($connection);
			die("Database query failed");
		}

		//Render query results
		while ($row=mysqli_fetch_assoc($result)) {
			echo "<li>". $row["firstname"] . " " .$row["lastname"] . "\n" ;
			echo "--". "Doc Id: " . $row["docid"] . "</li>";

		}
		mysqli_free_result($result);
		mysqli_close($connection);
	?>
	</ul>
	</body>
	</html>