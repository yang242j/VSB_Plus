var studentData;
var courseReqData;
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        test(data);
        showCourses(data);
    });
}
getTermData();
window.onload = function init() {
    fetchCourseJSON(getSid());
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function getTermData() {
    var myRequest = new XMLHttpRequest;
    var faculty = "ESE";
    var url = "JSON/reqCourse/" + faculty + "_req.json";
    myRequest.open("GET", url, false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        courseReqData = data;
        console.log(termData);
    }
    myRequest.send();
}

function test(data) {
    var btn = document.getElementById("p1");
    var dataJSON = JSON.parse(data);
    //console.log(dataJSON);
    btn.onclick = function () {
       console.log(dataJSON[0]);
    }
}
function showCourses(data) {
    var dataJSON = JSON.parse(data);
    for (i = 0; i < 12; i++) {
        if (i < dataJSON.length) {
        document.getElementById("ct" + i).innerHTML = dataJSON[i].course_ID;
        }
        else{
        document.getElementById("ct" + i).innerHTML = " ";
        }

        
    }

}