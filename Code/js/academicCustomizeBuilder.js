var studentData;
var studentId;
function fetchCourseJSON(sid) {
    // alert(sid);
    return $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        /*console.log(data);*/
        window.studentData = data;
    });
}
fetchCourseJSON("200362586");
console.log(window.studentData);
window.onload = function init() {
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}