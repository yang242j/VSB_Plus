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
        <div class="menu-icon" onclick="menuFunc1(this); menuFunc2('menu-list'); menuFunc3();">
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
                    var courseName = event.originalEvent.dataTransfer.getData('Text');
                    console.log(courseName + ' Selected');

                    // If this course Name is NOT in the courseList, push
                    if ($.inArray(courseName, courseList) === -1) {
                        courseList.push(courseName);
                    } else {
                        console.log(courseName + " already exist in courseList { " + courseList + " }");
                    }

                });
            </script>
            <!--
            <div class="courseTag noDrop" id="ense400" draggable="true" ondragstart="drag(event)">ENSE400</div>
            <div class="courseTag noDrop" id="ense496ac" draggable="true" ondragstart="drag(event)">ENSE496AC</div>
            <div class="courseTag noDrop" id="ense496ad" draggable="true" ondragstart="drag(event)">ENSE496AD</div>
            -->
        </div>
        <div class="middle-section" id="courseCardList">
            <h3 class="section-title">Course Detail Info</h3>
            <div class="courseInfo" id="exampleDiv">
                <h2>Course Tag</h2>
                <h4>Course Title</h4>
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
            <div class="bottom-left" id="course_completed">
                Courses Completed: <br>
                <script>
                    $(function() {
                        <?php
                        // Include the vsbp_db_config.php file
                        require_once "Model/vsbp_db_config.php";
                        $tableName = "S" . $_SESSION['sid'];
                        $takenClass_sql = "SELECT `course_ID` FROM `" . $tableName . "` WHERE `credit_earned`=`credit_hour`";
                        $result = mysqli_query($conn, $takenClass_sql);
                        if (!$result) {
                            printf("Error: %s\n", mysqli_error($conn));
                            exit();
                        }
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            var course_tag = tagGenerator("<?php echo htmlspecialchars($row['course_ID']); ?>", false);
                            document.getElementById("course_completed").innerHTML += course_tag;
                        <?php
                        };
                        ?>
                    });
                </script>
            </div>
            <div class="bottom-right" ondrop="dropBR(event)" ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)">
                Courses To Take: <br>
                <script>
                    $(".bottom-right").on("drop", function(event) {
                        var courseName = event.originalEvent.dataTransfer.getData('Text');
                        console.log(courseName + ' Unselected');

                        // on drop, remove course Name from courseList
                        const index = courseList.indexOf(courseName);
                        if (index > -1) {
                            courseList.splice(index, 1);
                        }

                        // if classList is empty, add example div
                        if (courseList.length == 0 && $("#exampleDiv").length == 0) {
                            $("#courseCardList").append("<div class='courseInfo' id='exampleDiv'> <h2> Course Tag </h2> <h4> Course Title </h4> <p> Course Detail Info: **** ** ** ** * ** * * * ** </p> </div>");
                        }
                    });
                </script>
                <div class="courseTag noDrop" id="ENGG 401" draggable="true" ondragstart="drag(event)">ENGG 401</div>
                <div class="courseTag noDrop" id="ENSE 477" draggable="true" ondragstart="drag(event)">ENSE 477</div>
                <div class="courseTag noDrop" id="ENSE 496AC" draggable="true" ondragstart="drag(event)">ENSE 496AC</div>
                <div class="courseTag noDrop" id="ENSE 496AD" draggable="true" ondragstart="drag(event)">ENSE 496AD</div>
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
        <p class="info-link"><a href="homePage.php">About Us</a><a href="View/api_test.html">API Test</a></p>
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