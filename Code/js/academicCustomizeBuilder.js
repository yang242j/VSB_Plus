var studentData;
var studentId;
function fetchCourseJSON(sid, callback) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        /*console.log(data);*/
        callback(data);
       
    });
}
studentData = fetchCourseJSON(200362586,returnData);
console.log(studentData);
window.onload = function init() {
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function returnData(data){
   return data;
}