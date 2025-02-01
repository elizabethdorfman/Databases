<!-- See Patients Page -->
<!-- Programmer name: 97 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<!-- Link CSS sheet -->
<link rel="stylesheet" href="stylesheet.css">
<title>See All Patients</title>
</head>
<body>

<!-- Home button -->
<a href="mainmenu.html" style="display: inline-block; text-decoration: none; margin-bottom: 20px; background-color: black; color: white; font-family: 'Comic Sans MS', 'Comic Sans', cursive; font-size: 16px; padding: 10px 20px; border-radius: 0;"
   onmouseover="this.style.backgroundColor='red';"
   onmouseout="this.style.backgroundColor='black';">Home</a>

<h1>See All Patients</h1>

<!-- Form for sorting options -->
<form method="post">
<label>Order By:</label><br>
    <input type="radio" id="lastname" name="orderby" value="lastname"
    <?php echo (isset($_POST['orderby']) && $_POST['orderby'] == 'lastname') ? 'checked' : ''; ?>>
    <label for="asc">Last Name</label><br>

    <input type="radio" id="firstname" name="orderby" value="firstname"
    <?php echo (isset($_POST['orderby']) && $_POST['orderby'] == 'firstname') ? 'checked' : ''; ?>>
    <label for="desc">First Name</label><br><br>

    <label>Sort Order:</label><br>
    <input type="radio" id="asc" name="order" value="ASC"
    <?php echo (isset($_POST['order']) && $_POST['order'] == 'ASC') ? 'checked' : ''; ?>>
    <label for="asc">Ascending</label><br>

    <input type="radio" id="desc" name="order" value="DESC"
    <?php echo (isset($_POST['order']) && $_POST['order'] == 'DESC') ? 'checked' : ''; ?>>
    <label for="desc">Descending</label><br><br>

    <button type="submit">Sort</button>
</form>
<ol>
	<?php
		//Connect to database
		include 'connectdb.php';
		//Set order options from form post request
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : 'lastname';
		$order = isset($_POST['order']) ? $_POST['order'] : 'ASC';

		//Query to get data
		$query = "SELECT
    	patient.ohip,
    	patient.firstname,
    	patient.lastname,
    	patient.weight,
    	patient.birthdate,
    	patient.height,
    	patient.treatsdocid,
    	doctor.firstname AS doctor_firstname,
   		doctor.lastname AS doctor_lastname
		FROM patient
		LEFT JOIN doctor ON patient.treatsdocid = doctor.docid
		ORDER BY $orderby $order";

		//Extract result of query
		$result = mysqli_query($connection, $query);

		//If query failed
		if (!$result) {
			echo mysqli_error($connection);
			die("Database query failed");
		}

		//Render query results
		while ($row=mysqli_fetch_assoc($result)) {
			$weight_lbs = round($row['weight'] * 2.20462, 2);
       		$height_ft = intval($row['height'] * 3.28084);
        	$height_in = round(($row['height'] * 39.3701) % 12, 2);
			echo '<li>';
			echo 'Name: ' . $row['firstname'] . ' ' . $row['lastname'] . '<br>';
			echo 'OHIP: ' . $row['ohip'] . '<br>';
			echo 'Weight: ' . $row['weight'] . ' kg (' . $weight_lbs . ' lbs)<br>';
			echo 'Height: ' . $row['height'] . ' m (' . $height_ft . ' ft ' . $height_in . ' in)<br>';
			echo 'Birthdate: ' . $row['birthdate'] . '<br>';
			echo 'Doctor: ' . ($row['doctor_firstname'] ? $row['doctor_firstname'] . ' ' . $row['doctor_lastname'] : 'No doctor assigned') . '<br>';
			echo '</li>';
		}
		mysqli_free_result($result);

		mysqli_close($connection);
	?>
</ol>
</body>
</html>
