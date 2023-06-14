<?php
session_start();

// Check if the faculty is logged in and retrieve the faculty username from the session
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or handle unauthorized access
    header("Location: facultylogin.php");
    exit();
}

// Retrieve the faculty username from the session
$facultyUsername = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>FACULTY page</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    /* Rest of the CSS styles omitted for brevity */
#topFrame {
      height: 50px;
      background-color: #f1f1f1;
      text-align: center;
      line-height: 50px;
      position: relative;
      display: flex;
      align-items: center;
    }

    #topFrame img {
      cursor: pointer;
      margin-right: 10px;
      height: 30px;
      width: 30px;
    }

    #topFrame .time {
      position: absolute;
      top: 0;
      right: 20px;
      font-size: 18px;
      color: #555;
      font-weight: bold;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    #bottomFrame {
      display: flex;
      height: calc(100vh - 50px);
    }

    #leftFrame {
      width: 20%;
      background-color: #e0e0e0;
      padding: 20px;
    }

    #rightFrame {
      flex: 1;
      padding: 20px;
    }

    .button {
      display: block;
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      text-align: center;
      cursor: pointer;
    }

    .button:hover {
      background-color: #45a049;
    }

    #calendar {
      width: 100%;
      height: 100%;
      border: none;
      display: block;
    }
    
    #targetPage {
      width: 100%;
      height: 100%;
      border: none;
      display: none;
    }
 
  </style>
  <script>
    // Function to update the current time in the top frame
    function updateTime() {
      var currentTime = new Date();
      var hours = currentTime.getHours();
      var minutes = currentTime.getMinutes();
      var seconds = currentTime.getSeconds();

      // Add leading zeros if necessary
      hours = (hours < 10 ? "0" : "") + hours;
      minutes = (minutes < 10 ? "0" : "") + minutes;
      seconds = (seconds < 10 ? "0" : "") + seconds;

      var timeString = hours + ":" + minutes + ":" + seconds;

      // Update the time in the top frame
      var timeElement = document.getElementById("currentTime");
      if (timeElement) {
        timeElement.textContent = timeString;
      }
    }

    // Function to navigate to the "Edit Profile" page
    function navigateToUpdateProfile() {
      window.location.href = "edit_prof.php";
    }

    // Function to show target page in the right frame
    function showTargetPage() {
      document.getElementById("calendar").style.display = "none";
      document.getElementById("targetPage").style.display = "block";
    }

    // Function to show calendar in the right frame
    function showCalendar() {
      document.getElementById("calendar").style.display = "block";
      document.getElementById("targetPage").style.display = "none";
    }

    // Function to update the faculty username in the heading
    function updateFacultyUsername() {
      var facultyUsername = "<?php echo $facultyUsername; ?>";
      var facultyPortalHeading = document.getElementById("facultyPortalHeading");
      if (facultyPortalHeading) {
        facultyPortalHeading.textContent = "FACULTY PORTAL - " + facultyUsername;
      }
    }

    // Update the time every second
    setInterval(updateTime, 1000);

    // Update the faculty username when the page loads
    window.onload = updateFacultyUsername;
  </script>
</head>
<body>
  <div id="topFrame">
    <div class="time" id="currentTime"></div>
    <h2 style="margin: 0 auto;" id="facultyPortalHeading">FACULTY PORTAL</h2>
  </div>
  <div id="bottomFrame">
    <div id="leftFrame">
      <a class="button" href="edit_prof.php" target="targetPage" onclick="showTargetPage()">EDIT PROFILE</a>
      <a class="button" href="f_Table1.php" target="targetPage" onclick="showTargetPage()">VIEW FACULTY TIMETABLE</a>
      <a class="button" href="f_view_schedule.php" target="targetPage" onclick="showTargetPage()">VIEW MY SCHEDULE</a>
      <a class="button" href="check_slot.php" target="targetPage" onclick="showTargetPage()">CHECK SLOT AVAILABILITY</a>
      <a class="button" href="swap_request.php" target="targetPage" onclick="showTargetPage()">SEND SWAP REQUEST</a>
      <a class="button" href="view_swap.php" target="targetPage" onclick="showTargetPage()">VIEW SWAP REQUEST</a>
      <a class="button" href="view_accept.php" target="targetPage" onclick="showTargetPage()">VIEW ACCEPTED SWAP REQUEST</a>
      <a class="button" href="view_deny.php" target="targetPage" onclick="showTargetPage()">VIEW DENIED SWAP REQUEST</a>
      <a class="button" href="course.php" target="targetPage" onclick="showTargetPage()">VIEW COURSE HANDLING FACULTY</a>
      <a class="button" href="#" target="targetPage" onclick="showTargetPage()">SEND SWAP REQUEST(LAB)</a>

      <a class="button" href="bundle.php" target="targetPage" onclick="showTargetPage()">BUNDLE SUBMISSION</a>
    </div>
    <div id="rightFrame">
      <iframe id="calendar" src="calendar.html" name="calendar" style="width: 100%; height: 100%; border: none;"></iframe>
      <iframe id="targetPage" name="targetPage" style="width: 100%; height: 100%; border: none;"></iframe>
    </div>
  </div>
</body>
</html>
