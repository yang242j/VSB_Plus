var studentData;
var studentId;
function fetchCourseJSON(sid) {
    // alert(sid);
    return $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        /*console.log(data);*/
        window.studentData = data;
    });
}

window.onload = function init() {
    window.studentId = getSid();
    console.log(window.studentId);
}
fetchCourseJSON("200362586");
console.log(window.studentData);
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function showCompletedCourse() {


}
