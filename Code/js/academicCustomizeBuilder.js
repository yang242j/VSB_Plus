var studentData;
var studentId;
function fetchCourseJSON(sid, callback) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        /*console.log(data);*/
        callback(data);
       
    });
}
window.onload = function init() {
    fetchCourseJSON(200362586,returnData);
    console.log(studentData);
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function returnData(data){
   /*console.log(data);*/
   studentData = data;
}