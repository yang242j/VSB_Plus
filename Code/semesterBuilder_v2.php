<?php
/**
 * Simulate an interactive course registration.
 *
 * Requirments:
 *  1) User should be able to drag and drop desired courses to register.
 *  2) User should also be able to drag and drop unwanted courses to remove.
 *  3) User should be able to review the history of all completed courses.
 *  4) A list of recommended courses should be presented to the user.
 *  5) After a successful (drag-n-drop) registration, a course-card with course general info apear automatically.
 *  6) After a successful (drag-n-drop) registration, the calendar should be filled with corresponding section info.
 *  7) After a successful (drag-n-drop) registration, the final exam list should be append automatically.
 *
 * Recommended course requirements see http://15.223.123.122/vsbp/Code/Model/courseREC.php
 *
 * php Steps:
 *  1) Collect session variables. If not logged-in, redirect to login page.
 *
 * @version     2.0
 * @link        http://15.223.123.122/vsbp/Code/semesterBuilder.php
 * @author      Jingkang Yang (sid: 200362586) <yang242j@uregina.ca>
 * @param {boolean} $_SESSION["loggedin"]   Status of logged-in or not: true/false
 * @param {integer} $_SESSION["sid"]        Student id
 * @param {string}  $_SESSION["name"]       Student name
 * @param {string}  $_SESSION['major']      Student major
 */

// Initialize the session
session_start();

// Check if user is inactive for a time period
if (isset($_SESSION["lastActTime"])) {
    $inactive = 600; // 1 min in seconds
    $session_life = time() - $_SESSION["lastActTime"];
    if($session_life > $inactive) {
        header("location: Model/logout.php");
        exit();
    }
    $_SESSION["lastActTime"] = time();
    // echo $_SESSION["lastActTime"];
}

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
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
        var isMobile = window.matchMedia('(max-width: 1080px)').matches;
        let presetCourses = {
            'Precalculus 30':100, 
            'Calculus 30':100, 
            'CHEM 30':100, 
            'Mathematics B30':100, 
            'Mathematics C30':100, 
            'AMTH 092':100, 
            'MATH 102':100, 
            'MATH 103':100,
        };
        var courseCompletedList = [].concat(Object.keys(presetCourses));
        var courseCompletedObj = Object.assign({}, presetCourses);
        
        $(document).ready(function() {
            $("button.plus_button.open").hide();
            if (isMobile) $(".menu-icon").click();
        });
    </script>
</head>

