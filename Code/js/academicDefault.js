const colors = ["red", "yellow", "blue", "purple", "plum", "black"];
var courseData;
var termData;
var allCourse;
window.onload = function () {
    showNotCompletedCourse();
    showApprovedCourse();
    showTerm(1);
}
getCourseData();
getTermData();
getAllCourse();
function getAllCourse() {
    var myRequest = new XMLHttpRequest;
    myRequest.open("GET", "JSON/ALL.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        allCourseData = data;
    }
    myRequest.send();
}
function getDescription(courseName) {
    var pre = "Description: ";
    for (i = 0; i < allCourseData.length; i++) {
        if (allCourseData[i].short_name == courseName && allCourseData[i].description != null)
            return (pre + allCourseData[i].description);
    }
    return (pre + "no such course or no prerequisite");
}
console.log(getDescription("CHEM 140"));
function getCourseData() {
    var myRequest = new XMLHttpRequest;
    myRequest.open("GET", "JSON/ESE.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        courseData = data;
    }
    myRequest.send();
}
function getTermData() {
    var myRequest = new XMLHttpRequest;
    myRequest.open("GET", "JSON/reqCourse/ESE_req.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        termData = data;
        console.log(termData);
    }
    myRequest.send();
}
function showNotCompletedCourse() {
    for (i = 0; i < 12; i++) {
        document.getElementById("nct" + i).innerHTML = courseData[i].short_name;
    }
}

function showApprovedCourse() {
    for (term in termData) {
        if (term = "Approved") {
            for (i = 0; i < 12; i++) {
                document.getElementById("ct" + i).innerHTML = termData[term][i];
            }
        }
    }

}
var counterForApproved = 0;
function aRight() {
    if(termData[term][i+12*counterForApproved] != null){
    counterForApproved += 1;
    }
    if (counterForApproved >= 0) {
        for (i = 0; i < 12; i++) {
            document.getElementById("ct" + i).innerHTML = "";
        }
        for (term in termData) {
            if (term = "Approved") {
                for (i = 0; i < 12; i++) {
                    if(termData[term][i+12*counterForApproved] != null){
                    document.getElementById("ct" + i).innerHTML = termData[term][i+12*counterForApproved];
                    }
                    else{
                        return;
                    }                  
                }
            }

        }
    }
    else {
        counterForApproved = 1;
    }
}
function aLeft() {
    counterForApproved -= 1
    if (counterForApproved >= 0) {
        for (i = 0; i < 12; i++) {
            document.getElementById("ct" + i).innerHTML = "";
        }
        for (term in termData) {
            if (term = "Approved") {
                for (i = 0; i < 12; i++) {
                    if(termData[term][i+12*counterForApproved] != null){
                    document.getElementById("ct" + i).innerHTML = termData[term][i+12*counterForApproved];
                    }
                    else{
                        return;
                    }                  
                }
            }
        }
    }
    else {
        counterForApproved = 1;
    }
}
var counter = 0;
function nctLeft() {
    counter = counter - 1;
    k = 0;
    /*document.getElementById("notCompletedLeft").innerHTML = counter;*/
    if (counter >= 0) {
        for (i = 0; i < 12; i++) {
            document.getElementById("nct" + i).innerHTML = "";
        }

        for (i = 12 * counter; i < 12 * (counter + 1); i++) {
            if (i > courseData.length) {
                document.getElementById("nct" + k).innerHTML = " "; 
            }
            else {
                document.getElementById("nct" + k).innerHTML = courseData[i].short_name;
            }
            k = k + 1;
        }
    }
    else {
        counter = 1;
    }
}
function nctRight() {
    j = 0;
    if (courseData[i].short_name != null){
    counter +=1;
    }
    /*document.getElementById("notCompletedRight").innerHTML = counter;*/
    if (counter >= 0) {
        for (i = 0; i < 12; i++) {
            document.getElementById("nct" + i).innerHTML = "";
        }
        for (i = 12 * counter; i < 12 * (counter + 1); i++) {
            if (i > courseData.length) {
                document.getElementById("nct" + j).innerHTML = " ";
            }
            else {
                document.getElementById("nct" + j).innerHTML = courseData[i].short_name;
            }
            j = j + 1;
        }
    }
    else {
        counter = 1;
    }
}

function showTerm(pageNumber) {
    var i = 1;
    for (term in termData) {
        /*console.log(termData[term][0]);*/
        termNumber = "term" + pageNumber;
        if (term >= termNumber){
        if (term != "Approved") {
            if (i <= 4) {
                if(pageNumber < 7){        
                document.getElementById("term" + i).innerHTML =
                    "<div class = 'tittle'>" + "<h2>" + term + ":" + "</h2></div>" +
                    "<div class = 'course_cards'>" + "<h3>" + termData[term][0] + "</h3>" +
                    "<p font-size = '10px'>"+ getDescription(termData[term][0])+ "</p>"+
                    /*"<i class='fas fa-circle' id = 'circle1' style='font-size:24px;'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/ "</div>"+
                    

                   "<div class = 'course_cards'>" + "<h3>" + termData[term][1] + "</h3>" +
                   "<p>"+ getDescription(termData[term][0])+ "</p>"+
                   /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/ "</div>"+

                    "<div class = 'course_cards'>" + "<h3>" + termData[term][2] + "</h3>" +
                    "<p>"+ getDescription(termData[term][0])+ "</p>"+
                   /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/ "</div>"+

                    "<div class = 'course_cards'>" + "<h3>" + termData[term][3] + "</h3>" +
                    "<p>"+ getDescription(termData[term][0])+ "</p>"+
                   /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/ "</div>"+

                    "<div class = 'course_cards'>" + "<h3>" + termData[term][4] + "</h3>"+
                    "<p>"+ getDescription(termData[term][0])+ "</p>"+
                 /*  "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:yellow'></i>*/ "</div>";
                i = i + 1;
                }
            }
        }
    }
    }
}
var termPageCounter = 1 ;
function termDown(){
    termPageCounter +=1;
    if (termPageCounter <= 6){
    showTerm(termPageCounter);
    }
    else {
        termPageCounter = 6 ;
    }

}
function termUp(){
    termPageCounter -=1;
    if(termPageCounter >= 1){
    showTerm(termPageCounter);
    }
    else{
        termPageCounter = 1 ;
    }
}