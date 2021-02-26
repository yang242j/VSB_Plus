
function fetchCourseJSON() {
    alert("asdasdsa");
    /*return $.post('Model/takenClass.php', { sid: 200362586 , password: 200362586}, function (data) {});*/
        return $.post('Model/course.php', { short_name: "CS 110" }, function (data) {});
    }
fetchCourseJSON();