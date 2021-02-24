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
        var courseCompletedList = [];
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
                term = $("select#termSelector option:selected").val();

                $(document).on('change', 'select#termSelector', function() {
                    term = $("select#termSelector option:selected").val();
                    loadRecCourseTags();
                });
            </script>
        </div>
        <div class="left-section">
            <h3 class="section-title">Course List</h3>
            <div id="courseList_Containor"></div>
            <!--
            // Test tags
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
        <script>
            $(document).on('focusin', 'select#sectionSelector', function(){
                //console.log("Saving value " + $(this).val());
                $(this).data('val', $(this).val());
            }).on('change', 'select#sectionSelector', function() {
                let oldCombo = $(this).data('val');
                let newCombo = $("select#sectionSelector option:selected").val();
                let cardId = $(this).closest("div").attr("id");
                let cardStyle = $(this).closest("div").attr("style");
                changeCalendarAndExam(oldCombo, newCombo, cardId, cardStyle, term);
            });
        </script>
        <div class="right-section">
            <h3 class="section-title">Weekly Schedule & Exam Date</h3>
            <div class="Calendar">
                <div id='calendar'></div>
            </div>
            <div class="Date">
                <p>Final Exam Date:</p>
                <ul id="examDate_ul"></ul>
            </div>
        </div>
        <div class="stick-bottom" ondrop="dragEnd()" ondragover="allowDrop(event)">
            <div class="bottom-left" id="course_completed">
                Courses Completed: <br>
                <script>
                    $(document).ready( function() {
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
                            courseCompletedList.push("<?php echo htmlspecialchars($row['course_ID']); ?>");
                        <?php
                        };
                        ?>
                    });
                </script>

                <!--
                // Test tags
                <div class="courseTag noDrag" id="CS 405" draggable="false">CS 405</div>
                <div class="courseTag noDrag" id="ENEL 380" draggable="false">ENEL 380</div>
                <div class="courseTag noDrag" id="ENGG 401" draggable="false">ENGG 401</div>
                <div class="courseTag noDrag" id="ENEL 417" draggable="false">ENEL 417</div>
                -->
            </div>
            <div id="course_recommended" class="bottom-right">
                Courses To Take: <br>
                <script>

                    function appendExampleDiv() {
                        // if classList is empty, add example div
                        if (courseList.length == 0 && $("#exampleDiv").length == 0) {
                            $("#courseCardList").append("<div class='courseInfo' id='exampleDiv'> <h2> Course Tag </h2> <h4> Course Title </h4> <p> Course Detail Info: **** ** ** ** * ** * * * ** </p> </div>");
                        }
                    }

                    function loadRecCourseTags() {
                        // Remove all previously displayed tags
                        $(".bottom-right .courseTag").remove();
                        $(".left-section .courseTag").remove();
                        $(".middle-section .courseCard").remove();
                        // Remove all previously displayed calendar events and exams
                        $.each(courseList, function(key, course) {
                            calendar.removeAllEvents();
                            removeExamList(course);
                        });
                        // Empty the courseList
                        courseList = [];
                        // Append example course card.
                        appendExampleDiv();
                        // Get the JSON file generated by courseREC.php
                        fetchRecJSON(courseCompletedList, major="<?php echo htmlspecialchars($_SESSION['major']); ?>", term, maxNum=10).done(function (result) {
                            var REC_json_obj = JSON.parse(result);
                            // For each recommended courses, generate and append the tag
                            $.each (REC_json_obj, function (recKey, recValue) {
                                // generate dragable course tag,
                                var course_tag = tagGenerator(recValue, true);
                                // append to the div with id "#course_recommended"
                                document.getElementById("course_recommended").innerHTML += course_tag;
                            }); 
                        }).fail(function () {
                            console.error("Course Recommendation JSON Fetch FAILED");
                        });
                    }

                    $(".bottom-right").ready( function() {
                        loadRecCourseTags();
                    });
                </script>

                <!--
                // Test tags
                <div class="courseTag noDrop" id="CS 405" draggable="true" ondragstart="drag(event)">CS 405</div>
                <div class="courseTag noDrop" id="ENEL 380" draggable="true" ondragstart="drag(event)">ENEL 380</div>
                <div class="courseTag noDrop" id="ENGG 401" draggable="true" ondragstart="drag(event)">ENGG 401</div>
                <div class="courseTag noDrop" id="ENEL 417" draggable="true" ondragstart="drag(event)">ENEL 417</div>
                -->
            </div>
        </div>
        <div id="shadowLayer" ondrop="dragEnd()" ondragover="allowDrop(event)">
            <div class="dropZone L" ondrop="dropL(event, term); dragEnd();" ondragover="allowDrop(event)"></div>
            <div class="dropZone BR" ondrop="dropBR(event); dragEnd();" ondragover="allowDrop(event)"></div>
            <script>
                $(".dropZone.L").on("drop", function(event) {
                    var courseName = event.originalEvent.dataTransfer.getData('Text');
                    console.log(courseName + ' Selected');

                    // If this course Name is NOT in the courseList, push
                    if ($.inArray(courseName, courseList) === -1) {
                        courseList.push(courseName);
                    } else {
                        console.log(courseName + " already exist in courseList { " + courseList + " }");
                    }
                });

                $(".dropZone.BR").on("drop", function(event) {
                    var courseName = event.originalEvent.dataTransfer.getData('Text');
                    console.log(courseName + ' Unselected');

                    // on drop, remove course Name from courseList
                    const index = courseList.indexOf(courseName);
                    if (index > -1) {
                        courseList.splice(index, 1);
                    }
                    appendExampleDiv();
                    });
            </script>
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
                    Course_List: courseList,
                    Course_Completed: courseCompletedList,
                };
                console.log(myObj);
            });
        </script>
    </footer>
</body>

</html>