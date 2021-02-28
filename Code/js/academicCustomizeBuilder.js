var studentData;
function fetchCourseJSON(sid) {
    // alert(sid);
    var temp;
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        /*console.log(data);*/
       temp =data;
    });
    console.log(temp);
    return temp;
}
fetchCourseJSON(200362586);
window.onload = function init() {
    /*fetchCourseJSON(200362586,returnData);
    console.log(window.studentData);*/
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}

