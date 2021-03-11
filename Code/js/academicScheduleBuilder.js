var courseData;
var termData;
window.onload = function () {
    showNotCompletedCourse();
    showApprovedCourse();
    showTerm(1);
}
getCourseData();
getTermData();

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