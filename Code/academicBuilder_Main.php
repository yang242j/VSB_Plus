<?php
/**
 * The academic main page displayes the logged user general student info.
 *
 * Requirments:
 *  1) There should be a summary board on left of the screen.
 *  2) Summary board should include student id, major, program process, gpa and average in percentage.
 *  3) May also include credit hours, program, major, minor, and maybe concentration.
 *  4) Should also include a histogram of each semester average grade for the performance monitoring.
 *  5) On the right of the screen, an animated pie chart also do the performance monitoring.
 *
 * php Steps:
 *  1) Start session.
 *  2) If not logged in, redirect to login page.
 *
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/academicBuilder_Main.php
 * @author      Xinyu Liu (sid: 200362878) <liu725@uregina.ca>
 * @param       {boolean}       $_SESSION["loggedin"]       Status of logged-in or not: true/false
 * @param       {integer}       $_SESSION["sid"]            Student id
 * @param       {string}        $_SESSION["name"]           Student name
 * @param       {string}        $_SESSION["major"]          Student major
 * @param       {string}        $_SESSION["password"]       Student password
 */

session_start(); // Initialize the session

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
    <!-- icon library -->
    <script src='https://kit.fontawesome.com/b95f8ace21.js'></script>
    <!-- icon library -->

    <title>VSB_Plus : Academic</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="team_vsbp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/academicBuilder_main.css">

    <script type="text/javascript" src="js/academicBuilder.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/genChart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://cdn.bootcdn.net/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha256-t9UJPrESBeG2ojKTIcFLPGF7nHi2vEc7f5A2KpH/UBU=" crossorigin="anonymous"></script>
    <script>
        var sid = "<?php echo $_SESSION["sid"]; ?>";
        var pas = "<?php echo $_SESSION["password"]; ?>";
        var major = "<?php echo $_SESSION["major"]; ?>";
        var isMobile = window.matchMedia('(max-width: 1080px)').matches;
        $(document).ready(function() {
            if (isMobile) $(".menu-icon").click();
        });
    </script>
    <script type="text/javascript" src="js/academicMain.js"></script>
</head>
<style>

</style>

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
            <div class="session-required nav-active dropdown">
                <button class="dropbtn" onclick="toogleDisplay('dropdown-content')">Academic Schedule Builder &#9661;</button>
                <div id="dropdown-content" class="dropdown-content hidden">
                    <a class="academicList" href="academicBuilder_Main.php">General Student Status</a>
                    <a class="academicList" href="academicBuilder_Default.php">Default Schedule</a>
                    <a class="academicList" href="academicBuilder_Builder.php">Customized Schedule</a>
                </div>
            </div>
            <a class="session-required" href="semesterBuilder_v2.php">Semester Schedule Builder</a>
            <a class="" href="courseDB.php">Course List Database</a>
        </div>
    </nav>

    <div class="welcome_tag" id="welcome">
        <h2>Welcome <?php echo htmlspecialchars($_SESSION["name"]); ?></h2>
    </div>
    <div id="main_area" class="round">
        <div id="summaryBoard" class="">
            <h2 class="center textCenter"><label for="summary">Summary Board</label></h2>
            <div class="static">
                <button class="left arrow" onclick="pageDown()"><i class='fas fa-angle-left'></i></button>
                <div id="summary" class="center inline">
                    <div class="card textCenter" id="card1">
                        <h3>SID:</h3>
                        <!-- <p class="">120/136</p> -->
                    </div>
                    <div class="card" id="card2">
                        <h3>Major:</h3>
                        <!-- <p>Applied Science</p> -->
                    </div> 
                    <div class="card" id="card3">
                        <h3>Course Left:</h3>
                        <!-- <p>6</p> -->
                    </div>
                    <div class="card" id="card4">
                        <h3>GPA:</h3>
                        <!-- <p>3.6</p> -->
                    </div>
                </div>
                <button class="right arrow" onclick="pageUp()"><i class='fas fa-angle-right'></i></button>
            </div>
            <h3 class="center textCenter"><label for="lineChart"> Term Average </label></h1>
            <div id="lineChart"></div>
        </div>
    
        <div id="pieGraph">
            <h2 class="center textCenter"><label for="pieChart">Score Distribution</label></h1>
            <div class="center textCenter">
                <h5 id="gradeSys"><u><i>More details in Grade System</i></u></h5>
                <img class="" id="GradeSysPic" src="img/gradingSys.png" width="49%" alt="Undergraduate Garding System">
            </div>
            <!-- <h5 id="gradeSys">More details in <span>Grade System</span></h5>
            <img id="GradeSysPic" src="img/logo.png" alt="Undergraduate Garding System"> -->
            <div id="pieChart"></div>
        </div>
    </div>

    <style>
        #GradeSysPic{
            display:none; 
            position: absolute; 
            opacity: 0.9;
        }

        #gradeSys:hover +#GradeSysPic{
            display: block;
        }
    </style>

    <footer>
        <script src="js/main.js"></script>

        <p class="copyright">Copyright &copy; Sep. 2020 to
            <script>
                document.write(new Date().getFullYear())
            </script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
            <cite>
                Credit: Graph generator source code from chartjs.org version 2.9.4<br>
            </cite>
        </p>
        <p class="info-link"><a href="homePage.php">About Us</a></p>
    </footer>
</body>