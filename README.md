# Medical Record Management System

This project is a web-based application for managing medical records, including patients, doctors, and nurses. It demonstrates basic CRUD operations using HTML, CSS, PHP, and a MySQL database.

## Folder Structure

- connectdb.php: Contains database connection logic.
- delete_patient.php: Handles patient deletion requests.
- doctor_patients.php: Displays the list of patients assigned to a specific doctor.
- insert_patient.php: Handles the addition of new patient records.
- mainmenu.html: Main menu for navigation across the system.
- modify_patient.php: Allows modification of patient details.
- nurse_info.php: Displays information about nurses.
- patientless_doctors.php: Lists doctors with no assigned patients.
- see_patients.php: Displays a list of all patients in the system.
- stylesheet.css: Contains the styles for the application's UI.
- moredatafall2024.sql: SQL file to set up the database with initial data and schema.

## Features

- Add Patient: Insert a new patient's details into the system.
- View Patients: See a list of all patients.
- Modify Patient: Update existing patient information.
- Delete Patient: Remove patient records from the system.
- Doctor and Nurse Management: View information about doctors and nurses.

## Setting Up the Database

### Step 1: Import the SQL File
1. Install MySQL Server if not already installed.
2. Open your MySQL client or use phpMyAdmin.
3. Create a new database (e.g., medical_records):
   CREATE DATABASE medical_records;
4. Import the provided SQL file (moredatafall2024.sql) into the database:
   mysql -u [username] -p medical_records < moredatafall2024.sql
   Replace [username] with your MySQL username.

### Step 2: Update the Database Connection
1. Open the connectdb.php file.
2. Replace the placeholders with your MySQL credentials:
   <?php
   $servername = "localhost"; // Replace with your database server
   $username = "your_username"; // Replace with your MySQL username
   $password = "your_password"; // Replace with your MySQL password
   $dbname = "medical_records"; // Replace with the database name

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);

   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>

## How to Run Locally

### Using PHP Built-In Server
1. Open a terminal in the project directory.
2. Start the server:
   php -S localhost:8000
3. Open a browser and navigate to http://localhost:8000/mainmenu.html.

### Using XAMPP
1. Place the project folder inside the htdocs directory of your XAMPP installation.
2. Start the Apache and MySQL servers from the XAMPP control panel.
3. Open a browser and navigate to:
   http://localhost/<your-folder-name>/mainmenu.html

This project relies on a MySQL database. Ensure the database is properly set up and the connection details in connectdb.php are accurate before deploying.
