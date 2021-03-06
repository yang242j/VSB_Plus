<?php
/**
 * The academic default builder page displayes the school provided default academic schedule as well as the program approved elective course list.
 * 
 * Requirments:
 *  1) For the most part of the screen, an animated academic calendar schedule should be displayed.
 *  2) The academic schedule should clearly tells user which semester or term is presenting.
 *  3) For the rest part of the screen, the program approved elective course list should be displayed.
 * 
 * php Steps:
 *  1) Start session.
 *  2) If not logged in, redirect to login page.
 * 
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/academicBuilder_Default.php
 * @author      Priscilla Chua (sid: 200363504) <****@uregina.ca>
 * @param       {boolean}       $_SESSION["loggedin"]       Status of logged-in or not: true/false
 * @param       {integer}       $_SESSION["sid"]            Student id
 * @param       {string}        $_SESSION["name"]           Student name
 * @param       {string}        $_SESSION["major"]          Student major
 * @param       {string}        $_SESSION["password"]       Student password
 */

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
        <div class="Term">
        <div class="welcome_tag" id = "welcome">
            <h1>Default Schedule</h1>
        </div>
    
    <div id = "autoscroll">
    <div class = "term1" id = "term1">
        <div class = "tittle"><h2>Term1:</h2></div>
        <div class = "course_cards">
              <h3>CHEM104</h3>
              <h4>CHEM30 or CHEM100(minimum 65%); and Precalculus 30 or Mathematics C30 with a grade of at least 65%, or AMTH092 with a grade of at least 80%, or MATH102</h4>
        </div>
        <div class = "course_cards">
            <h3>ENGG123</h3>
            <h4>None</h4>
      </div>
      <div class = "course_cards">
        <h3>ENGG140</h3>
        <h4>MATH110(may be take concurrently)</h4>
  </div>
  <div class = "course_cards">
    <h3>MATH110</h3>
    <h4>Precalculus 30 with at least 75%, or Calculus 30 or Mathematics B30 and C30 with a grade of at least 65% in each or Math102</h4>
</div>
<div class = "course_cards">
    <h3>MATH122</h3>
   <!-- <i class='fas fa-circle' style='font-size:24px;color:red'></i>  
    <i class='fas fa-circle' style='font-size:24px;color:red'></i>
    <i class='fas fa-circle' style='font-size:24px;color:red'></i>
    <i class='fas fa-circle' style='font-size:24px;color:red'></i> -->
</div>
        <!--<div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
            &nbsp;
            <button class="right_arrow"><i class='fas fa-angle-right'></i></button>
        </div>-->   
    </div>
    <div class = "term1" id ="term2">
        <div class = "tittle"><h2>Term2:</h2></div>
        <div class = "course_cards">
        <h3>CS110</h3>
        </div>
        <div class = "course_cards">
        <h3>ENGG100</h3>
        </div>
        <div class = "course_cards">
        <h3>ENGL100</h3>
        </div>
        <div class = "course_cards">
        <h3>MATH111</h3>
        </div>
        <div class = "course_cards">
        <h3>PHYS119</h3>
        </div>

        <!--<div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
            &nbsp;
            <button class="right_arrow"><i class='fas fa-angle-right'></i></button>  
    </div>-->
    </div>
    <div class = "term1" id ="term3">

        <div class = "tittle"><h2>Term3:</h2></div>
        <div class = "course_cards">
        <h3>CS115</h3>
        </div>
        <div class = "course_cards">
        <h3>ENEL280</h3>
        </div>
        <div class = "course_cards">
        <h3>ENEV223</h3>
        </div>
        <div class = "course_cards">
        <h3>MATH213</h3>
        </div>
        <div class = "course_cards">
        <h3>PHYS112</h3>
        </div>

        <!--<div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
            &nbsp;
            <button class="right_arrow"><i class='fas fa-angle-right'></i></button>
        </div>-->
    </div>

    <div class = "term1" id ="term4">
        <div class = "tittle"><h2>Term4:</h2></div>
        <div class = "course_cards">
        <h3>CS210</h3>
        </div>
        <div class = "course_cards">
        <h3>ENEL281</h3>
        </div>
        <div class = "course_cards">
        <h3>ENEL282</h3>
        </div>
        <div class = "course_cards">
        <h3>MATH217</h3>
        </div>
        <div class = "course_cards">
        <h3>STAT289</h3>
        </div>

        <div class = "term1" id ="term5">
        <div class = "tittle"><h2>Term5:</h2></div>
        <div class = "course_cards">
        <h3>CS215</h3>
        </div>
        <div class = "course_cards">
        <h3>CS340</h3>
        </div>
        <div class = "course_cards">
        <h3>ENEL384</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE352</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE374</h3>
        </div>
        </div>
        
        <div class = "term1" id ="term6">
        <div class = "tittle"><h2>Term6:</h2></div>
        <div class = "course_cards">
        <h3>BUS260</h3>
        </div>
        <div class = "course_cards">
        <h3>ECON201</h3>
        </div>
        <div class = "course_cards">
        <h3>ENEL380</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE353</h3>
        </div>
        <div class = "course_cards">
        <h3>Approved Elective</h3>
        </div>
        </div>

    <div class = "term1" id ="term7">
        <div class = "tittle"><h2>Term7:</h2></div>
        <div class = "course_cards">
        <h3>ENEL387</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE470</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE471</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE475</h3>
        </div>
        <div class = "course_cards">
        <h3>Approved Elective</h3>
        </div>
    </div>

    <div class = "term1" id ="term8">
        <div class = "tittle"><h2>Term8:</h2></div>
        <div class = "course_cards">
        <h3>ENGG303</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE400</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE472</h3>
        </div>
        <div class = "course_cards">
        <h3>Approved Elective</h3>
        </div>
        <div class = "course_cards">
        <h3>Approved Elective</h3>
        </div>
        </div>

    <div class = "term1" id ="term9">
        <div class = "tittle"><h2>Term9:</h2></div>
        <div class = "course_cards">
        <h3>ENGG401</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE350</h3>
        </div>
        <div class = "course_cards">
        <h3>ENSE477</h3>
        </div>
        <div class = "course_cards">
        <h3>Approved Elective</h3>
        </div>
        <div class = "course_cards">
        <h3>Approved Elective</h3>
        </div>

    </div>
    </div> 
    </div>
    <!--<div class = "arrows"><button class="up_arrow" id = "term_up" onclick = "termUp()"><i class='fas fa-angle-double-up'></i></button>
        &nbsp;
        <button class="down_arrow" id = "term_down" onclick = "termDown()"><i class='fas fa-angle-double-down'></i></button>-->
</section>


<section class = "tags_courses" id ="block" style="float:right;">  

    <!--<div class = "icons_annotation" id = "default_icon">
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:red'>Easy</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:yellow'>Medium</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:blue'>Hard</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:purple'>Low Average</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:plum'>Quizs</i></div>
        <div class ="icons"><i class='fas fa-circle' style='font-size:24px;color:black'>Pass Final</i></div>
    </div>
-->


    <div class= "course_list">

        <div class = "course_completed"><h3 style='font-size:24px;'>Approved Course</h3></div>

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




        <div class = "course_not_completed"><h3 style='font-size:24px;'>Course to take</h3></div>

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
