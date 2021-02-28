var studentData;
function fetchCourseJSON(sid) {
    // alert(sid);
   return $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
           
    });
}

window.onload = function init() {
    fetchCourseJSON(200362582).done(function(result1) {
        var course_json = JSON.parse(result1);
        console.log(course_json);
    });
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}