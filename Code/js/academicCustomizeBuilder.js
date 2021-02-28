var studentData;
var studentId;
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        /*console.log(data);*/
        return data;
    });
}

window.onload = function init() {
    studentId = getSid();
    studentData = fetchCourseJSON(studentId);
    console.log(studentData);
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function showCompletedCourse(){





}
