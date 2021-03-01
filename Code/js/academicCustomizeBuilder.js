var studentData;
var courseReqData;
//fetch JSON data from takenClass database
function fetchCourseJSON(sid) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        btnForCourse(data);
        showCourses(data);
        //console.log(data);
    });
}
getTermData();
window.onload = function init() {
    fetchCourseJSON(getSid());
}
// get student ID form academac_builder
function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
// get faculty needed course
function getTermData() {
    var myRequest = new XMLHttpRequest;
    var faculty = "ESE";
    var url = "JSON/reqCourse/" + faculty + "_req.json";
    myRequest.open("GET", url, false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        courseReqData = data;
    }
    myRequest.send();
}
// next page button
//minus taken class from all course list
function findCourseToTake(data) {
    /*console.log(data);
    console.log(courseReqData);*/
    var courseCompleted = [];
    var courseToTake = [];
    var courseNotCompleted = [];
    //console.log(data);
    //console.log(data[2]);
    for (i = 0; i < data.length; i++) {
        if (data[i] == null) {
            return;
        }
        else courseCompleted[i] = data[i].course_ID;;
    }
    //console.log(courseCompleted);
    //console.log(courseReqData);
    for (term in courseReqData) {
        for (i = 0; i < courseReqData[term].length; i++) {
            if (courseReqData[term][i] != "Approved") {
                courseToTake.push(courseReqData[term][i]);
            }
        }
    }
    //console.log(courseToTake);
    // minus taken class from all course list
    var courseNotCompleted = courseToTake.filter(function (n) {
        return courseCompleted.indexOf(n) === -1;
    });
    return courseNotCompleted;
}
function showCourses(data) {
    var dataJSON = JSON.parse(data);
    var notCompletedData = findCourseToTake(dataJSON);

    for (i = 0; i < dataJSON.length; i++) {
        if (dataJSON[i].final_grade == "NP" || dataJSON[i].final_grade == "W") {
            delete dataJSON[i];
        }
    }
    //dataJSON.sort();
    //console.log(dataJSON);
    dataJSON.sort();
    //console.log(dataJSON);
    console.log(notCompletedData);
    for (i = 0; i < 12; i++) {
        document.getElementById("ct" + i).innerHTML = " ";
        document.getElementById("nct" + i).innerHTML = " ";
    }

    for (i = 0; i < 12; i++) {
        if (i < dataJSON.length) {
            document.getElementById("ct" + i).innerHTML = dataJSON[i].course_ID;
        }
        else
            return;
    }

    for (i = 0; i < 12; i++) {
        if (i < notCompletedData.length) {
            document.getElementById("nct" + i).innerHTML = notCompletedData[i];
        }
        else {
            return;
        }
    }

}
function btnForCourse(data) {
    var ctRight = document.getElementById("ctRight");
    var ctLeft = document.getElementById("ctLeft");

    var nctRight = document.getElementById("nctRight");
    var nctLeft = document.getElementById("nctLeft");

    var completedData = JSON.parse(data);
    var dataJSON = JSON.parse(data);
    var notCompletedData = findCourseToTake(dataJSON);
    var counterForCompleted = 0;
    var counterForNotCompleted = 0;
    console.log(notCompletedData);
    // delete NP and W data
    for (i = 0; i < completedData.length; i++) {
        if (completedData[i].final_grade == "NP") {
            delete completedData[i];
        }
    }
    completedData.sort();

    ctRight.onclick = function () {

        counterForCompleted += 1;
        if (12 * counterForCompleted > completedData.length) return;

        if (i + 12 * counterForCompleted < completedData.length) {
            for (i = 0; i < 12; i++) {
                document.getElementById("ct" + i).innerHTML = " ";
            }
        }
        if (counterForCompleted >= 0) {
            for (i = 0; i < 12; i++) {
                if (completedData[i + 12 * counterForCompleted].course_ID == null) {
                    return;
                }
                else {
                    document.getElementById("ct" + i).innerHTML = completedData[i + 12 * counterForCompleted].course_ID;
                }
            }
        }

    }
    ctLeft.onclick = function () {
        counterForCompleted -= 1;
        
        if (counterForCompleted >= 0) {
            if (i + 12 * counterForCompleted < completedData.length) {
                for (i = 0; i < 12; i++) {
                    document.getElementById("ct" + i).innerHTML = " ";
                }
            }
            if (counterForCompleted >= 0) {
                for (i = 0; i < 12; i++) {
                    if (completedData[i + 12 * counterForCompleted].course_ID == null) {
                        return;
                    }
                    else {
                        document.getElementById("ct" + i).innerHTML = completedData[i + 12 * counterForCompleted].course_ID;
                    }
                }
            }
        }
        else
            counterForCompleted = 1;
    }

   nctRight.onclick = function () {
        counterForNotCompleted += 1;
        alert("dasdasdas");
        document.getElementById("nct0").innerHTML = "asdas ";
        if (i + 12 * counterForCompleted < notCompletedData.length) {
            for (i = 0; i < 12; i++) {
                document.getElementById("nct" + i).innerHTML = " ";
            }
        }
        if (counterForCompleted >= 0) {
            for (i = 0; i < 12; i++) {
                if (notCompletedData[i + 12 * counterForCompleted]== null) {
                    return;
                }
                else {
                    document.getElementById("nct" + i).innerHTML = notCompletedData[i + 12 * counterForCompleted];
                }
            }
        }


    }
    nctLeft.onclick = function () {
        counterForNotCompleted -= 1;

        if (i + 12 * counterForCompleted < notCompletedData.length) {
            for (i = 0; i < 12; i++) {
                document.getElementById("nct" + i).innerHTML = " ";
            }
        }
        if (counterForCompleted >= 0) {
            for (i = 0; i < 12; i++) {
                if (notCompletedData[i + 12 * counterForCompleted] == null) {
                    return;
                }
                else {
                    document.getElementById("nct" + i).innerHTML = notCompletedData[i + 12 * counterForCompleted];
                }
            }
        }

    }
}