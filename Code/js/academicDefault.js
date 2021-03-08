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
function getTitle(courseName) {
    var pre = "Title: </br>" ;
    for (i = 0; i < allCourseData.length; i++) {
        if (allCourseData[i].short_name == courseName && allCourseData[i].title != null)
            return (pre + allCourseData[i].title);
    }
    return (pre + "no such course or no prerequisite");
}
console.log(getTitle("CHEM 140"));
function getCourseData() {
    var myRequest = new XMLHttpRequest;
    //myRequest.open("GET", "JSON/ESE.json", false);
    myRequest.open("GET", "JSON/SSE.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        courseData = data;
    }
    myRequest.send();
}
function getTermData() {
    var myRequest = new XMLHttpRequest;
    //myRequest.open("GET", "JSON/reqCourse/ESE_req.json", false);
    myRequest.open("GET", "JSON/reqCourse/SSE_req.json", false);
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

function showNotCompletedElectivesCourse() {
    for (i = 0; i < 12; i++) {
        document.getElementById("enct" + i).innerHTML = courseData[i].short_name;
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
            if(courseData[i] == null)return;
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

var ecounter = 0;
function enctLeft() {
    ecounter = ecounter - 1;
    z = 0;
    /*document.getElementById("notCompletedLeft").innerHTML = counter;*/
    if (ecounter >= 0) {
        for (x = 0; x < 12; x++) {
            document.getElementById("enct" + x).innerHTML = "";
        }

        for (x = 12 * ecounter; x < 12 * (ecounter + 1); x++) {
            if (x > courseData.length) {
                document.getElementById("enct" + z).innerHTML = " "; 
            }
            else {
                document.getElementById("enct" + z).innerHTML = courseData[x].short_name;
            }
            z = z + 1;
        }
    }
    else {
        ecounter = 1;
    }
}
function enctRight() {
    y = 0;
    if (courseData[x].short_name != null){
    ecounter +=1;
    }
    /*document.getElementById("notCompletedRight").innerHTML = counter;*/
    if (ecounter >= 0) {
        for (x = 0; x < 12; x++) {
            document.getElementById("enct" + x).innerHTML = "";
        }
        for (x = 12 * ecounter; x < 12 * (ecounter + 1); x++) {
            if(courseData[x] == null)return;
            if (x > courseData.length) {
                document.getElementById("enct" + y).innerHTML = " ";
            }
            else {
                document.getElementById("enct" + y).innerHTML = courseData[x].short_name;
            }
            y = y + 1;
        }
    }
    else {
        ecounter = 1;
    }
}

function showTerm(pageNumber) {
    var i = 1;
    for (term in termData) {
        /*console.log(termData[term][0]);*/
        termNumber = "term" + pageNumber;
        if (term >= termNumber){
        if (term != "Approved") {
            /*if (i <= 4) {*/
            if (i <= 10) {
                /*if(pageNumber < 7) {*/
                if(pageNumber < 10) {
                document.getElementById("term" + i).innerHTML =
                    "<div class = 'tittle'>" + "<h2>" + term + ":" + "</h2></div>" +
                    "<div class = 'course_cards'>" + "<h3>" + termData[term][0] + "</h3>" +
                    "<p'>"+ getTitle(termData[term][0])+ "</p>"+
                    /*"<i class='fas fa-circle' id = 'circle1' style='font-size:24px;'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/ "</div>"+
                    

                   "<div class = 'course_cards'>" + "<h3>" + termData[term][1] + "</h3>" +
                   "<p>"+ getTitle(termData[term][1])+"</p>"+
                   /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/ "</div>"+

                    "<div class = 'course_cards'>" + "<h3>" + termData[term][2] + "</h3>" +
                    "<p>"+ getTitle(termData[term][2])+ "</p>"+
                   /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/ "</div>"+

                    "<div class = 'course_cards'>" + "<h3>" + termData[term][3] + "</h3>" +
                    "<p>"+ getTitle(termData[term][3])+ "</p>"+
                   /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                    "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/ "</div>"+

                    "<div class = 'course_cards'>" + "<h3>" + termData[term][4] + "</h3>"+
                    "<p>"+ getTitle(termData[term][4])+ "</p>"+
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

function getTermInfo(courseName) {
    var myRequest = new XMLHttpRequest;
    var myRequest2 = new XMLHttpRequest;
    var myRequest3 = new XMLHttpRequest;
    var term = "Applied Term: ";
    var prerequisite = "Prerequisite: </br>";
    var credit;
    url2 = "JSON/202020/" + courseName + ".json";
    url3 = "JSON/202030/" + courseName + ".json";
    url1 = "JSON/202110/" + courseName + ".json";

    //check does the file exit in the path
    // See if the file exists
    myRequest3.open("GET", url1, false);
    myRequest3.onload = function () {
        if (myRequest3.status == 200 && myRequest3.responseText != null) {
            var data = JSON.parse(myRequest3.responseText);
            prerequisite += data.prerequisite;
            credit = data.credit;
            if (data.term != "No class for the term") {
                term += "Winter" + " ";

            }
        }
    }
    myRequest3.send();
    /*if(myRequest3.status == 404){
        return null;
    }*/



    myRequest.open("GET", url2, false);
    myRequest.onload = function () {
        if (myRequest.status == 200 && myRequest.responseText != null) {
            var data = JSON.parse(myRequest.responseText);
            if (data.term != "No class for the term") {
                term += "Spring/Summer" + " ";

            }
        }

    }

    myRequest.send();

    myRequest2.open("GET", url3, false);
    myRequest2.onload = function () {
        if (myRequest2.status == 200 && myRequest2.responseText != null) {
            var data = JSON.parse(myRequest2.responseText);
            if (data.term != "No class for the term") {
                term += "Fall" + " ";

            }
        }

    }
    myRequest2.send();


    return [term, credit, prerequisite];
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
