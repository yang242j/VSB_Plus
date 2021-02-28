var studentData;
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        studentData = data;
        console.log(data);
     });
}

window.onload = function init() {
    fetchCourseJSON("200362586");
    getSid();
}
function getSid(){
alert("dasdas");
document.getElementById("userId").innerHTML = "Esad";
}
