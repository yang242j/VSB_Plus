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
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script>
        var term = '';
        var courseList = [];
    </script>
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
        <a class="menu-list" href="courseDB.php">Course List Database</a>
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
            <select id="termSelector">
                <option value="202030" selected>Fall 2020</option>
                <option value="202110">Winter 2021</option>
            </select>
            <script>
                term = $("#termSelector option:selected").val();

                $("#termSelector").change(function() {
                    term = $("#termSelector option:selected").val();
                });
            </script>
        </div>
        <div class="left-section">
            <h3 class="section-title">Course List</h3>

            <div class="dropZone" ondrop="dropL(event)" ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)"><img src="img/drop-here.png" style="max-height: 100%;max-width: 100%;" draggable="false"></div>

            <script>
                $(".dropZone").on("drop", function(event) {
                    var dataTitle = event.originalEvent.dataTransfer.getData('Text');
                    courseList.push(dataTitle);
                });
            </script>
            <!--
            <div class="courseTag noDrop" id="ense400" draggable="true" ondragstart="drag(event)">ENSE400</div>
            <div class="courseTag noDrop" id="ense496ac" draggable="true" ondragstart="drag(event)">ENSE496AC</div>
            <div class="courseTag noDrop" id="ense496ad" draggable="true" ondragstart="drag(event)">ENSE496AD</div>
            -->
        </div>
        <div class="middle-section" id="courseCard_list">
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
                <script>
                    $(".bottom-right").on("drop", function(event) {
                        var dataTitle = event.originalEvent.dataTransfer.getData('Text');
                        const index = courseList.indexOf(dataTitle);
                        if (index > -1) {
                            courseList.splice(index, 1);
                        }
                    });
                </script>
                <div class="courseTag noDrop" name="ENGG 401" draggable="true" ondragstart="drag(event)">ENGG 401</div>
                <div class="courseTag noDrop" name="ENSE 400" draggable="true" ondragstart="drag(event)">ENSE 400</div>
                <div class="courseTag noDrop" name="ENGG 100" draggable="true" ondragstart="drag(event)">ENGG 100</div>
                <div class="courseTag noDrop" name="CS 110" draggable="true" ondragstart="drag(event)">CS 110</div>
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
        </p>
        <p class="info-link"><a href="homePage.php">About Us</a></p>
        <p class="info-link"><a href="View/api_test.html">API Test</a></p>
        <div id="test">CLICK</div>
        <script>
            $("#test").click(function() {
                var myObj = {
                    Term: term,
                    Course_List: courseList
                };
                console.log(myObj);
            });
        </script>
    </footer>
</body>

</html>