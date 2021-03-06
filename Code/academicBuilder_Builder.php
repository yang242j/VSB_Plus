<?php
/**
 * The academic customize builder page displayes a personalized academic schedule created by the user as well as the conpleted and recommanded courses section.
 * 
 * Requirments:
 *  1) For the most part of the screen, an empty animated academic calendar schedule should be displayed.
 *  2) The academic schedule should clearly tells user which semester or term is presenting.
 *  3) User should be able to drag the course tag from the recommended (course2take) section and drop into the desired term area as registration.
 *  4) User should also be able to drag the unwanted course from the schedule out as removeal.
 *  5) For the rest part of the screen, the completed courses section as well as the courses2take section should be displayed.
 *  6) Completed courses are there for references and they should not be draged or moved.
 *  7) Recommended courses contains the course tags that are dragable and the course list is generated by using algorithm from courseREC.php
 * 
 * Recommended course requirements see http://15.223.123.122/vsbp/Code/Model/courseREC.php
 * 
 * php Steps:
 *  1) Start session.
 *  2) If not logged in, redirect to login page.
 * 
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/academicBuilder_Builder.php
 * @author      Xia Hua (sid: 200368746) <****@uregina.ca>
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
    <script src='https://kit.fontawesome.com/b95f8ace21.js'></script>
    <!-- icon library -->

    <title>VSB_Plus : Academic</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="team_vsbp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/academicBuilder_Customize.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var sid = "<?php echo $_SESSION["sid"]; ?>";
        var pas = "<?php echo $_SESSION["password"]; ?>";
        var major = "<?php echo $_SESSION["major"]; ?>"
    </script>
    <style>
        .drop-zone--over{ opacity:0.5}
    </style>
</head>

<body>
     <!--<p id = "userId" hidden><?php echo htmlspecialchars($_SESSION["sid"]); ?></p>
    <p id = "password" hidden><?php echo htmlspecialchars($_SESSION["password"]); ?></p> -->
    
    <header>
        <a href="https://www.uregina.ca"><img src="img/logo.png" class="logo" alt="UofR"></a>
        <h1>Visual Schedule Builder Plus</h1>
    </header>
    <nav>
        <div class="nav-right">
            <a id="usertext" onclick="toogleDisplay('addon-menu')"><?php echo htmlspecialchars($_SESSION["name"]); ?></a>
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
        <div class="session-required menu-list nav-active dropdown">
            <button class="dropbtn" onclick="toogleDisplay('dropdown-content')">Academic Schedule Builder</button>
            <div id="dropdown-content" class="dropdown-content">
                <a class="academicList" href="academicBuilder_Main.php">General Student Status</a>
                <a class="academicList" href="academicBuilder_Default.php">Default Schedule</a>
                <a class="academicList" href="academicBuilder_Builder.php">Customized Schedule</a>
            </div>
        </div>
        <a class="session-required menu-list" href="semesterBuilder.php">Semester Schedule Builder</a>
        <a class="menu-list" href="courseDB.php">Course List Database</a>
    </nav>
    <div class="welcome_tag" id = "welcome">
            <h1>Customize Schedule Builder</h1>
        </div>

<section class = "terms" id = "block" style = "overflow:auto; height:800px " >
        <div class="welcome_tag" id = "welcome">
            <h1>Credits Earned:</h1>
        </div>
    
        <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Winter</h2>
            </div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"> </div>
            <div class = "course_cards" id = "course_cards_builder"></div>
             <div class = "course_cards" id = "course_cards_builder"></div>
             <div class = "course_cards" id = "course_cards_builder"></div>  
            </div>
        <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Spring/Summer</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
        </div>
    
        <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Fall</h2>
            </div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"></div>
        </div>

        <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Winter</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <!--<div class = "arrows">
                <button class="right_arrow">
                    <i class='fas fa-angle-left'></i>
                </button>
                &nbsp;
                <button class="right_arrow">
                    <i class='fas fa-angle-right'></i>
                </button>
            </div>  -->
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Spring/Summer</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>

            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Fall</h2>
            </div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"></div>
            <div class = "course_cards" id = "course_cards_builder"></div>
        </div>
        <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Winter</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>

            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Spring/Summer</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>

            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Fall</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>

            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Winter</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Spring/Summer</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Fall</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Winter</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Spring/Summer</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Fall</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Winter</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Spring/Summer</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>
            <div class = "term1" id = "term1">
            <div class = "tittle">
                <h2>Fall</h2>
            </div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            <div class = "course_cards" ></div>
            </div>

           

          


            

       
</section>

<section class = "tags_courses" id ="block" style="float:right;">  

    <div class = "icons_annotation" id ="builder_icon">
        <div class ="icons" style='font-size:16px;color:#b8860b;font-weight: bold'>---- W</div>
        <div class ="icons" style='font-size:16px;color:blue;font-weight: bold'>---- NP</div>
        <div class ="icons" style='font-size:16px;color:grey;font-weight: bold'>---- Passed</div>
        <div class ="icons" style='font-size:16px;color:#008000;font-weight: bold'>---- Good</div>
        <div class ="icons" style='font-size:16px;color:#AD1457;font-weight: bold'>---- Great</div>
        <div class ="icons" style='font-size:16px;color:red;font-weight: bold'>---- Excellent</div>
    </div>

    <div class= "course_list">
        <div class = "course_completed"><h3>Course Completed</h3></div>
        <div class = "course_tag_completed">
            <p id = "ct0"></p>
            <p id = "ct1"></p>
            <p id = "ct2"></p>
            <p id = "ct3"></p>

            <p id = "ct4"></p>
            <p id = "ct5"></p>
            <p id = "ct6"></p>
            <p id = "ct7"></p>

            <p id = "ct8"></p>
            <p id = "ct9"></p>
            <p id = "ct10"></p>
            <p id = "ct11"></p>
            <div>
                <button class="right_arrow" id ="ctLeft"><i class='fas fa-angle-left'></i></button>
                <button class="right_arrow" id ="ctRight"><i class='fas fa-angle-right'></i></button>
            </div>

        </div>

        <div class = "course_not_completed">
            <h3>Course to take</h3>
        </div>
        <div class = "course_tag_not_completed" id = "courseTagArea" style = "overflow:auto">
           <!--<div class = "courseTags" >
               <div draggable = "true" id = "nct0">PlaceHoder</div>
           </div>
           <div class = "courseTags" >
               <div draggable = "true" id = "nct1">PlaceHoder</div>
           </div>
           <div class = "courseTags" >
               <div draggable = "true" id = "nct2">PlaceHoder</div>
           </div>
           <div class = "courseTags" >
               <div draggable = "true" id = "nct3">PlaceHoder</div>
           </div>
-->
           


            

           
            <!--<div>
                <button class="right_arrow" id ="nctLeft"><i class='fas fa-angle-left'></i></button>
                <button class="left_arrow" id ="nctRight"><i class='fas fa-angle-right'></i></button>
            </div> -->
        </div>
        <!-- <h3 id = "corner"><a href='academicBuilder_Main.php'>Go to academic main</a></h3>
        <h3 id = "corner"><a href='academicBuilder_Default.php'>Go to Default Schedule</a></h3> -->
    </div>

</section>

<footer>
    <script src="js/main.js"></script>
    <script type="text/javascript" src ="js/academicCustomizeBuilder.js"></script>
    
    <p class="copyright">Copyright &copy; Sep. 2020 to
        <script>document.write(new Date().getFullYear())</script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
        <cite>
            Credit: 
        </cite>
    </p>
    <p class="info-link"><a href="homePage.php">About Us</a></p>
</footer>
</body>
