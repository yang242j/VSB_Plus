<?php
/**
 * A form to let admin to login.
 *
 * Requirments:
 *  1) Required enter the student ID to login.
 *  2) Required the password.
 *
 * php Steps:
 *  1) If logged in, redirect to main page.
 *  2) Required once vsbp_db_config.php
 *  3) Define all variables.
 *  4) If getting POST request, check each field legitimate.
 *  5) For each field, if match validation, store, else print error message.
 *  6) If no error messages, and password verified, start session.
 *  7) Redirect to main page.
 *
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/login.php
 * @author      Jingkang Yang (sid: 200362586) <yang242j@uregina.ca>
 * @param       {boolean}       $_SESSION["loggedin"]       Status of logged-in or not: true/false
 * @param       {integer}       $_SESSION["sid"]            Student id
 * @param       {string}        $_SESSION["password"]       Student password
 * @param       {string}        $_SESSION["name"]           Student name
 * @param       {string}        $_SESSION["major"]          Student major
 */

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to Academic home page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["admin"] === true) {
        header('Location: Model/test.php');
    } else {
        header("location: academicBuilder_Main.php");
    }
    exit();
}

// Include the vsbp_db_config.php file
require_once "Model/vsbp_db_config.php";

// Define variables andd initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if student_id is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
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
        $sql =
            "SELECT username, password, admin_id FROM admin WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if student_id exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result(
                        $stmt,
                        $username,
                        $admin_password,
                        $admin_id
                    );
                    if (mysqli_stmt_fetch($stmt)) {
                        $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);
                        if (password_verify($password, $hash_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["admin"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["password"] = $password;
                            $_SESSION["adminid"] = $admin_id;
                            $_SESSION["lastActTime"] = time();

                            // Redirect user to welcome page
                            header("location: Model/test.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password was not valid.";
                        }
                    }
                } else {
                    // Display an error message if studentid doesn't exist
                    $studentid_err = "No account found with this username.";
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
    <title>VSB_Plus : Admin LogIn</title>

    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="team_vsbp">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/logIn-signUp.css">
</head>

<body>

    <header>
        <a href="http://15.223.123.122/vsbp/Code/academicBuilder_Main.php"><img src="img/logo.png" class="logo" alt="UofR"></a>
        <h1>Visual Schedule Builder Plus</h1>
    </header>

    <nav>
        <div class="nav-right">
            <a class="nav-active" href="login.php">Stu. LogIn</a>
            <a href="signup.php">Stu. SignUp</a>
        </div>
        <div class="menu-icon change">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <section class="container">
        <div class="form-div">
            <h2>Admin LogIn</h2>
            <form action="<?php echo htmlspecialchars(
                $_SERVER["PHP_SELF"]
            ); ?>" method="POST">
                <!-- username -->
                <div class="form-group <?php echo !empty($username_err)
                    ? 'has-error'
                    : ''; ?>">
                    <label>username:</label>
                    <input class="form-input" type="text" name="username" value="<?php echo $username; ?>">
                    <span class="help-block">
                        <?php echo $username_err; ?>
                    </span>
                </div>

                <!-- Password -->
                <div class="form-group <?php echo !empty($password_err)
                    ? 'has-error'
                    : ''; ?>">
                    <label>Password:</label>
                    <input class="form-input" type="password" name="password">
                    <span class="help-block">
                        <?php echo $password_err; ?>
                    </span>
                </div>

                <!-- Login & Reset -->
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>

                <!-- Guest link -->
                <p style="margin-left: 5%;">*To login as <a id="quickLink" href="login.php">STUDENT</a> *</p>
            </form>
        </div>
        <div class="disclaimer">
            <h2>User Notes:</h2>
            <div class="paragraghs">
                <p>&emsp;This web application is developed and test without the support of UofR ITsupport. Some of the courses' data may vary  from the UofR official website. In the event of any conflict between this application and the University of Regina, the latter shall prevail.</p>
                <p>&emsp;The Simulateed courses schedules are only for reference, please make the official advice as the standard.</p>
                <p>&emsp;Please do <b>NOT</b> block Pop-ups</p>
        </div>
        </div>
    </section>

    <footer>
        <script src="js/main.js"></script>
        <p class="copyright">Copyright &copy; Sep. 2020 to
            <script>
                document.write(new Date().getFullYear())
            </script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
            <cite>
                Credit: PHP MySQL Login System with help from Tutorial Republic<br>
            </cite>
        </p>
        <p class="info-link"><a href="homePage.php">About Us</a></p>
    </footer>
</body>

</html>