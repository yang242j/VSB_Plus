var studentData;
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
       window.studentData = 1;      
    });
}
console.log(window.studentData);
window.onload = function init() {
    /*fetchCourseJSON(200362586,returnData);
    console.log(window.studentData);*/
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}