<?php
/**
 * A form to let user to signup an account.
 *
 * Requirments:
 *  1) Required using student ID to login.
 *  2) Required student name.
 *  3) Campus default to "University of Regina".
 *  4) Faculty default to "Engineering and Applied Science".
 *  5) Program default to "Bachelor of Applied Science".
 *  6) Major default to "Software Systems Engineering".
 *  7) Minor not required, can be empty.
 *  8) Concentration not required, can be empty.
 *  9) Required Total Credit Hours with unit hours.
 * 10) Required GPA with unit %
 * 11) Required password
 * 12) Required confirm password
 *
 * php Steps:
 *  1) Required once vsbp_db_config.php
 *  2) Define all variables.
 *  3) If getting POST request, check each field legitimate.
 *  4) For each field, if match validation, store, else print error message.
 *  5) If no error messages, store new account info into db and create personal grade table.
 *  6) After 5 seconds, redirect to login page.
 *
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/signup.php
 * @author      Jingkang Yang (sid: 200362586) <yang242j@uregina.ca>
 */

// Include config file
require_once "Model/vsbp_db_config.php";

// Define variables and initialize with empty values
$message = "";

$sid = $name = $campus = $faculty = $program = $major = $minor = $concentration = $credit_hour = $gpa = $password = $confirm_password =
    "";

