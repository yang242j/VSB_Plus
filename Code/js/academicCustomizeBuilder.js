var studentData;
var studentId;
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        console.log(data);
        return data;
    });
}
fetchCourseJSON(200362586);
console.log(getSid());
window.onload = function init() {
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}