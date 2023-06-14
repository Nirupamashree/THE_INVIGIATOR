<!DOCTYPE html>
<html>
<head>
    <title>Allocate Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .filter-container input[type="text"] {
            padding: 10px;
            margin-left: 10px;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: white; 
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .table-container {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <h1>ALLOCATED RECORDS</h1>

    <div class="filter-container">
        <label for="filter">Search:</label>
        <input type="text" id="filter" name="filter" placeholder="Enter a keyword">
    </div>

    <div class="table-container">
        <table id="recordsTable">
            <thead>
                <tr>
                    <th>Faculty Name</th>
                    <th>Semester</th>
                    <th>Course</th>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Slot</th>
                    <th>Venue</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "user1_db";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch records from the allocate table
                $sql = "SELECT * FROM `{$dbname}`.`allocate`";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['facultyName']}</td>";
                        echo "<td>{$row['semester']}</td>";
                        echo "<td>{$row['course']}</td>";
                        echo "<td>{$row['date']}</td>";
                        echo "<td>{$row['day']}</td>";
                        echo "<td>{$row['slot']}</td>";
                        echo "<td>{$row['venue']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Filter table rows based on the entered keyword
        document.getElementById("filter").addEventListener("keyup", function() {
            var keyword = this.value.toLowerCase();
            var table = document.getElementById("recordsTable");
            var rows = table.getElementsByTagName("tr");

            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var found = false;

                for (var j = 0; j < cells.length; j++) {
                    var cellText = cells[j].textContent || cells[j].innerText;

                    if (cellText.toLowerCase().indexOf(keyword) > -1) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    </script>
</body>
</html>
