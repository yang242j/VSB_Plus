var studentData ;
var studentId;
function fetchCourseJSON(sid) {
    // alert(sid);
    return $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        //console.log(data);
    });
}

window.onload = function init() {
    studentId = getSid();
    console.log(fetchCourseJSON(studentId));
}
console.log(studentId);
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function showCompletedCourse(){


}
