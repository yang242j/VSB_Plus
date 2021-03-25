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

session_start(); // Initialize the session

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
    <link rel="stylesheet" href="css/academicBuilder_Customize.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var sid = "<?php echo $_SESSION["sid"]; ?>";
        var pas = "<?php echo $_SESSION["password"]; ?>";
        var major = "<?php echo $_SESSION["major"]; ?>"

		var isMobile = window.matchMedia('(max-width: 1080px)').matches;
        $(document).ready(function() {
            if (isMobile) $(".menu-icon").click();
        });
    </script>
    <style>
        .drop-zone--over{ opacity:0.5}
    </style>
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
    <div class="container">
		<div class="welcome_tag" id = "welcome">
			<h1 id = "show_credits">Credits:</h1>
			<pre>tips: 
			1.drag the course form course to take box and drop it on Customize Schedule Builder box.The system will match the 
			  prerequiste and term for user, if confict happens some tips will show up. 
			2.The course name is red when prerequiste confict happens  
			3.Term Info is red when term confict happens
			4.Some course is not applied because course changed does not updated 
			</pre>
			<h2>Customize Schedule Builder (Not recommended use in touchscreen)</h2>
		</div>

		<section class = "terms" id = "block">
			<div class = "termGrid" id = "term1">
				<div class = "tittle" style="grid-area: title;">
					<h3>Winter</h3>
				</div>
				<div class = "course_cards" id = "Winter" name ="1"></div>
				<div class = "course_cards" id = "Winter" name ="1"></div>
				<div class = "course_cards" id = "Winter" name ="1"></div>
				<div class = "course_cards" id = "Winter" name ="1"></div>
				<div class = "course_cards" id = "Winter" name ="1"></div>  
			</div>
			
			<div class = "termGrid" id = "term2">
				<div class = "tittle" style="grid-area: title;">
					<h3>Spr./Sum.</h3>
				</div>
				<div class = "course_cards" id = "Spring/Summer" name ="2"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="2"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="2"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="2"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="2"></div>
			</div>
		
			<div class = "termGrid" id = "term3">
				<div class = "tittle" style="grid-area: title;">
					<h3>Fall</h3>
				</div>
				<div class = "course_cards" id = "Fall" name ="3"></div>
				<div class = "course_cards" id = "Fall" name ="3"></div>
				<div class = "course_cards" id = "Fall" name ="3"></div>
				<div class = "course_cards" id = "Fall" name ="3"></div>
				<div class = "course_cards" id = "Fall" name ="3"></div>
			</div>

			<div class = "termGrid" id = "term4">
				<div class = "tittle" style="grid-area: title;">
					<h3>Winter</h3>
				</div>
				<div class = "course_cards" id = "Winter" name ="4"></div>
				<div class = "course_cards" id = "Winter" name ="4"></div>
				<div class = "course_cards" id = "Winter" name ="4"></div>
				<div class = "course_cards" id = "Winter" name ="4"></div>
				<div class = "course_cards" id = "Winter" name ="4"></div>
			</div>
			
			<div class = "termGrid" id = "term5">
				<div class = "tittle" style="grid-area: title;">
					<h3>Spr./Sum.</h3>
				</div>
				<div class = "course_cards" id = "Spring/Summer" name ="5"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="5"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="5"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="5"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="5"></div>
			</div>
			
			<div class = "termGrid" id = "term6">
				<div class = "tittle" style="grid-area: title;">
					<h3>Fall</h3>
				</div>
				<div class = "course_cards" id = "Fall" name ="6"></div>
				<div class = "course_cards" id = "Fall" name ="6"></div>
				<div class = "course_cards" id = "Fall" name ="6"></div>
				<div class = "course_cards" id = "Fall" name ="6"></div>
				<div class = "course_cards" id = "Fall" name ="6"></div>
			</div>

			<div class = "termGrid" id = "term7">
				<div class = "tittle" style="grid-area: title;">
					<h3>Winter</h3>
				</div>
				<div class = "course_cards" id = "Winter" name ="7"></div>
				<div class = "course_cards" id = "Winter" name ="7"></div>
				<div class = "course_cards" id = "Winter" name ="7"></div>
				<div class = "course_cards" id = "Winter" name ="7"></div>
				<div class = "course_cards" id = "Winter" name ="7"></div>
			</div>

			<div class = "termGrid" id = "term8">
				<div class = "tittle" style="grid-area: title;">
					<h3>Spr./Sum.</h3>
				</div>
				<div class = "course_cards" id = "Spring/Summer" name ="8"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="8"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="8"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="8"></div>
				<div class = "course_cards" id = "Spring/Summer" name ="8"></div>
			</div>

			<div class = "termGrid" id = "term9">
				<div class = "tittle" style="grid-area: title;">
					<h3>Fall</h2>
				</div>
				<div class = "course_cards" id = "Fall" name ="9"></div>
				<div class = "course_cards" id = "Fall" name ="9"></div>
				<div class = "course_cards" id = "Fall" name ="9"></div>
				<div class = "course_cards" id = "Fall" name ="9"></div>
				<div class = "course_cards" id = "Fall" name ="9"></div>
			</div>
		</section>

		<section class = "tags_courses" id ="block">
            <div class= "course_list" style="grid-area: title;">
				<h3>Course to take</h3>
				<nav>
				<button id = "btnALL" style='font-size:24px;color:white;font-weight: bold background-color: transparent'>ALL</button>
				<button id = "btnENSE" style='font-size:24px;color:white;font-weight: bold background-color: transparent'>ENSE</button>
				<button id = "btnENEL" style='font-size:24px;color:white;font-weight: bold background-color: transparent'>ENEL</button>
				<button id = "btnCS" style='font-size:24px;color:white;font-weight: bold background-color: transparent'>CS </button>
				<button id = "btnMATH" style='font-size:24px;color:white;font-weight: bold background-color: transparent'>MATH</button>		
				<!--<button id = "btnOTHER"style='font-size:24px;color:white;font-weight: bold background-color: transparent'>OTHER</button>
				-->
				</nav>


			
				<div class = "course_tag_not_completed" id = "courseTagArea">
				</div>
                <!-- <div>
					<button class="right_arrow" id ="nctLeft"><i class='fas fa-angle-left'></i></button>
					<button class="left_arrow" id ="nctRight"><i class='fas fa-angle-right'></i></button>
				</div> -->
			</div>
			<div>
					<button class="right_arrow" id ="nctLeft"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="nctRight"><i class='fas fa-angle-right'></i></button>
				</div>

			<div class= "course_list">
				<h3>Course Taken History</h3>
				<div class = "course_tag_completed" id = "courseCompletedTag">
					<!--<p id = "ct0"></p>-->
				</div>
				<div>
					<button class="right_arrow" id ="ctLeft"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="ctRight"><i class='fas fa-angle-right'></i></button>
				</div>
			</div>

			<div class = "icons_annotation" id ="builder_icon">
				<div class ="icons" style='font-size:16px;color:darkgoldenrod;font-weight: bold'>---- W</div>
				<div class ="icons" style='font-size:16px;color:blue;font-weight: bold'>---- NP</div>
				<div class ="icons" style='font-size:16px;color:grey;font-weight: bold'>---- Passed</div>
				<div class ="icons" style='font-size:16px;color:green;font-weight: bold'>---- Good</div>
				<div class ="icons" style='font-size:16px;color:orange;font-weight: bold'>---- Great</div>
				<div class ="icons" style='font-size:16px;color:red;font-weight: bold'>---- Excellent</div>
			</div>

		</section>
    </div>

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
