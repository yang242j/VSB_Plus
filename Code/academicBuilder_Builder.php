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
    <link rel="stylesheet" href="css/academicBuilder_Default.css">
    <script src = "js/academicCustomizeBuilder.js"></script>

</head>
<style>

</style>

<body>
    <header>
        <a href="https://www.uregina.ca"><img src="img/logo.png" class="logo" alt="UofR"></a>
        <h1>Visual Schedule Builder Plus</h1>
    </header>

    <nav>
        <div class="menu-icon" onclick="menuFunc1(this); menuFunc2();">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <a class="menu-list nav-active" href="academicBuilder_main.html">Academic Schedule Builder</a>
        <a class="menu-list" href="semesterBuilder.php">Semester Schedule Builder</a>
        <a class="menu-list" href="courseDB.php">Course List Database</a>
        <div class="nav-right">
            <a id="usertext" onclick="addonFunc()">php_userName</a>
            <div id="addon-menu">
                <a>php_SID</a>
                <a href="#Logout">Logout</a>
            </div>
        </div>
    </nav>
<section class = "terms" id = "block" style="float:left;">
        <div class="welcome_tag" id = "welcome">
            <h1>Customize Schedule Builder</h1>
        </div>
    <div class = "term1" id = "term1">
        <div class = "tittle"><h2>Term1:</h2></div>
        <div class = "course_cards" id = "course_cards_builder"><h3>ENSE 370</h3>
        <p>Mechanics for EngineersDynamics asdasXSaas</p>
        <p></p>
        </div>

        <div class = "course_cards" id = "course_cards_builder">
            <h3>ENSE 370</h3>
        <p>Mechanics for EngineersDynamics asdasXSaas</p>
        <p></p>
        </div>

        <div class = "course_cards" id = "course_cards_builder">
            <h3>ENSE 370</h3>
        <p>Mechanics for EngineersDynamics asdasXSaas</p>
        <p></p>
        </div>

        <div class = "course_cards" id = "course_cards_builder">
            <h3>ENSE 370</h3>
        <p>Mechanics for EngineersDynamics asdasXSaas</p>
        <p></p>
        </div>

        <div class = "course_cards" id = "course_cards_builder">
            <h3>ENSE 370</h3>
        <p>Mechanics for EngineersDynamics asdasXSaas</p>
        <p></p>
        </div>  
    </div>
    <div class = "add_to_term" d = "add_to_term1">
        <div class = "tittle"><h2>Add:</h2></div>
        <div class = "course_cards" ></div>
        <div class = "course_cards" ></div>
        <div class = "course_cards" ></div>
        <div class = "course_cards" ></div>
        <div class = "course_cards" ></div>

    </div>
    <div class = "term1" id = "term2">

        <div class = "tittle"><h2>Term2:</h2></div>
        <div class = "course_cards" id = "course_cards_builder"></div>
        <div class = "course_cards" id = "course_cards_builder"></div>
        <div class = "course_cards" id = "course_cards_builder"></div>
        <div class = "course_cards" id = "course_cards_builder"></div>
        <div class = "course_cards" id = "course_cards_builder"></div>

    </div>

    <div class = "add_to_term" id = "add_to_term2">
        <div class = "tittle"><h2>Add:</h2></div>
        <div class = "course_cards" ></div>
        <div class = "course_cards" ></div>
        <div class = "course_cards" ></div>
        <div class = "course_cards" ></div>
        <div class = "course_cards" ></div>
        <div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
            &nbsp;
            <button class="right_arrow"><i class='fas fa-angle-right'></i></button>
        </div>   
    </div>
</section>


<section class = "tags_courses" id ="block" style="float:right;">  

    <div class = "icons_annotation" id = "builder_icon">
        <div class ="icons" style='font-size:14px;color:red'>---- Strongly Recommend</div>
        <div class ="icons" style='font-size:14px;color:blue'>---- Recommend</div>
        <div class ="icons" style='font-size:14px;color:black'>---- Not Recommend</div>
    </div>

    <div class= "course_list">
        <div class = "course_completed"><h3>Course Completed</h3></div>
        <div class = "course_tag_completed">
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>

            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>

            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <div><button class="right_arrow" id ="p1"><i class='fas fa-angle-left'></i></button>
                <button class="right_arrow" id ="p2"><i class='fas fa-angle-right'></i></button></div>

        </div>




        <div class = "course_not_completed"><h3>Course to take</h3></div>

        <div class = "course_tag_not_completed">
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>

            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <p>ENSE 271</p>
            <div><button class="right_arrow" id ="p1"><i class='fas fa-angle-left'></i></button>
                <button class="right_arrow" id ="p2"><i class='fas fa-angle-right'></i></button>
            </div>
        </div>
        <h3 id = "corner"><a href='academicBuilder_main.html'>Go to academic main</a></h3>
        <h3 id = "corner"><a href='academicBuilder_Default.html'>Go to Default Schedule</a></h3>
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
    <p class="info-link"><a href="homePage.html">About Us</a></p>
</footer>
</body>