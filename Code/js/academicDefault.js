var termData;
var allCourse;

window.onload = function () {
    showTerm(1);
}

function getTermData() {
    var myRequest = new XMLHttpRequest;
    //myRequest.open("GET", "JSON/reqCourse/ESE_req.json", false);
    myRequest.open("GET", "JSON/reqCourse/SSE_req.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        termData = data;
        console.log(termData);
    }
    myRequest.send();
}
