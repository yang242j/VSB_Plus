var studentData ;
var studentId;
function fetchCourseJSON(sid) {
    // alert(sid);
    return $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        console.log(data);
        window.studentData = data;
    });
}

window.onload = function init() {
    studentId = getSid();
    console.log(window.studentData);
}

console.log(studentId);
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function showCompletedCourse(){


}
