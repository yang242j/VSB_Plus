<?php
session_start(); // Initialize the session
?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>VSB_Plus : CourseDB</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="team_vsbp">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="css/courseDB.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".nav-right-2").hide();
        });
    </script>
</head>

<body>

    <?php
    // Check if the user is logged in, if not then hide nav-right div
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    ?>
        <script>
            $(document).ready(function() {
                $(".nav-right").hide();
                $(".nav-right-2").show();
                $(".session-required").hide();
            });
        </script>
    <?php } ?>

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
        <a class="session-required menu-list" href="academicBuilder_main.html">Academic Schedule Builder</a>
        <a class="session-required menu-list" href="semesterBuilder.php">Semester Schedule Builder</a>
        <a class="menu-list nav-active" href="courseDB.php">Course List Database</a>
        <div class="nav-right">
            <a id="usertext" onclick="addonSwitchFunc()"><?php echo htmlspecialchars($_SESSION["name"]); ?></a>
            <div id="addon-menu">
                <a><?php echo htmlspecialchars($_SESSION["sid"]); ?></a>
                <a href="Model/logout.php">Logout</a>
            </div>
        </div>
        <div class="nav-right-2">
            <a href="login.php">LogIn</a>
            <a href="signup.php">SignUp</a>
        </div>
    </nav>

    <section class="container">
        <form onclick="return false" method="POST">
            <table class="" id="course_search">
                <tr>
                    <td class="">Select Course:
                        <input type="text" id="course_input" value="">
                        <input type="submit" value="Select" onclick="courseSearch()" />
                    </td>
                    <td id="message"></td>
                </tr>
            </table>
            <!-- <input type="submit" value="Submit" onclick="setFilter(event)" />
            <p id="filter_cond"></p> -->
        </form>
        <br>
        </div>
        <div id="main_area">
            <div class="" id="search_area">
                <div class="shadow" id="classification">
                    <div class="border" id="faculty_title">Faculty</div>
                    <!-- <div class="tag round selected">ALL</div> -->
                    <div class="tag round">ENSE</div>
                    <div class="tag round">ENEL</div>
                    <div class="tag round">ENEV</div>
                    <div class="tag round">ENPE</div>
                    <div class="tag round">ENIN</div>
                    <div class="tag round">ENGG</div>
                    <div class="tag round">CS</div>
                    <div class="tag round">BUS</div>
                    <div class="tag round">CHEM</div>
                </div>
                <div class="shadow scroll course_list" id="course_list">
                    <div class="course shadow round word_overflow" style="background-color: #99CCCC;" value="ENSE 400" onclick="courseSelect(this)">
                        <span class="larger">ENSE 400</span>
                        <div class="left credit"> 3.00 Credit</div>
                        <br> <span class="bold">Systems Engineering Design Project</span>
                        <div class="description">
                            <span class="bold smaller">Description: </span>
                            <span class="smaller">Students are given the opportunity to propose, develop and present
                                engineering design projects which they are expected to further pursue in ENSE 477.
                                Issues of safety, feasibility, and engineering responsibility are discussed. Student
                                form design teams in this class and are expected to write a project plan document,
                                compose a preliminary design document, and present their project to their fellow
                                students.</span>
                        </div>
                    </div>
                    <!-- <div class="course shadow round" id="c2" style="background-color: #CCFF99;">ENEL 387</div>
                    <div class="course shadow round" id="c3" style="background-color: #99CCFF;">ENSE 496AC</div>
                    <div class="course shadow round" id="c4" style="background-color: #CCFFFF;">ENSE 496AD</div>
                    <div class="course shadow round" id="c5" style="background-color: #e4e2e2bd;">ENSE 472</div> -->
                </div>
                <div></div>
                <div>
                    <img class="inline" src="img/filter.jpeg" alt="filter_img" align="top" height="20" width="20">
                    <select class="inline" name="Filter sort" id="filter">
                        <option value="all">ALL</option>
                        <option value="first">First year class</option>
                        <option value="second">Second year class</option>
                        <option value="thrid">Thrid year class</option>
                        <option value="fourth">Fourth year class</option>
                    </select>
                    <div class="inline" id="display_change">
                        <img src="img/list.jpeg" alt="list change button" align="top" height="20" width="20">
                    </div>
                    <!-- <img id="display_change" src="img/list.jpeg" alt="list change button" align="top" height="20" width="20"> -->
                </div>
            </div>
            <!-- <div class="course" id="c1" style="background-color: aqua;" onclick="butonClick()">ENSE 400</div>
            <div class="course" id="c2" style="background-color: bisque;">ENEL 387</div>
            <div class="course" id="c3" style="background-color: coral;">ENSE 496AC</div>
            <div class="course" id="c4" style="background-color: cornflowerblue;">ENSE 496AD</div>
            <div class="course" id="c5" style="background-color: darkkhaki;">ENSE 472</div> -->
            <div class="shadow" id="popView">
                <h2 id='title'>ENSE 400</h2>
                <ul>
                    <li><span class="bold">Course Name</span>: <span id='fullName'>ENSE Project Start-up</span> </li>
                    <li>***<span class="bold">Prerequisites</span>: <span id='preReqClass'>ENSE 470 and successful completion of 99 credit hours</span> ***</li>
                    <li><span class="bold">Course Description</span>: Students are given the opportunity to propose, 
                    develop and present engineering design projects which they are expected to further pursue in ENSE 477. 
                    Issues of safety, feasibility, and engineering responsibility are discussed. Student form design teams in 
                    this class and are expected to write a project plan document, compose a preliminary design document, and 
                    present their project to their fellow students.</li>
                </ul>
                <div class='graph_size' id="graph"></div>
            </div>
        </div>


        <!-- <p>Example for visualizing course prerequisites:</p>
        <div class="course" id="c10" style="background-color: bisque;">ENSE 387</div>
        <br><br>
        <div>
            <span class="course preReq" id="c11" style="background-color: rgb(245, 116, 41);">ENSE 352</span>
            <span class="course preReq" id="c12" style="background-color: rgb(245, 116, 41);">ENEL 384</span>
        </div> -->

        <!-- For line required js file -->
        <!-- <script src="https://cdn.bootcss.com/jsPlumb/2.6.8/js/jsplumb.min.js"></script> -->
        <!-- For the popView to input the js file -->
        <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> -->
        <!-- For the graph to input he js file -->
        <script src="https://cdn.bootcdn.net/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
        
    </section>

    <footer style="padding-bottom: 0%;">
        <script src="js/main.js"></script>
        <script src="js/courseDB.js"></script>
        <script src="js/genChart.js"></script>

        <!-- Change the default selected course by pass the data(courseId) in url -->
        <?php 
            if (isset($_REQUEST["courseId"]) and $_REQUEST["courseId"] != '') {
                $short_name = $_REQUEST["courseId"];
                echo "<script> var defaultShow = false;
                selected('" . $short_name . "'); </script>";
            }
        ?>
        <!-- <script src="js/genChart.js"></script> -->

        <p class="copyright">Copyright &copy; Sep. 2020 to
            <script>
                document.write(new Date().getFullYear())
            </script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
            <cite>
                Credit:
            </cite>
        </p>
        <p class="info-link"><a href="homePage.php">About Us</a></p>
    </footer>
</body>

</html>