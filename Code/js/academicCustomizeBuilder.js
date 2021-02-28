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
    var btn = document.getElementById("p1");
    var dataJSON = JSON.parse(data);
    console.log(dataJSON);
    btn.onclick = function (){

        console.log(dataJSON[0].course_ID);
    }
}
function showCourses(data){
    var dataJSON = JSON.parse(data);
    for (i =0; i < 12; i++){
document.getElementById("tc"+i).innerHTMl = dataJSON[i].course_ID;
    }

}