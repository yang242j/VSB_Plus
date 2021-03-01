var studentData;
var courseReqData;
//fetch JSON data from takenClass database
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        btnForCourse(data);
        showCourses(data);
    });
}
getTermData();
window.onload = function init() {
    fetchCourseJSON(getSid());
}
// get student ID form academac_builder
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
// get faculty needed course
function getTermData() {
    var myRequest = new XMLHttpRequest;
    var faculty = "ESE";
    var url = "JSON/reqCourse/" + faculty + "_req.json";
    myRequest.open("GET", url, false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        courseReqData = data;
    }
    myRequest.send();
}
// next page button
//minus taken class from all course list
function findCourseToTake(data) {
    /*console.log(data);
    console.log(courseReqData);*/
    var courseCompleted = [];
    var courseToTake = [];
    var courseNotCompleted = [];
    for (i = 0; i < data.length; i++) {
        courseCompleted[i] = data[i].course_ID;
    }
    //console.log(courseCompleted);
    //console.log(courseReqData);
    for (term in courseReqData) {
        for (i = 0; i < courseReqData[term].length; i++) {
            if (courseReqData[term][i] != "Approved") {
                courseToTake.push(courseReqData[term][i]);
            }
        }
    }
    //console.log(courseToTake);
    // minus taken class from all course list
    var courseNotCompleted = courseToTake.filter(function (n) {
        return courseCompleted.indexOf(n) === -1;
    });
    return courseNotCompleted;
}


function showCourses(data) {
    var dataJSON = JSON.parse(data);
    var notCompletedData = findCourseToTake(dataJSON);
    /*console.log(notCompletedData);*/
    for (i = 0; i < 12; i++) {
        if (i < dataJSON.length) {
            document.getElementById("ct" + i).innerHTML = dataJSON[i].course_ID;
        }
        else {
            document.getElementById("ct" + i).innerHTML = " ";
        }
    }
    for (i = 0; i < 12; i++) {
        if (i < notCompletedData.length) {
            document.getElementById("nct" + i).innerHTML = notCompletedData[i];
        }
        else {
            document.getElementById("nct" + i).innerHTML = " ";
        }
    }

}
function btnForCourse(data) {
    var ctRight = document.getElementById("ctRight");
    var ctLeft = document.getElementById("ctLeft");
    var nctRight = document.getElementById("nctRight");
    var nctLeft = document.getElementById("nctLeft");
    var completedData = JSON.parse(data);
    var notCompletedData = findCourseToTake(completedData);

    var counterForCompleted = 0;
    var counterForNotCompleted = 0;
  console.log(completedData);
    ctRight.onclick = function () {
        var i = 0;
        if (completedData[i + 12 * counterForCompleted].course_ID != null) {
            counterForCompleted += 1;
        }
        if(i + 12 * counterForCompleted < completedData.length){}
        for (i = 0; i < 12; i++) {
        document.getElementById("ct" + i).innerHTML = " ";
        }
    }
        if (counterForCompleted >= 0) {
            for (i = 0; i < 12; i++) {
                if (completedData[i + 12 * counterForCompleted].course_ID != null){
                document.getElementById("ct" + i).innerHTML = completedData[i + 12 * counterForCompleted].course_ID;
                }
                else{
                    if(i + 12 * counterForCompleted >completedData.length)return;
                }
            }
        }

    }
    ctLeft.onclick = function () {

    }

    nctRight.onclick = function () {

    }
    nctLeft.onclick = function () {

    }
}