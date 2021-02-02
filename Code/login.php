<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to Academic home page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: academicBuilder_main.html");
    exit;
}

// Include the vsbp_db_config.php file
require_once "Model/vsbp_db_config.php";

// Define variables andd initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter student_id.";
    } elseif (!is_numeric(trim($_POST["username"]))) {
        $username_err = "Student ID must be all numbers.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials (format is correct)
    if (empty($username_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT student_id, name, password FROM students WHERE student_id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: academicBuilder_main.html");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that student_id.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>VSB_Plus : LogIn</title>

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
            <a class="nav-active" href="login.html">LogIn</a>
            <a href="signup.html">SignUp</a>
        </div>
    </nav>

    <section class="container">
        <div class="form-div">
            <h2>User LogIn</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="input_div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Student ID:</label>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                        <span class="help-block">
                            <?php echo $username_err; ?>
                        </span>
                    </div>

                    <div class="input_div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password:</label>
                        <input type="password" name="password">
                        <span class="help-block">
                            <?php echo $password_err; ?>
                        </span>
                    </div>

                    <button id="reset" type="button" onclick="resetPassword()">
                        &#10006<p class="hidden"> Forget Password</p>
                    </button>

                    <button id="submit" type="submit">
                        &#10004<p class="show"> Login</p>
                    </button>
                </form>
                <p>
                    *Login as
                    <a id="quickLink" href="courseDB.html">GUEST</a>
                    will not have full access to this website*
                </p>
        </div>
    </section>

    <footer>
        <script src="js/main.js"></script>
        <script src="js/logIn.js"></script>
        <p class="copyright">Copyright &copy; Sep. 2020 to
            <script>
                document.write(new Date().getFullYear())
            </script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
            <cite>
                Credit:
            </cite>
        </p>
        <p class="info-link"><a href="homePage.html">About Us</a></p>
    </footer>
</body>

</html>