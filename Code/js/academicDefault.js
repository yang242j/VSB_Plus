
var courseData;
var termData;
window.onload = function () {
    showNotCompletedCourse();
    showCompletedCourse();
}
getCourseData();
getTermData();

function getCourseData() {
    var myRequest = new XMLHttpRequest;
    myRequest.open("GET", "JSON/ESE.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        courseData = data;
    }
    myRequest.send();
}
function getTermData() {
    var myRequest = new XMLHttpRequest;
    myRequest.open("GET", "JSON/reqCourse/ESE_req.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        termData = data;
        console.log(termData.term1[0]);
    }
    myRequest.send();
}
function showNotCompletedCourse() {
    for (i = 0; i < 12; i++) {
        document.getElementById("nct" + i).innerHTML = courseData[i].short_name;
    }
}

function showCompletedCourse() {
        for (i = 0 ; i <12 ; i++)
        {
        document.getElementById("ct" + i).innerHTML = " ";
        }
    }
var counter = 1;
function nctLeft() {
    counter = counter - 1 ;
    k = 0;
    /*document.getElementById("notCompletedLeft").innerHTML = counter;*/
    if(counter >= 0){
    for (i = 12 * counter; i < 12 * (counter + 1); i++) {
        if(i > courseData.length)
        {
            document.getElementById("nct" + k).innerHTML = " ";ß
        }
        else{
        document.getElementById("nct" + k).innerHTML = courseData[i].short_name;
        }
        k = k + 1;
    }
}
    else{
        counter = 0;
    }
}
function nctRight() {
    j = 0;
    /*document.getElementById("notCompletedRight").innerHTML = counter;*/
    if (counter >= 0){
    for (i = 12 * counter; i < 12 * (counter + 1); i++) {
        if(i > courseData.length)
        {
            document.getElementById("nct" + j).innerHTML = " ";
        }
        else{
        document.getElementById("nct" + j).innerHTML = courseData[i].short_name;
        }
        j = j + 1;
    }
}
else{
     counter = 0;

}
    counter = counter + 1;
}