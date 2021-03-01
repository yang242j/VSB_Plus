var summary = {
    "name":"",
    "sid" : "",
    "program" : "",
    "major" : "",
}

var cmpValue = {
    "ave" : "",
    "courseLeft" : "",
    "year" : "",
    "gpa" : "",
    "credit" : "",
}

var reqCourseNum = 46;
var reqCredit = 136;


function pageUp() {
    document.getElementById("card1").innerHTML = "<h3>Major:</h3>" + "<p>" + summary.major + "</p>";
    document.getElementById("card2").innerHTML = "<h3>Year:</h3>" + "<p>" + cmpValue.year + "th</p>";
    document.getElementById("card3").innerHTML = "<h3>Credit Earned:</h3>" + "<p>" + cmpValue.credit + " / "+ reqCredit + "</p>";
    document.getElementById("card4").innerHTML = "<h3>Average</h3>" + "<p>" + cmpValue.ave + "</p>";
}

function pageDown() {
    document.getElementById("card1").innerHTML = "<h3>SID:</h3>" + "<p>" + summary.sid + "</p>";
    document.getElementById("card2").innerHTML = "<h3>Program:</h3>" + "<p>" + summary.program + "</p>";
    document.getElementById("card3").innerHTML = "<h3>Course Left:</h3>" + "<p>" + cmpValue.courseLeft + " / "+reqCourseNum+"</p>" ;
    document.getElementById("card4").innerHTML = "<h3>GPA:</h3>" + "<p>" + cmpValue.gpa + "</p>";
}

window.onload = function () {
    loadPieChart(sid);
    loadLineChart(sid);
    console.log("init web");
    setDefault(sid);
    setCmptedValue(sid);
}

function loadPieChart(sid) {
    // console.log(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        // console.log(data);
        var jsonData = JSON.parse(data);
        var divId = 'pieChart';
        genChart1(jsonData, divId);
    });
}

function loadLineChart(sid) {
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        var jsonData = JSON.parse(data);
        var divId = 'lineChart';
        genChart2(jsonData, divId);
    });
}

function setDefault(sid){
    $.post('./Api.php/Student/BasicInfo', {'sid': sid}, function(data){
        basicInfo = JSON.parse(data).data;
        summary.name = basicInfo.name;
        summary.sid = basicInfo.student_id;
        summary.program = basicInfo.program;
        summary.major = basicInfo.major;
    });   
}

function setCmptedValue(sid){
    $.post('./Api.php/Student/TakenCourse', {'sid': sid}, function(data){
        var jsonData = JSON.parse(data).data;
        var sumGrade = 0;
        var passCount = 0;
        var totalCredit = 0;
        // console.log(jsonData);
        for (var key in jsonData){
            var grade = parseInt(jsonData[key].final_grade);
            var earnedCredit = parseInt(jsonData[key].credit_earned);
            if(!isNaN(grade)){
                sumGrade += grade;
                passCount += 1;
                totalCredit += earnedCredit;
            }
        }
        cmpValue.ave = (sumGrade / passCount).toFixed(1);
        cmpValue.courseLeft = reqCourseNum - passCount;
        cmpValue.credit = totalCredit;
        cmpValue.gpa = (4 * cmpValue.ave / 100.0).toFixed(1);
        cmpValue.year = parseInt(4 * totalCredit / reqCredit);
        pageDown();
    });   
}