<?php
session_start();
 // Initialize the session
?>
<!do
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
    <script type="text/javascript" src="js/academicMain.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".nav-right-2").hide();
        });
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
        <a class="session-required menu-list" href="academicBuilder_Main.php">Academic Schedule Builder</a>
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

    <div class="welcome_tag" id = "welcome">
        <h1>Welcome UserName</h1>
    </div>
    <section class="user_summary_board">
        <button class="right_arrow" onclick="pageUp()"><i class='fas fa-angle-right'></i></button>
        <button class="left_arrow" onclick="pageDown()"><i class='fas fa-angle-left'></i></button>
        <div class="summary_card" id="card1">
            <h3>Credit Earned:</h3>
            <p>120/136</p>
            <p></p>
        </div>
        <div class="summary_card" id="card2">
            <h3>Year:</h3>
            <p>3rd</p>
            <p></p>
        </div>
        <div class="summary_card" id="card3">
            <h3>Course Left:</h3>
            <p>6</p>
            <p></p>
        </div>
        <div class="summary_card" id="card4">
            <h3>GPA:</h3>
            <p>3.6</p>
            <p></p>
        </div>
    </section>



    <section class="summary_pie_graph">
        <div class="graph_introduction">
            <h2>Summary Pie Chart Intro</h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Harum ducimus, doloremque nulla eius reiciendis veritatis, enim accusantium voluptatem velit consequuntur neque autem, ullam deleniti itaque. Error repellat quam fugit dolor.</p>
        </div>

        <div class="graph">
            <h2>Summary Pie Chart</h2>
            <img class="photo" id="pie_chart" src="img/basic-pie-chart.png"></img>

        </div>
    </section>
    <section class="summary_line_graph">
        <div class="graph">
            <h2>Line Chart </h2>
            <img class="photo" id="line_chart" src="img/trend_chart_sample.svg"></img>
        </div>
        <div class="graph_introduction">
            <h2>Line Chart Intro</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur porro repudiandae ut voluptas culpa ab ipsam est numquam ea aperiam eligendi laboriosam similique, iusto beatae nesciunt amet exercitationem eius? Temporibus!</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis dolores, temporibus quaerat tempora, natus quam totam cupiditate magni omnis voluptatibus et provident. Ipsum autem laudantium blanditiis adipisci harum libero quidem?</p>
            <h3 id = "corner"><a href='academicBuilder_Default.php'>Go to Default Schedule</a></h3>
            <!-- <a class="menu-list" href="html/academicBuilderCDetail.html">Compeleted Course Detail Page</a>
            <a class="menu-list" href="html/academicBuilder.html">academicBuilder page</a>
            <a class="menu-list" href="html/academicBuilderTable.html">academicBuilder Table</a> -->
        </div>
    </section>
    <footer>
        <script src="js/main.js"></script>
        
        <p class="copyright">Copyright &copy; Sep. 2020 to
            <script>document.write(new Date().getFullYear())</script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
            <cite>
                Credit: 
            </cite>
        </p>
        <p class="info-link"><a href="homePage.php">About Us</a></p>
    </footer>
</body>