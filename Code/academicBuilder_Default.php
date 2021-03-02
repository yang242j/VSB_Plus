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
    <script src='https://kit.fontawesome.com/b95f8ace21.js' crossorigin='anonymous'></script>
    <!-- icon library -->

    <title>VSB_Plus : Academic</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="team_vsbp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/academicBuilder_Default.css">

    <script type="text/javascript" src="js/academicDefault.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    
<section class = "terms" id = "block" style="float:left;">
        <div class="welcome_tag" id = "welcome">
            <h1>Default Schedule</h1>
        </div>
    <div class = "term1" id = "term1">
        <div class = "tittle"><h2>Term1:</h2></div>
        <div class = "course_cards">
              <h3>ENSE 370</h3>
              <i class='fas fa-circle' id = "circle1" style='font-size:24px;'></i>  
              <i class='fas fa-circle' style='font-size:24px;color:red'></i>
              <i class='fas fa-circle' style='font-size:24px;color:red'></i>
              <i class='fas fa-circle' style='font-size:24px;color:red'></i> 
        </div>
        <div class = "course_cards">
            <h3>ENSE 370</h3>
            <i class='fas fa-circle' style='font-size:24px;color:red'></i>  
            <i class='fas fa-circle' style='font-size:24px;color:red'></i>
            <i class='fas fa-circle' style='font-size:24px;color:red'></i>
            <i class='fas fa-circle' style='font-size:24px;color:red'></i> 
      </div>
      <div class = "course_cards">
        <h3>ENSE 370</h3>
        <i class='fas fa-circle' style='font-size:24px;color:red'></i>  
        <i class='fas fa-circle' style='font-size:24px;color:red'></i>
        <i class='fas fa-circle' style='font-size:24px;color:red'></i>
        <i class='fas fa-circle' style='font-size:24px;color:red'></i> 
  </div>
  <div class = "course_cards">
    <h3>ENSE 370</h3>
    <i class='fas fa-circle' style='font-size:24px;color:red'></i>  
    <i class='fas fa-circle' style='font-size:24px;color:red'></i>
    <i class='fas fa-circle' style='font-size:24px;color:red'></i>
    <i class='fas fa-circle' style='font-size:24px;color:red'></i> 
</div>
<div class = "course_cards">
    <h3>ENSE 370</h3>
    <i class='fas fa-circle' style='font-size:24px;color:red'></i>  
    <i class='fas fa-circle' style='font-size:24px;color:red'></i>
    <i class='fas fa-circle' style='font-size:24px;color:red'></i>
    <i class='fas fa-circle' style='font-size:24px;color:red'></i> 
</div>
        <div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
            &nbsp;
            <button class="right_arrow"><i class='fas fa-angle-right'></i></button>
        </div>   
    </div>
    <div class = "term1" id ="term2">
        <div class = "tittle"><h2>Term2:</h2></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>

        <div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
            &nbsp;
            <button class="right_arrow"><i class='fas fa-angle-right'></i></button>  
    </div>
    </div>
    <div class = "term1" id ="term3">

        <div class = "tittle"><h2>Term3:</h2></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>

        <div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
            &nbsp;
            <button class="right_arrow"><i class='fas fa-angle-right'></i></button>
        </div>
    </div>

    <div class = "term1" id ="term4">
        <div class = "tittle"><h2>Term4:</h2></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>
        <div class = "course_cards"></div>

        <div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
            &nbsp;
            <button class="right_arrow"><i class='fas fa-angle-right'></i></button>
        </div>

    </div>
    <div class = "arrows"><button class="up_arrow" id = "term_up" onclick = "termUp()"><i class='fas fa-angle-double-up'></i></button>
        &nbsp;
        <button class="down_arrow" id = "term_down" onclick = "termDown()"><i class='fas fa-angle-double-down'></i></button>
</section>


<section class = "tags_courses" id ="block" style="float:right;">  

    <div class = "icons_annotation" id = "default_icon">
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:red'>Easy</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:yellow'>Medium</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:blue'>Hard</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:purple'>Low Average</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:plum'>Quizs</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:black'>Pass Final</i></div>
    </div>

    <div class= "course_list">

        <div class = "course_completed"><h3>Approved Course</h3></div>

        <div class = "course_tag_completed" id = "approvedCourse">
            <p id = "ct0">ENSE 271</p>
            <p id = "ct1">ENSE 271</p>
            <p id = "ct2">ENSE 271</p>
            <p id = "ct3">ENSE 271</p>

            <p id = "ct4">ENSE 271</p>
            <p id = "ct5">ENSE 271</p>
            <p id = "ct6">ENSE 271</p>
            <p id = "ct7">ENSE 271</p>
            
            <p id = "ct8">ENSE 271</p>
            <p id = "ct9">ENSE 271</p>
            <p id = "ct10">ENSE 271</p>
            <p id = "ct11">ENSE 271</p>
            <div><button class="left_arrow" id ="approvedLeft"  onclick = "aLeft()"><i class='fas fa-angle-left'></i></button>
                <button class="right_arrow" id ="approvedRight" onclick = "aRight()"><i class='fas fa-angle-right'></i></button></div>

        </div>




        <div class = "course_not_completed"><h3>Course to take</h3></div>

        <div class = "course_tag_not_completed" id = "not_completed_tag">
            <p id = "nct0">ENSE 271</p>
            <p id = "nct1">ENSE 271</p>
            <p id = "nct2">ENSE 271</p>
            <p id = "nct3">ENSE 271</p>

            <p id = "nct4">ENSE 271</p>
            <p id = "nct5">ENSE 271</p>
            <p id = "nct6">ENSE 271</p>
            <p id = "nct7">ENSE 271</p>
            
            <p id = "nct8">ENSE 271</p>
            <p id = "nct9">ENSE 271</p>
            <p id = "nct10">ENSE 271</p>
            <p id = "nct11">ENSE 271</p>
            <div><button class="left_arrow" id ="notCompletedLeft" onclick = "nctLeft()"><i class='fas fa-angle-left'></i></button>
                <button class="right_arrow" id ="notCompletedRight" onclick = "nctRight()"><i class='fas fa-angle-right'></i></button>
            </div>
        </div>
        <!-- <h3 id = "corner"><a href='academicBuilder_Builder.php'>Go to Schedule Builder</a></h3> -->

    </div>
</section>
</body>
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

