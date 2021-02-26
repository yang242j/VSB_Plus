function fetchCourseJSON(id,password) {
    return $.post('Model/takenClass.php', { sid: id , password: password}, function (data) {});
}
fetchCourseJSON(200362586, 200362586);