<?php
session_start();
include_once "BackEnd/connection.php";

if (!isset($_SESSION['unique_id'])) {
  header("location: login.php");
  exit();
}
$unique_id = $_SESSION['unique_id'];

if (strpos($unique_id, 'TP') === 0) {
  include_once "Sheader.php";
} elseif (strpos($unique_id, 'LP') === 0) {
  include_once "Lheader.php";
} elseif (strpos($unique_id, 'AP') === 0) {
  include_once "AHeader.php";
}


?>
<!DOCTYPE html>
<html>

<head>
  <style>

    .finance-container {
      display: flex;
      padding: 100px;
    }

    .finance-left-container {
      width: 50%;
      padding-right: 10px;
    }

    .finance-ul {
      padding: 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      list-style-type: none;

    }


    .finance-li {
      transition: border 0.3s;
    }

    .finance-toggle-li {
      display: none;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      padding: 5px;
      border-radius: 3px;
    }

    .finance-toggle-li a {
      text-decoration: none;
      color: #777;

    }

    .finance-toggle-li :hover {
      background-color: #ddd;

    }

    .finance-ul li {
      padding: 5px;
      border-radius: 3px;
      font-family: 'Times New Roman', Times, serif;
    }

    .finance-li ul {
      display: none;
    }

    .finance-right-container {
      width: 50%;
      padding-left: 10px;
    }


    .clearfix::after {
      content: "";
      clear: both;
      display: table;
    }

    .finance-toggle-arrow {
      display: inline-block;
      vertical-align: middle;
      margin-left: 10px;
      font-size: 20px;
      cursor: pointer;
    }


    .finance-toggle-arrow:hover {
      color: #007bff;
    }

 
    .finance-item1,
    .finance-item2,
    .finance-item3,
    .finance-item4,
    .finance-item5,
    .finance-item6 {
      font-size: 24px;
    }

    .finance-item7 a {
      text-decoration: none;
      color: #777;
    }

    .finance-right-container {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 20px;
    }


    .finance-right-container p {
      padding: 10px;
      margin-bottom: 10px;
    }

    .finance-right-container a {
      text-decoration: none;
      color: #777;
    }

    .finance-right-container p:hover {
      background-color: #ddd;
    }
  </style>
</head>

<?php
        $unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);
        $table = '';

        if (strpos($unique_id, 'TP') === 0) {
            $table = 'student';
        } elseif (strpos($unique_id, 'LP') === 0) {
            $table = 'lecturer';
        } elseif (strpos($unique_id, 'AP') === 0) {
            $table = 'admin';
        }

        if ($table !== '') {

            $sql = "SELECT * FROM $table WHERE unique_id = '$unique_id'";
            $query = mysqli_query($conn, $sql);

            if (mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                ?>


<body style="background-color: #fff; color: #777;">

  <div class="finance-container">
    <div class="finance-left-container">
      <ul class="finance-ul">
        <li onclick="toggleListItem(1)" class="finance-item1">
          Finance
          <span class="finance-toggle-arrow" onclick="toggleListItem(1)">&#9658;</span>
          <ul class="finance-toggle-li">
            <a href="#">
              <li>Fees</li>
            </a>
            <a href="#">
              <li>PTPTN</li>
            </a>
            <a href="#">
              <li>Scholarship & Loan(Malaysians)</li>
            </a>
            <a href="#">
              <li>Retake Modules, Resit & EC fees</li>
            </a>
          </ul>
        </li>
        <li onclick="toggleListItem(2)" class="finance-item2">
          Collaboration & Information Resources
          <span class="finance-toggle-arrow" onclick="toggleListItem(2)">&#9658;</span>
          <ul class="finance-toggle-li">
            <a href="#">
              <li>APSpace Feedback</li>
            </a>
            <a href="#">
              <li>Feedback</li>
            </a>
            <a href="#">
              <li>E-Froms</li>
            </a>
          </ul>
        </li>
        <li onclick="toggleListItem(3)" class="finance-item3">
          Campus Life
          <span class="finance-toggle-arrow" onclick="toggleListItem(3)">&#9658;</span>
          <ul class="finance-toggle-li">
            <a href="#">
              <li>Bus Shuttle Services</li>
            </a>
            <a href="#">
              <li>Holidays</li>
            </a>
            <a href="#">
              <li>Personal Counseling</li>
            </a>
          </ul>
        </li>
        <li onclick="toggleListItem(4)" class="finance-item4">
          Academic & Enrollment
          <span class="finance-toggle-arrow" onclick="toggleListItem(4)">&#9658;</span>
          <ul class="finance-toggle-li">
            <a href="#">
              <li>Attendance</li>
            </a>
            <a href="#">
              <li>Course Schedule</li>
            </a>
            <a href="#">
              <li>Exam Schedule</li>
            </a>
          </ul>
        </li>
        <li onclick="toggleListItem(5)" class="finance-item5">
          Career Centre & Corporate Trainning
          <span class="finance-toggle-arrow" onclick="toggleListItem(5)">&#9658;</span>
          <ul class="finance-toggle-li">
            <a href="#">
              <li>Corporate Trainning Homepage</li>
            </a>
            <a href="#">
              <li>Job & Internship Opportunities</li>
            </a>
            <a href="#">
              <li>Carrer Centre Facebook</li>
            </a>
          </ul>
        </li>
        <li onclick="toggleListItem(6)" class="finance-item6">
          Others
          <span class="finance-toggle-arrow" onclick="toggleListItem(6)">&#9658;</span>
          <ul class="finance-toggle-li">
            <a href="#">
              <li>Classroom Finder</li>
            </a>
            <a href="#">
              <li>Profile</li>
            </a>
            <a href="#">
              <li>Settings</li>
            </a>
            <a href="SearchAll.php">
              <li>User Directory</li>
            </a>
          </ul>
        </li>
        <li onclick="toggleListItem(7)" class="finance-item7">
        <a href="BackEnd/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">
        Logout 
        </a>
        </li>


      </ul>
    </div>
    <div class="finance-right-container">
      <h2>Favorites</h2>
 
      <p><a href="userinfo.php">Profile</a></p>
      <p><a href="chatlist.php">Chat</a></p>
      <p><a href="SearchAll.php">Search User</a></p>
      <p><a href="changepassword.php">ChangePassword</a></p>
    </div>
  </div>
  <?php
            }
        }
        ?>

  <script>
    function toggleListItem(index) {

      var toggleElements = document.querySelectorAll('.finance-toggle-li');


      var arrowIcons = document.querySelectorAll('.finance-toggle-arrow');

  
      if (index > 0 && index <= toggleElements.length) {
        var toggleElement = toggleElements[index - 1];
        var arrowIcon = arrowIcons[index - 1];

        if (toggleElement.style.display === 'block') {
          toggleElement.style.display = 'none';
          arrowIcon.innerHTML = '&#9658;'; 
        } else {

          toggleElements.forEach(function (element) {
            element.style.display = 'none';
          });
          arrowIcons.forEach(function (icon) {
            icon.innerHTML = '&#9658;'; 
          });

          toggleElement.style.display = 'block';
          arrowIcon.innerHTML = '&#9660;'; 


          var subitems = toggleElement.querySelectorAll('ul.finance-toggle-li li');
          subitems.forEach(function (subitem) {
            subitem.style.display = 'block';
          });
        }
      }
    }
  </script>

</body>

</html>