var summary = {
    "name":"",
    "sid" : "",
    "program" : "",
    "major" : major,
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
    loadPieChart(sid, pas);
    loadLineChart(sid, pas);
    console.log("init web");
    setDefault(sid);
    setCmptedValue(sid);
}

function loadPieChart(sid, pas) {
    // console.log(sid);
    $.post('Model/takenClass.php', { "sid": sid, "password": pas }, function (data) {
        console.log(data);
        var jsonData = JSON.parse(data);
        var divId = 'pieChart';
        genChart1(jsonData, divId);
    });
}

function loadLineChart(sid, pas) {
    $.post('Model/takenClass.php', { "sid": sid, "password": pas }, function (data) {
        console.log(data);
        var jsonData = JSON.parse(data);
        var divId = 'lineChart';
        genChart2(jsonData, divId);
    });
}

function setDefault(sid){
    // console.log(GetUrlRelativePath());
    $.post('./Api.php/Student/BasicInfo', {'sid': sid}, function(data){
        // console.log("data is ", data)
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
        var years = [];
        // console.log(jsonData);
        for (var key in jsonData){
            // For computing the which years that student in
            var year = parseInt(jsonData[key].term);
            years.push(year);
            
            // Compiting the averages, learned credits, pass course count.
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

        // Get the year that student in.
        yearMin = Math.min.apply(null, years);
        yearMax = Math.max.apply(null, years);
        cmpValue.year = yearMax - yearMin + 1;

        // Refresh the summary borad
        pageDown();
    });   
}


　function GetUrlRelativePath()
　　{
　　　　var url = document.location.toString();
　　　　var arrUrl = url.split("//");

　　　　var start = arrUrl[1].indexOf("/");
　　　　var relUrl = arrUrl[1].substring(start);//stop省略，截取从start开始到结尾的所有字符

　　　　if(relUrl.indexOf("?") != -1){
　　　　　　relUrl = relUrl.split("?")[0];
　　　　}
　　　　return relUrl;
　　}