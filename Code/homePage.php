<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then hide nav-right div
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  echo "<script src='js/main.js'> body.onload = menuFunc2('nav-right'); </script>";
}
?>

<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>VSB_Plus : HomePage</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="team_vsbp">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" href="#">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/homePage.css">
</head>

<body>

  <header>
    <a href="https://www.uregina.ca"><img src="img/logo.png" class="logo" alt="UofR"></a>
    <h1>Visual Schedule Builder Plus</h1>
  </header>

  <nav>
    <div class="menu-icon" onclick="menuFunc1(this); menuFunc2('menu-list');">
      <div class="bar1"></div>
      <div class="bar2"></div>
      <div class="bar3"></div>
    </div>
    <a class="menu-list" href="academicBuilder.html">Academic Schedule Builder</a>
    <a class="menu-list" href="semesterBuilder.php">Semester Schedule Builder</a>
    <a class="menu-list" href="courseDB.html">Course List Database</a>
    <div class="nav-right">
      <a id="usertext" onclick="addonSwitchFunc()"><?php echo htmlspecialchars($_SESSION["name"]); ?></a>
      <div id="addon-menu">
        <a><?php echo htmlspecialchars($_SESSION["sid"]); ?></a>
        <a href="Model/logout.php">Logout</a>
      </div>
    </div>
  </nav>

  <section class="container">
    <div class="left-section">
      <article class="left-upper">
        <h2>Project Description</h2>

        <p>The purpose of this UofR Software Engineeriing Capstone Project is to enhance the functionaility of UofR
          existing Visual Schedule Builder and helping future students course selection easier.</p>

        <p>This project will be focused on the students, the building up of their classes schedule. The opinions from
          the professors of different faculty and the students are mainly to be considering. The Visual Schedule Builder
          Plus will be designed for students into the different faculty. Then through the faculty, according to the
          importance and limitations of classes, the Visual Schedule Builder Plus will recommend the courses to take for
          the students in the different semesters. After the students have chosen and built up their desired time
          schedule, the Visual Schedule Builder Plus can also give out some advice on their time table to help them for
          better time planning.</p>

        <p>A good design of the Visual Schedule Builder Plus that will help to organize and build up the time table
          wisely.It is to solve the problems such as considering what courses to take first to be able to graduate in
          time, knowing the different limitations of each course(for example, the prerequisites in order to take the
          class, and when it offers, or the credit hours requires), as well to be aware of which elective classes to
          take that will benefit them in the future based on their faculty. The enhancing of the functionality for U of
          R existing Visual Schedule Builder will help the students to select the courses easier.</p>

        <img class="screenshot" src="img/screenshot.PNG"></img>
      </article>
      <article class="left-lower">
        <h2>Team Info</h2>
        <section class="photoInfo-section">
          <div class="photoInfo">
            <img class="photo" src="img/anyone.jpg"></img>
            <p>Name: Xinyu Liu</p>
            <p>SID: 200362878</p>
            <p>Position: Scrum Master</p>
          </div>
          <div class="photoInfo">
            <img class="photo" src="img/Jingkang_yang.jpeg"></img>
            <p>Name: Jingkang Yang</p>
            <p>SID: 200362586</p>
            <p>Position: Developer</p>
          </div>
          <div class="photoInfo">
            <img class="photo" src="img/psyduck.png"></img>
            <p>Name: Xia Hua</p>
            <p>SID: 200368746</p>
            <p>Position: Developer</p>
          </div>
          <div class="photoInfo">
            <img class="photo" src="img/anyone.jpg"></img>
            <p>Name: Priscilla Chua</p>
            <p>SID: 200363504</p>
            <p>Position: Business Analysis</p>
          </div>
        </section>
        <div class="team-desc">
          <h3>Team Description:</h3>
          <p>Our goal is to create a user friendly, interactive schedule builder. We are a group of University of Regina
            Software Engineering students.</p>
        </div>
      </article>
    </div>
    <div class="right-section">
      <div class="update-log">
        <h2>Update Log</h2>

        <h3>Project #1</h3>
        <ul>
          <li>main.html page create</li>
          <li>database create</li>
          <h4>2020-10-28</h4>
        </ul>

        <h3>Project #2</h3>
        <ul>
          <li>academicBuilder.html page create</li>
          <li>database create</li>
          <h4>2020-11-02</h4>
        </ul>
      </div>

      <div class="contact-us">
        <h2>Contact Us</h2>

        <h3>GitHub</h3>
        <ul>
          <li><a href="https://github.com/yang242j/VSB_Plus">VSB_Plus</a></li>
        </ul>

        <h3>Email</h3>
        <ul>
          <li>liu725@uregina.ca</li>
          <li>yang242j@uregina.ca</li>
          <li>name@example.com</li>
          <li>name@example.com</li>
        </ul>
      </div>
    </div>

  </section>

  <footer>
    <script src="js/main.js"></script>
    <p class="copyright">Copyright &copy; Sep. 2020 to
      <script>
        document.write(new Date().getFullYear())
      </script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
      <cite>
        Credit: Login source code from w3schools.com "How TO - Login Form"
      </cite>
    </p>
    <p class="info-link"><a href="homePage.php">About Us</a></p>
  </footer>
</body>

</html>