<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>VSB_Plus : SignUp</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="team_vsbp">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/logIn-signUp.css">
</head>

<body>

    <header>
        <a href="https://www.uregina.ca"><img src="img/logo.png" class="logo" alt="UofR"></a>
        <h1>Visual Schedule Builder Plus</h1>
    </header>

    <nav>
        <div class="menu-icon change">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <a class="menu-list hidden" href="academicBuilder.html" disabled>Academic Schedule Builder</a>
        <a class="menu-list hidden" href="semesterBuilder.html">Semester Schedule Builder</a>
        <a class="menu-list hidden" href="courseDB.html">Course List Database</a>
        <div class="nav-right">
            <a href="login.php">LogIn</a>
            <a class="nav-active" href="signup.php">SignUp</a>
        </div>
    </nav>

    <section class="container">
        <div class="form-div">
            <h2>User SignUp</h1>
            <form>
                <label>Student ID:</label><br>
                <input type="text" id="sid" placeholder="200312345"><br><br>
                <label>Student Name:</label><br>
                <input type="text" id="name" placeholder="LastName, FirstName"><br><br>
                <label>Campus:</label><br>
                <input type="text" id="campus" placeholder="U of R" value="U of R"><br><br>
                <label>Faculty:</label><br>
                <input type="text" id="faculty" placeholder="Engineering &amp; Applied Science" value="Engineering &amp; Applied Science"><br><br>
                <label>Program:</label><br>
                <input type="text" id="program" placeholder="Bachelor of Applied Science" value="Bachelor of Applied Science"><br><br>
                <label>Major:</label><br>
                <input type="text" id="major" placeholder="Software Systems Engineering" value="Software Systems Engineering"><br><br>
                <label>Minor:</label><br>
                <input type="text" id="minor" placeholder=""><br><br>
                <label>Concentration:</label><br>
                <input type="text" id="concentration" placeholder=""><br><br>
                <label>Total Credit Hours:</label><br>
                <input type="text" id="credit_hour" placeholder="0"><br><br>
                <label>Grade Point Average:</label><br>
                <input type="text" id="gpa" placeholder="60"><br><br>
                <label>Password:</label><br>
                <input type="password" id="password" placeholder="*********"><br><br>
                <button id="reset" type="reset">&#10006<p class="hidden">  Reset Form</p></button>
                <button id="submit" type="submit">&#10004<p class="show">  Submit</p></button><br><br>
                <p>
                    *Already have an account? 
                    <a id="quickLink" href="login.php">Login here</a>.*
                </p>
            </form>
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

</html>