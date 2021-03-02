<?php
session_start();// Initialize the session

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
    <script type="text/javascript" src="js/academicMain.js"></script>
    <script type="text/javascript" src="js/genChart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script>
        var sid = "<?php echo $_SESSION["sid"]; ?>";
        var pas = "<?php echo $_SESSION["password"]; ?>";
    </script>
</head>
<style>

</style>

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
        <div class="session-required menu-list nav-active dropdown">
            <button class="dropbtn">Academic Schedule Builder</button>
            <div class="dropdown-content">
                <a class="academicList" href="academicBuilder_Main.php">General Student Status</a>
                <a class="academicList" href="academicBuilder_Default.php">Default Schedule</a>
                <a class="academicList" href="academicBuilder_Builder.php">Customized Schedule</a>
            </div>
        </div>
        <a class="session-required menu-list" href="semesterBuilder.php">Semester Schedule Builder</a>
        <a class="menu-list" href="courseDB.php">Course List Database</a>
        <div class="nav-right">
            <a id="usertext" onclick="addonSwitchFunc()"><?php echo htmlspecialchars($_SESSION["name"]); ?></a>
            <div id="addon-menu">
                <a><?php echo htmlspecialchars($_SESSION["sid"]); ?></a>
                <a href="Model/logout.php">Logout</a>
            </div>
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
                        <h3>Credit Earned:</h3>
                        <!-- <p class="">120/136</p> -->
                    </div>
                    <div class="card" id="card2">
                        <h3>Program:</h3>
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
            <h3 class="center textCenter"><label for="lineChart"> Average in semesters </label></h1>
            <div id="lineChart"></div>
        </div>
        
        <div id="pieGraph">
        <h2 class="center textCenter"><label for="pieChart">Score Distribution</label></h1>
            <div id="pieChart"></div>
        </div>
    </div>

    <footer>
        <script src="js/main.js"></script>

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