<body>

    <header>
        <a href="http://15.223.123.122/vsbp/Code/academicBuilder_Main.php"><img src="img/logo.png" class="logo" alt="UofR"></a>
        <h1>Visual Schedule Builder Plus</h1>
    </header>

    <nav>
        <div class="nav-right">
            <a class="nav-active" id="usertext" onclick="toogleDisplay('addon-menu')"><?php echo htmlspecialchars(
                $_SESSION["name"]
            ); ?></a>
            <div class="hidden" id="addon-menu">
                <a><?php echo htmlspecialchars($_SESSION["sid"]); ?></a>
                <a href="Model/logout.php">Logout</a>
            </div>
        </div>
        <div class="menu-icon" onclick="menuFunc1(this); menuFunc2('menu-list');">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <div class="menu-list">
            <div class="session-required dropdown">
                <button class="dropbtn" onclick="toogleDisplay('dropdown-content')">Academic Schedule Builder &#9661;</button>
                <div id="dropdown-content" class="dropdown-content hidden">
                    <a class="academicList" href="academicBuilder_Main.php">General Student Status</a>
                    <a class="academicList" href="academicBuilder_Default.php">Default Schedule</a>
                    <a class="academicList" href="academicBuilder_Builder.php">Customized Schedule</a>
                </div>
            </div>
            <a class="nav-active" href="semesterBuilder_v2.php">Semester Schedule Builder</a>
            <a class="" href="courseDB.php">Course List Database</a>
        </div>
    </nav>

    <div class="container">
        <!-- Top Section -->
        <section id="top">
            <div style="width: 50%; float: left;">
                <label for="term"><b>Step 1:</b> Choose Semester</label>
                <select id="termSelector" onfocus="hideBottom()" onblur="showBottom()">
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

            <div style="width: 50%; float: right;">
                <form autocomplete="off" onsubmit="return ajaxpost()">
                    <label><b>Step 2:</b> Search Class</label>
                    <div class="autocomplete">
                        <input type="text" id="search_courseid" placeholder="ENGL 100"  style="width:70px; min-width: 70px;" onkeydown="this.style.width = ((this.value.length + 1) * 8) + 'px';" required />
                    </div>
                    <input type="submit" value="Submit"/>
                </form>
                <p id="searchMsg"></p>
                <script>
                    /*Collect course objects from ALL.json*/
                    $.getJSON("JSON/ALL.json", function(jsonObjArray) {
                        console.log(jsonObjArray);
                        /*Excuting the autocomplete function with input values*/
                        autocomplete(document.getElementById("search_courseid"), jsonObjArray);
                    });

                    function ajaxpost() {
                        // (A) GET FORM DATA
                        var courseid = document.getElementById("search_courseid").value.toUpperCase();
                        var data = new FormData();
                        data.append("courseid", courseid);
                        data.append("term", term);
                        data.append("totalCredit", "<?php echo htmlspecialchars($_SESSION['totalCredit']); ?>");
                        data.append("doneList", JSON.stringify(courseCompletedObj));
                        
                        // (B) AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "http://15.223.123.122/vsbp/Code/Model/courseRegStatus_v2.php");
                        // When server responds
                        xhr.onload = function(){ 
                            let rsp = JSON.parse(this.response);
                            //console.log(rsp);

                            if (rsp.Status == true) {
                                courseid = rsp.CourseID;
    
                                // Try to remove any existing course tags with same id.
                                if($("#" + courseid).length != 0) {
                                    $( "#" + courseid ).remove();
                                }
                               
                                // Appendd new course tag
                                registerCourse(courseid, term);
                                
                                // If this course Name is NOT in the courseList, push
                                if ($.inArray(courseid, courseList) === -1) {
                                    courseList.push(courseid);
                                } else {
                                    console.log(courseid + " already exist in courseList { " + courseList + " }");
                                }

                                // Print search messages
                                $("#searchMsg").html(courseid + ' registration success.');
                                $("#searchMsg").css('color', 'green');

                            } else {
                                // Do nothing and alert the returned Notes
                                alert(rsp.Notes);

                                // Print search messages
                                $("#searchMsg").html(courseid + ' registration failed.');
                                $("#searchMsg").css('color', 'red');
                            }
                        };
                        xhr.send(data);
                        
                        // (C) PREVENT HTML FORM SUBMIT
                        return false;
                    }
                </script>
            </div>
        </section>

        <!-- Left Section -->
        <section id="left">
            <h3 class="section-title">Course List</h3>
            <div id="courseList_Containor"></div>
            <!--
            // Test tags
            <div class="courseTag noDrop" id="ense400" draggable="true" ondragstart="drag(event)">ENSE400</div>
            <div class="courseTag noDrop" id="ense496ac" draggable="true" ondragstart="drag(event)">ENSE496AC</div>
            <div class="courseTag noDrop" id="ense496ad" draggable="true" ondragstart="drag(event)">ENSE496AD</div>
            -->
        </section>

        <!-- Middle Section -->
        <section id="middle">
            <h3 class="section-title">Course Detail Info</h3>
            <div id="courseCard_Containor">
                <div class="courseInfo" id="exampleCard">
                    <h2>Course Tag</h2>
                    <h4>Course Title</h4>
                    <p>Course Detail Info: **** **** *** ** * * * **</p>
                </div>
            </div>
            <script>
                var selected;
                $(document).on('focus', 'select#sectionSelector', function(){
                    //console.log("Saving value " + $(this).val());
                    selected = $(this).val();
                }).on('change', 'select#sectionSelector', function() {
                    let oldCombo = selected;
                    let newCombo = $(this).val();
                    let cardId = $(this).closest("div").attr("id");
                    let cardStyle = $(this).closest("div").attr("style");
                    //console.log(oldCombo, newCombo, cardId, cardStyle, term);
                    if (oldCombo != newCombo)
                        changeCalendarAndExam(oldCombo, newCombo, cardId, cardStyle, term);
                    selected = newCombo
                });

                $(document).on('click', 'button.close.courseCard', function() {
                    let short_name = $(this).closest('div').attr('id').split('_Card')[0];
                    // Remove course 
                    removeCourse(short_name);
                    console.log(short_name + ' Unselected');

                    // on drop, remove course Name from courseList
                    const index = courseList.indexOf(short_name);
                    if (index > -1) {
                        courseList.splice(index, 1);
                    }
                    appendExampleCard();
                });
            </script>
        </section>
        
        <!-- Right Section -->
        <section id="right">
            <h3 class="section-title">Weekly Schedule & Exam Date</h3>
            <div class="Calendar">
                <div id='calendar'></div>
            </div>
            <div class="Date">
                <p>Final Exam Date:</p>
                <ul id="examDate_ul"></ul>
            </div>
        </section>

        <!-- Bottom Section -->
        <section id="bottom" ondrop="dragEnd()" ondragover="allowDrop(event)">
                
            <!-- Bottom Left Division -->
            <div class="bottom_left" id="course_completed">
                <!-- Close Button -->
                <button class="plus_button close" onclick="hideParent(this);"></button>
                Courses Completed: <b>(Not Draggable)</b><br>
                <script>
                    $(document).ready( function() {
                        <?php
                        // Include the vsbp_db_config.php file
                        require_once "Model/vsbp_db_config.php";
                        $tableName = "S" . $_SESSION['sid'];
                        $takenClass_sql =
                            "SELECT `course_ID`, `final_grade` FROM `" .
                            $tableName .
                            "` WHERE `credit_earned`=`credit_hour`";
                        $result = mysqli_query($conn, $takenClass_sql);
                        if (!$result) {
                            printf("Error: %s\n", mysqli_error($conn));
                            exit();
                        }
                        while ($row = mysqli_fetch_array($result)) { ?>
                            var course_tag = tagGenerator("<?php echo htmlspecialchars($row['course_ID']); ?>", false);
                            document.getElementById("course_completed").innerHTML += course_tag;
                            // List
                            courseCompletedList.push("<?php echo htmlspecialchars($row['course_ID']); ?>");
                            // Object
                            courseCompletedObj["<?php echo htmlspecialchars($row['course_ID']); ?>"] = <?php echo htmlspecialchars($row['final_grade']); ?>;
                        <?php }
                        ?>
                    });
                </script>
            </div>

            <!-- Bottom Right Division -->
            <div class="bottom_right" id="course_recommended">
                <!-- Close Button -->
                <button class="plus_button close" onclick="hideParent(this);"></button>
                Courses Recommended: <b>(Drag to Register)</b><br>
                <script>

                    function loadRecCourseTags() {
                        // Remove all previously displayed tags
                        $(".bottom_right .courseTag").remove();
                        $("section#left .courseTag").remove();
                        $("section#middle .courseCard").remove();
                        
                        // Remove all previously displayed calendar events and exams
                        $.each(courseList, function(key, course) {
                            calendar.removeAllEvents();
                            removeExamList(course);
                        });
                        
                        // Empty the courseList
                        courseList = [];
                        
                        // Append example course card.
                        appendExampleCard();
                        
                        // Get the JSON file generated by courseREC.php
                        fetchRecJSON_v2(courseCompletedObj, totalCredit="<?php echo htmlspecialchars($_SESSION['totalCredit']); ?>", major="<?php echo htmlspecialchars($_SESSION['major']); ?>", term, maxNum=10).done(function (result) {
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

                    $(".bottom_right").ready( function() {
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
        </section>

        <!-- Open Button Spanner -->
        <button class="plus_button open" onclick="showBottom();"></button>

        <!-- Shadow Layer Division -->
        <div id="shadowLayer" ondrop="dragEnd()" ondragover="allowDrop(event)">
            <button class="plus_button close" onclick="hideParent(this);"></button>
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
                    appendExampleCard();
                    });
            </script>
        </div>
    </div>

    <footer>
        <script src="js/main.js"></script>
        <script src="js/semester.js"></script>
        <script src="js/autocomplete.js"></script>
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
        <p class="info-link">
            <a href="homePage.php">About Us</a>
            <!-- <a href="View/api_test.html">API Test</a>
            <a class="" id="test">Test CLICK</a> -->
        </p>
        <script>
            $("#test").click(function() {
                var myObj = {
                    Term: term,
                    Course_List: courseList,
                    Course_Completed: courseCompletedList,
                    Course_Completed_Obj: courseCompletedObj,
                };
                console.log(myObj);
            });
        </script>
    </footer>
</body>

</html>