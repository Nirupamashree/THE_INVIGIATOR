<?php
// Start the session
session_start();

// Check if the user is logged in and the username is stored in the session
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page or handle the authentication as per your application's logic
    header("Location: facultylogin.php"); // Replace 'login.php' with your login page URL
    exit();
}

// Get the faculty name from the session
$facultyName = $_SESSION['username'];

// Define variables for alert messages
$successMessage = '';
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the remaining form data
    $date = $_POST['date'];
    $day = date('l', strtotime($date)); // Automatically fill the day based on the selected date
    $slot = $_POST['slot'];
    $venue = $_POST['venue'];
    $classroom = $_POST['classroom'];
    $noOfStudents = $_POST['noOfStudents'];
    $noOfAbsentees = $_POST['noOfAbsentees'];
    $noOfPapersCollected = $_POST['noOfPapersCollected'];

    // Connect to the database
    $servername = "localhost"; // Replace with your database server name
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "user1_db"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the record exists in the 'allocate' table
    $sql = "SELECT * FROM allocate WHERE facultyName = '$facultyName' AND date = '$date' AND day = '$day' AND slot = '$slot'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // The record exists, insert the form data into the 'bundle' table
        $insertSql = "INSERT INTO bundle (facultyName, date, day, slot, venue, classroom, noOfStudents, noOfAbsentees, noOfPapersCollected) VALUES ('$facultyName', '$date', '$day', '$slot', '$venue', '$classroom', $noOfStudents, $noOfAbsentees, $noOfPapersCollected)";
        if ($conn->query($insertSql) === TRUE) {
            $successMessage = "Form submitted successfully.";
        } else {
            $errorMessage = "Error: " . $insertSql . "<br>" . $conn->error;
        }
    } else {
        $errorMessage = "Record does not exist in the 'allocate' table.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bundle Submission Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
        }

        .alert {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bundle Submission Form</h2>

        <?php if (!empty($successMessage)): ?>
            <div class="alert success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Faculty Name:</label>
            <input type="text" name="facultyName" value="<?php echo $facultyName; ?>" readonly>

            <label>Date:</label>
            <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>

            <label>Day:</label>
            <input type="text" id="day" name="day" readonly>

            <label>Slot:</label>
            <select name="slot" required>
                <option value="">Select a slot</option>
                <option value="slot1">slot1</option>
                <option value="slot2">slot2</option>
                <option value="slot3">slot3</option>
                <option value="slot4">slot4</option>
                <option value="slot5">slot5</option>
                <option value="slot6">slot6</option>
                <option value="slot7">slot7</option>
                <option value="slot8">slot8</option>
            </select>

            <label>Venue:</label>
            <select name="venue" required>
                <option value="">Select a venue</option>
                <option value="Venue 1">ab1</option>
                <option value="Venue 2">ab2</option>
                <option value="Venue 3">ab3</option>
            </select>

            <label>Classroom:</label>
            <input type="text" name="classroom" required>

            <label>No. of Students:</label>
            <input type="number" name="noOfStudents" required min="1" max="72">

            <label>No. of Absentees:</label>
            <input type="number" name="noOfAbsentees" required min="0" max="72">

            <label>No. of Papers Collected:</label>
            <input type="number" name="noOfPapersCollected" required min="0" max="71">

            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        // JavaScript code to automatically fill the day field based on the selected date
        document.getElementById("date").addEventListener("change", function() {
            var selectedDate = new Date(this.value);
            var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var selectedDay = days[selectedDate.getDay()];
            document.getElementById("day").value = selectedDay;
        });
    </script>
</body>
</html>
