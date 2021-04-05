# Code Review Report

Table of Contents
  
- [Code Review Report](#code-review-report)
- [Introdcution](#introdcution)
- [Code Quality Review](#code-quality-review)
  - [Code Formatting](#code-formatting)
  - [Architecture](#architecture)
  - [Coding best practices](#coding-best-practices)
    - [No hardcoding](#no-hardcoding)
    - [Comments](#comments)
    - [Avoid multiple if/else blocks](#avoid-multiple-ifelse-blocks)
  - [Non Functional requirements](#non-functional-requirements)
  - [Object-Oriented Analysis and Design (OOAD) Principles](#object-oriented-analysis-and-design-ooad-principles)
- [Conclusion](#conclusion)

# Introdcution
&nbsp;&nbsp; This code quality report is created after the first MVP is done. The purpose of this document is to imporve the qulity of our code and it is very essential for the success of coding projects and has enableed us to become a more skilled developer.
There are some reasons for why we find that code review to be essential for a coding project.
- Consistent design and development
- Improve the code quility and performance
- Minimize the mistakes and its impact
- Meetting the requirement
# Code Quality Review
## Code Formatting
* Alignment: 
  When we are coding ,we installed some formatters in Vscode, so we can make sure that our alignment is keeping consistent through all files including HTML/CSS/JS/PHP.
* Naming Conventions: 
  ALL the names through our files are use Pascal and CamelCase.

Pascal Example:
``` php
$data = [
            "short_name" => $row['short_name'],
            "title" => $row["title"],
            "faculty" => $row["faculty"],
            "course_num" => $row["course_num"],
            "credit" => $row["credit"],
            "description" => $row["description"],
            "prerequisite" => $row["prerequisite"],
            "preExpression" => $row["preExpression"],
            "preExpression_v2" => $row["preExpression_v2"],
        ];
```
CamelCase Example:
```php
$doneList = isset($_REQUEST["doneList"])? json_decode($_REQUEST["doneList"], true): '';
$major = isset($_REQUEST["major"]) ? $_REQUEST["major"] : '';
$maxNum = isset($_REQUEST["maxNum"]) ? $_REQUEST["maxNum"] : '';
$totalCredit = isset($_REQUEST["totalCredit"]) ? $_REQUEST["totalCredit"] : '';
```
* Code Views
  After browsering all files in a 13 inch laptop, we believe our code should fit in the standard 14 inch screen. There are no need to scroll horizontally to view our code. 
## Architecture


<pre>
.Code
├── Controller
├── css
├── html
├── img
├── js
├── JSON
├── model
├── Python
├── RestPHP
├── View
├── academicBuilder_Builder.php
├── academicBuilder_Default.php
├── academicBuilder_Main.php
├── Api.php
├── courseDB.php
├── homePage.php
├── login.php
├── reset-password.php
├── semesterBuilder_v2.php
├── semesterBuilder.php
└── signup.php
</pre>



All the code is spilt into different directory accounding to their format and purpose.For example,all style files are under <mark>/css</mark>, all back-end database-required file are under <mark>/model</mark>.
For example:


All the code is spilt into different directory accounding to their format and purpose.For example,all style files are under <mark>/css</mark>, all back-end database-required file are under <mark>/model</mark>.
For example:

<pre>
.css
├── academicBuilder_Customize.css
├── academicBuilder_Default.css
├── academicBuilder_main.css
├── academicBuilder.css
├── academicBuilderCompleteCourseTable.css
├── academicBuilderNCDetail.css
├── academicBuilderTermDetail.css
├── canlendar.css
├── courseDB.css
├── homePage.css
├── logIn-signUp.css
├── main.css
└── semester.css
</pre>
<pre>
.model
├── allcourse.php
├── course_db_config.php
├── course.php
├── courseREC_v2.php
├── courseREC.php
├── courseRegStatus_v2.php
├── courseRegStatus.php
├── logout.php
├── section.php
├── sign_in.php
├── takenClass.php
├── test.php
└── vsbp_db_config.php
</pre>
Some important components explain:
* <mark>/controller</mark>
  Controller is used to map data form database, so we are able to change database from one client to another easily.
*  <mark>/model</mark>
  Obtain data from database.
  for example:
  ```php
  define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'vsbp');
define('DB_NAME', 'course');

/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn === false) {
    die("ERROR! Connection FAILED: " . mysqli_connect_error());
} else {
    $conn_message =
        "<script>
    console.log( 'DB_SERVER: " .
        DB_SERVER .
        "');
    console.log( 'DB_NAME: " .
        DB_NAME .
        "');
    </script>";
    //echo $conn_message;
}
  ```
*  <mark>/JSON</mark>
  Store the data form database.
 *  <mark>/js</mark>
  It contians all the front-end javascript file.All needed data are gathered in <mark>/JSON</mark> and <mark>/model</mark>, so it can be directly used in js file.
  for example:
  ```javaScript
  function fetchCourseJSON(sid, password) {
    $.post('Model/takenClass.php', {
        sid: sid,
        password: password
    }, function (data) {
        btnForCourse(data);
        showCourses(data);
        getCreditsEarned(data);
        storePassedCourse(data);
        clickGetInfo();
    });
}
function getAllCourse() {
    var myRequest = new XMLHttpRequest;
    myRequest.open("GET", "JSON/ALL.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        allCourseData = data;
    }
    myRequest.send();
}
  ```
*  <mark>/Python</mark>
   It contains all python we used, inculding crawling data from University of Regina wabsite and our a test phase.



Overall, the architecture can meet our design map and requirement.This file tree can help us locate the aim file very quickly when we need. However, some imporvements still needed:
* Format of directory name is not consistent
* Naming conventions is not consistent
* View directory is not clear
* All php file used in front-end (such as homePage.php)should be in one package
## Coding best practices
### No hardcoding
Using the user information such as id, password, faculty to grab data, not just hard code their faculty or information.
```php
$_SESSION["loggedin"] = true;
$_SESSION["sid"] = $studentid;
$_SESSION["password"] = $password;
$_SESSION["name"] = $name;
$_SESSION["major"] = $major;
$_SESSION["totalCredit"] = $totalCredit;
$_SESSION["lastActTime"] = time();
```

```javaScript
getTermData(major);
function getTermData(faculty) {
    var myRequest = new XMLHttpRequest;
    var facultyName = faculty;
    var url = "JSON/" + facultyName + ".json";
    myRequest.open("GET", url, false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        courseReqData = data;
    }
    myRequest.send();
}
```
### Comments
Write instroction for each file and also inline comments.
```php
/**
 * The database visualization page embeded with search and filter function.
 *
 * Requirments:
 *  1) User should be able to search the course info by entering course short name (course id).
 *  2) User should be able to filter the desired courses by faculty and year of course.
 *  3) User should be able to swap the display between large course card and small course card.
 *  4) For the most area of the screen right hand side, display the selected course detail information.
 *  5) Course details info should contains the name, prerequisites, description, course general opening status of each section.
 *  6) May also contain the lab info.
 *
 * php Steps:
 *  1) Start session.
 *  2) If logged in, display logged in user info at navigation right.
 *  3) If not logged in, display login and signup button at navigation right.
 *  4) Guest can have full functionality of this page.
 *  5) Other pages are either hidden or disabled for guest.
 *
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/courseDB.php
 * @author      Xinyu Liu (sid: 200362878) <liu725@uregina.ca>
 * @param       {boolean}       $_SESSION["loggedin"]       Status of logged-in or not: true/false
 * @param       {integer}       $_SESSION["sid"]            Student id
 * @param       {string}        $_SESSION["name"]           Student name
 */  
```
### Avoid multiple if/else blocks

## Non Functional requirements
## Object-Oriented Analysis and Design (OOAD) Principles
# Conclusion