$sid_err = $name_err = $campus_err = $faculty_err = $program_err = $major_err = $minor_err = $concentration_err = $credit_hour_err = $gpa_err = $password_err = $confirm_password_err =
    "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate student ID
    if (empty(trim($_POST["sid"]))) {
        $sid_err = "Please enter student_id. NOT 0";
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
                    $sid_err = "This student_id has already taken.";
                } else {
                    $sid = trim($_POST["sid"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate student name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate campus
    if (empty(trim($_POST["campus"]))) {
        $campus_err = "Please enter a campus name.";
    } else {
        $campus = trim($_POST["campus"]);
    }

    // Validate faculty
    if (empty(trim($_POST["faculty"]))) {
        $faculty_err = "Please enter a faculty name.";
    } else {
        $faculty = trim($_POST["faculty"]);
    }

    // Validate program
    if (empty(trim($_POST["program"]))) {
        $program_err = "Please enter a program name.";
    } else {
        $program = trim($_POST["program"]);
    }

    // Validate major
    if (empty(trim($_POST["major"]))) {
        $major_err = "Please enter a major name.";
    } else {
        $major = trim($_POST["major"]);
    }

    // Validate minor (can be empty)
    $minor = trim($_POST["minor"]);

    // Validate concentration (can be empty)
    $concentration = trim($_POST["concentration"]);

    // Validate credit_hour
    if (empty(trim($_POST["credit_hour"]))) {
        $credit_hour_err = "Please enter your credit hours. NOT 0";
    } elseif (!is_numeric(trim($_POST["credit_hour"]))) {
        $credit_hour_err = "Credit hour must be a number.";
    } elseif (trim($_POST["credit_hour"]) < 0) {
        $credit_hour_err = "Credit hour must be great than 0.";
    } elseif (
        !is_int(filter_input(INPUT_POST, "credit_hour", FILTER_VALIDATE_INT))
    ) {
        $credit_hour_err = "Credit hour must be an integer.";
    } else {
        $credit_hour = trim($_POST["credit_hour"]);
    }

    // Validate GPA
    if (empty(trim($_POST["gpa"]))) {
        $gpa_err = "Please enter your GPA. NOT 0";
    } elseif (!is_numeric(trim($_POST["gpa"]))) {
        $gpa_err = "GPA must be a number.";
    } elseif (trim($_POST["gpa"]) < 0) {
        $gpa_err = "GPA must be great than 0.";
    } elseif (trim($_POST["gpa"]) > 100) {
        $gpa_err = "GPA must be less than 100.";
    } else {
        $gpa = trim($_POST["gpa"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && $password != $confirm_password) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (
        empty($sid_err) &&
        empty($name_err) &&
        empty($campus_err) &&
        empty($faculty_err) &&
        empty($program_err) &&
        empty($major_err) &&
        empty($minor_err) &&
        empty($concentration_err) &&
        empty($credit_hour_err) &&
        empty($gpa_err) &&
        empty($password_err) &&
        empty($confirm_password_err)
    ) {
        // Prepare an insert statement
        $sql =
            "INSERT INTO students (student_id, name, campus, faculty, program, major, minor, concentration, totalCredit, GPA, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement sql as parameters
            mysqli_stmt_bind_param(
                $stmt,
                "isssssssiis",
                $param_sid,
                $param_name,
                $param_campus,
                $param_faculty,
                $param_program,
                $param_major,
                $param_minor,
                $param_concentration,
                $param_credit_hour,
                $param_gpa,
                $param_password
            );

            // Set parameters
            $param_sid = $sid;
            $param_name = $name;
            $param_campus = $campus;
            $param_faculty = $faculty;
            $param_program = $program;
            $param_major = $major;
            $param_minor = $minor;
            $param_concentration = $concentration;
            $param_credit_hour = $credit_hour;
            $param_gpa = $gpa;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement (add new student)
            if (mysqli_stmt_execute($stmt)) {
                $new_tablename = "S" . $sid;
                $sql_table = "CREATE TABLE $new_tablename (courseIndex INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, term VARCHAR(255) NOT NULL, course_ID VARCHAR(255) NOT NULL, section_num VARCHAR(255) NOT NULL, course_title VARCHAR(255) NOT NULL, final_grade VARCHAR(255) NOT NULL, credit_hour INT(11) NOT NULL DEFAULT 3, credit_earned INT(11) NOT NULL, class_size INT(11) NOT NULL, class_average INT(11) NOT NULL)";

                if ($conn->query($sql_table) === true) {
                    echo "Welcome $name!\nYour table ( $new_tablename ) has been created.";
                    echo "Redirect to LogIn page in 5s.";
                    // Redirect to login page
                    header('refresh:5; url=login.php');
                } else {
                    echo "Error creating table: " . $conn->error;
                }
            } else {
                echo "Something went wrong. Please try again later.";
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
        <a href="http://15.223.123.122/vsbp/Code/academicBuilder_Main.php"><img src="img/logo.png" class="logo" alt="UofR"></a>
        <h1>Visual Schedule Builder Plus</h1>
    </header>

    <nav>
        <div class="nav-right">
            <a href="login.php">LogIn</a>
            <a class="nav-active" href="signup.php">SignUp</a>
        </div>
        <div class="menu-icon change">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <section class="container">
        <div class="form-div">
            <h2>User SignUp</h1>
                <form action="<?php echo htmlspecialchars(
                    $_SERVER["PHP_SELF"]
                ); ?>" method="post">
                    <div class="form-group <?php echo !empty($sid_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>*** Student ID:</label>
                        <input class="form-input" type="text" name="sid" placeholder="200312345" value="<?php echo $sid; ?>" required>
                        <span class="help-block">
                            <?php echo $sid_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($name_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>*** Student Name:</label>
                        <input class="form-input" type="text" name="name" placeholder="LastName, FirstName" value="<?php echo $name; ?>" required>
                        <span class="help-block">
                            <?php echo $name_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($campus_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>Campus:</label>
                        <select class="form-input" name="campus">
                            <option value="University of Regina" selected>University of Regina</option>
                            <option value="Campion College">Campion College</option>
                            <option value="First Nations University of Canada">First Nations University of Canada</option>
                            <option value="Luther College">Luther College</option>
                        </select>
                        <span class="help-block">
                            <?php echo $campus_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($faculty_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>Faculty:</label>
                        <select class="form-input" name="faculty">
                            <option value="Arts">Arts</option>
                            <option value="Business Administration">Business Administration</option>
                            <option value="Centre for Continuing Education">Centre for Continuing Education</option>
                            <option value="Education">Education</option>
                            <option value="Engineering and Applied Science" selected>Engineering and Applied Science</option>
                            <option value="Kinesiology and Health Studies">Kinesiology and Health Studies</option>
                            <option value="La Cité universitaire francophone">La Cité universitaire francophone</option>
                            <option value="Media, Art, and Performance">Media, Art, and Performance</option>
                            <option value="Nursing">Nursing</option>
                            <option value="Science">Science</option>
                            <option value="Social Work">Social Work</option>
                        </select>
                        <span class="help-block">
                            <?php echo $faculty_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($program_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>Program:</label>
                        <select class="form-input" name="program">
                            <option value="BASc" selected>Bachelor of Applied Science</option>
                        </select>
                        <span class="help-block">
                            <?php echo $program_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($major_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>Major:</label>
                        <select class="form-input" name="major">
                            <option value="ESE">Electronic Systems Engineering</option>
                            <option value="EVSE">Environmental Systems Engineering</option>
                            <option value="ISE">Industrial Systems Engineering</option>
                            <option value="PSE">Petroleum Systems Engineering</option>
                            <option value="SSE" selected>Software Systems Engineering</option>
                        </select>
                        <span class="help-block">
                            <?php echo $major_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($minor_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>Minor:</label>
                        <input class="form-input" type="text" name="minor" placeholder="" value="<?php echo $minor; ?>">
                        <span class="help-block">
                            <?php echo $minor_err; ?>
                        </span>
                    </div>


                    <div class="form-group <?php echo !empty($concentration_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>Concentration:</label>
                        <input class="form-input" type="text" name="concentration" placeholder="" value="<?php echo $concentration; ?>">
                        <span class="help-block">
                            <?php echo $concentration_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($credit_hour_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>*** Total Credit Hours:</label>
                        <input class="form-input" type="text" name="credit_hour" placeholder="" value="<?php echo $credit_hour; ?>" required>
                        <span style="margin-left:-20px;">h</span>
                        <span class="help-block">
                            <?php echo $credit_hour_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($gpa_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>*** Grade Point Average:</label>
                        <input class="form-input" type="text" name="gpa" placeholder="60" value="<?php echo $gpa; ?>" required>
                        <span style="margin-left:-20px;">%</span>
                        <span class="help-block">
                            <?php echo $gpa_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty($password_err)
                        ? 'has-error'
                        : ''; ?>">
                        <label>*** Password:</label>
                        <input class="form-input" type="password" name="password" value="<?php echo $password; ?>" required>
                        <span class="help-block">
                            <?php echo $password_err; ?>
                        </span>
                    </div>

                    <div class="form-group <?php echo !empty(
                        $confirm_password_err
                    )
                        ? 'has-error'
                        : ''; ?>">
                        <label>*** Confirm Password:</label>
                        <input class="form-input" type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" required>
                        <span class="help-block">
                            <?php echo $confirm_password_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn" value="Reset">
                    </div>

                    <p>*Already have an account? <a id="quickLink" href="login.php">Login here</a>.*</p>
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
                Credit: PHP MySQL Login System with help from Tutorial Republic<br>
            </cite>
        </p>
        <p class="info-link"><a href="homePage.php">About Us</a></p>
    </footer>
</body>

</html>