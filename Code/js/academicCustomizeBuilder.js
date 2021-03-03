var studentData;
var courseReqData;
var allCourseData;
//fetch JSON data from takenClass database
function fetchCourseJSON(sid, password) {
    // alert(sid);
    $.post('Model/takenClass.php', { sid: sid, password: password }, function (data) {
        btnForCourse(data);
        showCourses(data);
        //console.log(data);
    });
}

getTermData(major);
getAllCourse();
window.onload = function init() {
    fetchCourseJSON(sid, pas);
}
// get student ID form academac_builder
/*function getSid() {
    var sid = document.getElementById("userId").innerHTML;
    return sid;
}
function getPassword() {
    var password = document.getElementById("password").innerHTML;
    return password;
}*/
// get faculty needed course
function getTermData(faculty) {
    var myRequest = new XMLHttpRequest;
    var facultyName = faculty;
    var url = "JSON/reqCourse/" + facultyName + "_req.json";
    myRequest.open("GET", url, false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        courseReqData = data;
    }
    myRequest.send();
}
function getAllCourse() {
    var myRequest = new XMLHttpRequest;
    myRequest.open("GET", "JSON/ALL.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        allCourseData = data;
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
function getColor(index, dataJSON) {
    var color;
    if (dataJSON[index].final_grade == "NP") {
        color = "blue";
    }
    else if (dataJSON[index].final_grade == "W") {
        color = "yellow";
    }
    else if (dataJSON[index].final_grade <= 60) {
        color = "grey";
    }
    else if (dataJSON[index].final_grade > 60) {
        color = "orange";
    }
    else if (dataJSON[index].final_grade > 75) {
        color = "pink";
    }
    else if (dataJSON[index].final_grade > 90) {
        color = "red";
    }
    return color;
}
function showCourses(data) {
    var dataJSON = JSON.parse(data);
    var notCompletedData = findCourseToTake(dataJSON);

    /*for (i = 0; i < dataJSON.length; i++) {
        if (dataJSON[i].final_grade == "NP" || dataJSON[i].final_grade == "W") {
            delete dataJSON[i];
        }
    }
    //dataJSON.sort();
    //console.log(dataJSON);
    dataJSON.sort();*/
    //console.log(dataJSON);
    //console.log(notCompletedData);
    /*console.log(dataJSON);
    console.log(courseReqData);
    console.log(notCompletedData);*/


    for (i = 0; i < 12; i++) {
        document.getElementById("ct" + i).innerHTML = " ";
       // document.getElementById("nct" + i).innerHTML = " ";
    }
    //console.log(dataJSON);
    for (i = 0; i < 12; i++) {
        if (i < dataJSON.length) {
            //<br/>
            document.getElementById("ct" + i).innerHTML = dataJSON[i].course_ID + "<br/> " + dataJSON[i].term;
            document.getElementById("ct" + i).style.color = getColor(i, dataJSON);

        }
        else
            return;
    }
    /* for (i = 0; i < 12; i++) {
         if (i < notCompletedData.length) {
             document.getElementById("nct" + i).innerHTML = notCompletedData[i];
 
         }
         else {
             return;
         }
     }*/

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
    //console.log(notCompletedData);
    // delete NP and W data

    ctRight.onclick = function () {
        if (counterForCompleted <= (completedData.length / 12)) {
            counterForCompleted += 1;
        }
        else return;


        if (i + 12 * counterForCompleted < completedData.length) {
            for (i = 0; i < 12; i++) {
                document.getElementById("ct" + i).innerHTML = " ";
            }
        }
        if (counterForCompleted >= 0) {
            for (i = 0; i < 12; i++) {
                document.getElementById("ct" + i).innerHTML = " ";
            }
            for (i = 0; i < 12; i++) {
                if (completedData[i + 12 * counterForCompleted] == null) {
                    return;
                }
                else {
                    document.getElementById("ct" + i).innerHTML = completedData[i + 12 * counterForCompleted].course_ID + " <br/>" + completedData[i + 12 * counterForCompleted].term;
                    document.getElementById("ct" + i).style.color = getColor(i, dataJSON);
                }
            }
        }
    }
    ctLeft.onclick = function () {
        if (counterForCompleted > 0) {
            counterForCompleted -= 1;
        }
        else return;
        if (i + 12 * counterForCompleted < completedData.length) {
            for (i = 0; i < 12; i++) {
                document.getElementById("ct" + i).innerHTML = " ";
            }
        }
        if (counterForCompleted >= 0) {
            for (i = 0; i < 12; i++) {
                document.getElementById("ct" + i).innerHTML = " ";
            }
            for (i = 0; i < 12; i++) {
                if (completedData[i + 12 * counterForCompleted] == null) {
                    return;
                }
                else {
                    document.getElementById("ct" + i).innerHTML = completedData[i + 12 * counterForCompleted].course_ID + "<br/>" + completedData[i + 12 * counterForCompleted].term;
                    document.getElementById("ct" + i).style.color = getColor(i, dataJSON);
                }
            }
        }
    }

    /* nctRight.onclick = function () {
         if (counterForNotCompleted <= (notCompletedData.length / 12)) {
             counterForNotCompleted += 1;
         }
         else return;
         if (i + 12 * counterForNotCompleted < notCompletedData.length) {
             for (i = 0; i < 12; i++) {
                 document.getElementById("nct" + i).innerHTML = " ";
             }
         }
         if (counterForNotCompleted >= 0) {
             for (i = 0; i < 12; i++) {
                 document.getElementById("nct" + i).innerHTML = " ";
             }
             for (i = 0; i < 12; i++) {
                 if (notCompletedData[i + 12 * counterForNotCompleted] == null) {
                     return;
                 }
                 else {
                     document.getElementById("nct" + i).innerHTML = notCompletedData[i + 12 * counterForNotCompleted];
                 }
             }
         }
     }*/
    /*nctLeft.onclick = function () {
        if (counterForNotCompleted > 0) {
            counterForNotCompleted -= 1;
        }
        else return;

        if (i + 12 * counterForNotCompleted < notCompletedData.length) {
            for (i = 0; i < 12; i++) {
                document.getElementById("nct" + i).innerHTML = " ";
            }
        }
        if (counterForNotCompleted >= 0) {
            for (i = 0; i < 12; i++) {
                document.getElementById("nct" + i).innerHTML = " ";
            }
            for (i = 0; i < 12; i++) {
                if (notCompletedData[i + 12 * counterForNotCompleted] == null) {
                    return;
                }
                else {
                    document.getElementById("nct" + i).innerHTML = notCompletedData[i + 12 * counterForNotCompleted];
                }
            }
        }

    }*/
}

//show terms 
/*function showTerm(data) {
    var dataJSON = JSON.parse(data);
    var term1 = document.getElementById("term1");

    //for (i = 0; i < dataJSON.length; i++) {
         //if (dataJSON[i].final_grade == "NP" || dataJSON[i].final_grade == "W") {
            // delete dataJSON[i];
         //}
     //}
     dataJSON.sort();
    var courseFullName = "Mechanics for EngineersDynamics asdasXSaas";
    var color = "black";
    function getColor(index) {
        if (dataJSON[index].final_grade == "NP") {
            color = "blue";
        }
        else if (dataJSON[index].final_grade == "W") {
            color = "yellow";
        }
        else if (dataJSON[index].final_grade <= 60) {
            color = "grey";
        }
        else if (dataJSON[index].final_grade > 60) {
            color = "orange";
        }
        else if (dataJSON[index].final_grade > 75) {
            color = "pink";
        }
        else if (dataJSON[index].final_grade > 90) {
            color = "red";
        }
    }
    term1.innerHTML = "";
    term1.innerHTML = "<div class = 'tittle'>" + "<h2>" + dataJSON[0].term + "</h2></div>";
    for (i = 0; i < 5; i++) {
        getColor(i);
        term1.innerHTML += "<div class = 'tittle'>" + "<h2>" + dataJSON[0].term + "</h2></div>";
            "<div class = 'course_cards' id = 'course_cards_builder' style = 'border-color:" + color + "'>" + "<h3>" + dataJSON[i].course_ID + "</h3>" +
            "<p>" + dataJSON[i].term + "</p>" +
            "</div>";
    }

}*/

/*
Drag and drop courses to add box





*/

function courseNeededArray() {
    var coursesList = [];
    for (term in courseReqData) {
        for (i = 0; i < courseReqData[term].length; i++) {
            if (courseReqData[term][i] != "Approved") {
                coursesList.push(courseReqData[term][i]);
            }
        }
    }
    //console.log(coursesList);
    return coursesList;
}
function getPrerequisite(courseName) {
    var prerequisite;
    for (i = 0; i < allCourseData.length; i++) {
        if (allCourseData[i].short_name == courseName)
            return allCourseData[i].prerequisite;
        else
            return "no such course";
    }
}
// Knowing which term apply this course

function getTermInfo(courseName) {
    var myRequest = new XMLHttpRequest;
    var myRequest2 = new XMLHttpRequest;
    var myRequest3 = new XMLHttpRequest;
    var term = "Applied Term: ";
    url2 = "JSON/202020/" + courseName + ".json";
    url3 = "JSON/202030/" + courseName + ".json";
    url1 = "JSON/202110/" + courseName + ".json";


    myRequest3.open("GET", url1, false);
    myRequest3.onload = function () {
        var data = JSON.parse(myRequest3.responseText);
        if (data.term != "No class for the term") {
            term += "Winter" + " ";
        }
    }
    myRequest3.send();



    myRequest.open("GET", url2, false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        if (data.term != "No class for the term") {
            term += "Spring/Summer" + " ";
        }
    }
    myRequest.send();

    myRequest2.open("GET", url3, false);
    myRequest2.onload = function () {
        var data = JSON.parse(myRequest2.responseText);
        if (data.term != "No class for the term") {
            term += "Fall" + " ";
        }
    }
    myRequest2.send();
    return term;
}
//console.log(courseNeededArray());
console.log(getTermInfo("ENGG 140"));

getAllCourse();
function getAllCourse() {
    var myRequest = new XMLHttpRequest;
    myRequest.open("GET", "JSON/ALL.json", false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        allCourseData = data;
    }
    myRequest.send();
}
//console.log(allCourseData);
dragTest();
function dragTest() {
    //const draggableElement = document.querySelector("#nct0");

        const draggableElement = document.querySelector("#nct0");
        draggableElement.addEventListener("dragstart", e => {
            e.dataTransfer.setData("text/plain", draggableElement.id);
            console.log(e);
        });
        for (const dropZone of document.querySelectorAll(".course_cards")) {
            dropZone.addEventListener("dragover", e => {
                e.preventDefault();
                console.log(e);
                dropZone.classList.add("drop-zone--over");
            });
            dropZone.addEventListener("drop", e => {
                e.preventDefault();
                
            });


        }





    }


}



