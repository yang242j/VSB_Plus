var studentData;
function fetchCourseJSON(sid) {
    // alert(sid);
   $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
       test(data);
           
    });
}

window.onload = function init() { 
    fetchCourseJSON(getSid());
}
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function test(data){
    var btn = doeument.getElementById("p1").innerHTML = "asdas";
}