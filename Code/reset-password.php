<?php
session_start(); // Initialize the session

// Check if the user is already logged in, if yes then redirect him to Academic home page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: academicBuilder_main.html");
    exit;
}

// Include the vsbp_db_config.php file
require_once "Model/vsbp_db_config.php";

// Define variables and initialize with empty values
$sid = $new_password = $confirm_password = "";
$sid_err = $new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if student_id is empty
    if (empty(trim($_POST["sid"]))) {
        $sid_err = "Please enter student_id.";
    } elseif (!is_numeric(trim($_POST["sid"]))) {
        $sid_err = "Student ID must be all numbers.";
    } else {
        // Prepare a select statement
        $sql = "SELECT student_id FROM students WHERE student_id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_sid);

            // Set parameters
            $param_sid = trim($_POST["sid"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $sid = trim($_POST["sid"]);
                } else {
                    $sid_err = "This student_id does not exist.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Check if password is empty
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter your new password.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate credentials (format is correct)
    if (empty($sid_err) && empty($new_password_err) && empty($confirm_password_err)) {

        // Prepare a select statement
        $sql = "UPDATE students SET password = ? WHERE student_id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_sid);

            // Set parameters
            $param_sid = $sid;
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Redirect to login page
                echo "SID -> $sid\nPassword has been successfully changed.";
                echo "Redirect to LogIn page in 5s.";
                header('refresh:5; url=login.php');
            } else{
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
    <title>VSB_Plus : Reset Password</title>

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
        <a class="menu-list hidden" href="semesterBuilder.php">Semester Schedule Builder</a>
        <a class="menu-list hidden" href="courseDB.html">Course List Database</a>
        <div class="nav-right">
            <a href="login.php">LogIn</a>
            <a href="signup.php">SignUp</a>
        </div>
    </nav>

    <section class="container">
        <div class="form-div">
            <h2>Reset Password</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <!-- Student ID -->
                <div class="form-group <?php echo (!empty($sid_err)) ? 'has-error' : ''; ?>">
                    <label>Student ID:</label>
                    <input class="form-input" type="text" name="sid" value="<?php echo $sid; ?>">
                    <span class="help-block">
                        <?php echo $sid_err; ?>
                    </span>
                </div>

                <!-- New Password -->
                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                    <label>New Password:</label>
                    <input class="form-input" type="password" name="new_password" value="<?php echo $new_password; ?>">
                    <span class="help-block">
                        <?php echo $new_password_err; ?>
                    </span>
                </div>

                <!-- Confirm New Password -->
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password:</label>
                    <input class="form-input" type="password" name="confirm_password">
                    <span class="help-block">
                        <?php echo $confirm_password_err; ?>
                    </span>
                </div>

                <!-- Submit & Cancel -->
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="button" class="btn" value="Cancel" onclick="window.location='login.php'">
                </div>
            </form>
        </div>
    </section>

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

</html>