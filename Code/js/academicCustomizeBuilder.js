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
}
alert("dasdas");
//document.getElementById("usertext").innerHTML = "Esad";
