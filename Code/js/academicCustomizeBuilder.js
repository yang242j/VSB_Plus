var studentData;
var studentId;
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        studentData = data;
        console.log(data);
    });
}

window.onload = function init() {
    studentId = getSid();
    studentData = fetchCourseJSON(studentId);
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    alert(sid);
    return sid;
}

