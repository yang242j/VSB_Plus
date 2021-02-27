
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        console.log(data);
     });
}
window.onload = function init() {
    fetchCourseJSON("200362586");
}
// document.getElementById('course_cards_builder').innerHTML = "ENSE";