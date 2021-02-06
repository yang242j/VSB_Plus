<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>VSB_Plus : Semester</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="team_vsbp">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/semester.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.css">

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.js"></script>
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
        <a class="menu-list" href="academicBuilder_main.html">Academic Schedule Builder</a>
        <a class="menu-list nav-active" href="semesterBuilder.php">Semester Schedule Builder</a>
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
        <div class="top-section">
            <label for="term">Choose a term:</label>
            <select id="term" onChange="termSelector()">
                <!-- onChange="this.form.submit()" -->
                <option value="fall 2020">Fall 2020</option>
                <option value="winter 2021">Winter 2021</option>
            </select>
            <p id="termDemo"></p>
        </div>
        <div class="left-section">
            <h3 class="section-title">Course List</h3>

            <div class="dropZone" ondrop="dropL(event)" ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)"><img src="img/drop-here.png" style="max-height: 100%;max-width: 100%;" draggable="false"></div>
            <!--
            <div class="courseTag noDrop" id="ense400" draggable="true" ondragstart="drag(event)">ENSE400</div>
            <div class="courseTag noDrop" id="ense496ac" draggable="true" ondragstart="drag(event)">ENSE496AC</div>
            <div class="courseTag noDrop" id="ense496ad" draggable="true" ondragstart="drag(event)">ENSE496AD</div>
            -->
        </div>
        <div class="middle-section">
            <h3 class="section-title">Course Detail Info</h3>
            <div class="courseInfo">
                <h2>ENSE 400</h2>
                <h4>ENSE Project Start-up</h4>
                <p>Course Detail Info: **** **** *** ** * * * **</p>
            </div>
            <div class="courseInfo">
                <h2>ENSE 496AC</h2>
                <h4>Artificial Intelligence</h4>
                <p>Course Detail Info: **** **** *** ** * * * **</p>
            </div>
            <div class="courseInfo">
                <h2>ENSE 496AD</h2>
                <h4>Machine Learning</h4>
                <p>Course Detail Info: **** **** *** ** * * * **</p>
            </div>
        </div>
        <div class="right-section">
            <h3 class="section-title">Weekly Schedule & Exam Date</h3>
            <div class="Calendar">
                <div id='calendar'></div>
            </div>
            <div class="Date">
                <p>Midterm Exam Date:</p>
                <ul>
                    <li>ENSE 400: /</li>
                    <li>ENSE 496AC: Tuesday, October 20, 2020</li>
                    <li>ENSE 496AD: Monday, October 26, 2020</li>
                </ul>
                <p>Final Exam Date:</p>
                <ul>
                    <li><mark>ENSE 400: Wednesday, December 16, 2020</mark></li>
                    <li>ENSE 496AC: Tuesday, December 22, 2020</li>
                    <li><mark>ENSE 496AD: Wednesday, December 16, 2020</mark></li>
                </ul>
            </div>
        </div>
        <div class="stick-bottom">
            <div class="bottom-left">
                Courses Completed: <br>
                <div class="courseTag noDrag" id="ense374" draggable="false">ENSE374</div>
            </div>
            <div class="bottom-right" ondrop="dropBR(event)" ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)">
                Courses To Take: <br>
                <div class="courseTag noDrop" id="ense401" draggable="true" ondragstart="drag(event)">ENSE401</div>
                <div class="courseTag noDrop" id="ense400" draggable="true" ondragstart="drag(event)">ENSE400</div>
                <div class="courseTag noDrop" id="ense496ac" draggable="true" ondragstart="drag(event)">ENSE496AC</div>
                <div class="courseTag noDrop" id="ense496ad" draggable="true" ondragstart="drag(event)">ENSE496AD</div>
            </div>
        </div>
    </section>

    <footer>
        <script src="js/main.js"></script>
        <script src="js/semester.js"></script>
        <p class="copyright">Copyright &copy; Sep. 2020 to
            <script>
                document.write(new Date().getFullYear())
            </script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
            <cite>
                Credit: Calendar source code from fullcalendar.io version 5.5.1<br>
                Fullcalendar tutorial: Youtube video "JS To-do List #14 FullCalendar - Rendering a Calendar with
                JavaScript"<br>
            </cite>
            Note: <br>
            When excessing this page, if user is logged in, getting user info and stay this page.<br>
            When excessing this page, if user is NOT logged in, redirect to the semesterLogin page to login.<br>
            When leaving this page, if user is logged in, every page will have a user info section at nav-right.<br>
            To log out, click the log off button in the user info section at nav-right.<br>
            If user is NOT logged in, every other page will NOT have a user info section at nav-right.<br>
        </p>
        <p class="info-link"><a href="homePage.php">About Us</a></p>
    </footer>
</body>

</html>