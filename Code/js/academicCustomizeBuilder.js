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
//console.log(getTermInfo("CHEM 140"));
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
    console.log(courseNotCompleted);
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
    
   

    /*for (i = 0; i < 12; i++) {
        document.getElementById("ct" + i).innerHTML = " ";
        // document.getElementById("nct" + i).innerHTML = " ";
    }*/
    //console.log(dataJSON);
    for (i = 0; i < 12; i++) {
        if (i < dataJSON.length) {
            //<br/>
            document.getElementById("ct" + i).innerHTML = dataJSON[i].course_ID + "<br/> " + dataJSON[i].term;
            document.getElementById("ct" + i).style.color = getColor(i, dataJSON);

        }
    }
    console.log(notCompletedData);
    for (i = 0; i < notCompletedData.length; i++) {
        document.getElementById("courseTagArea").innerHTML +=
            "<div class = 'courseTags' >" +
            "<div  draggable = 'true' id ='nct" + i + "'" +notCompletedData[i]+ ">" +
            "<p id ='nnnct" + i + "'" + ">" +notCompletedData[i]  +"</p>" +
            "<p id ='nnct" + i + "'" + ">" +getTermInfo(notCompletedData[i])  +"</p>" +
            "</div> </div>";
        document.getElementById("nnct"+i).style.visibility = "hidden";
        document.getElementById("nnct"+i).style.fontSize = "0.1px";
        document.getElementById("nnct"+i).style.lineHeight = "0%";
        document.getElementById("nnct"+i).style.marginTop = "-10px";
        document.getElementById("nct"+i).style.color="black";
        document.getElementById("nct"+i).style.marginTop = "-10px";
       //console.log(getPrerequisite(notCompletedData[i]));
    }
    for (i = 0; i < notCompletedData.length; i++) {
        dragTest("#nct" + i);
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
}



/*
Drag and drop courses to add box





*/
getAllCourse();

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
    var pre = "Prerequisite:";
    for (i = 0; i < allCourseData.length; i++) {
        if (allCourseData[i].short_name == courseName && allCourseData[i].prerequisite != null)
            return (pre + allCourseData[i].prerequisite);
    }
    return (pre + "no such course or no prerequisite");
}

//console.log(getPrerequisite("CS 210"));
//console.log(getTermInfo("CHEM 140"));
// Knowing which term apply this course

function getTermInfo(courseName) {
    var myRequest = new XMLHttpRequest;
    var myRequest2 = new XMLHttpRequest;
    var myRequest3 = new XMLHttpRequest;
    var term = "Applied Term: ";
    var prerequisite = "Prerequisite: </br>";
    var credit;
    url2 = "JSON/202020/" + courseName + ".json";
    url3 = "JSON/202030/" + courseName + ".json";
    url1 = "JSON/202110/" + courseName + ".json";

    myRequest3.open("GET", url1, false);
    myRequest3.onload = function () {
        if (myRequest3.responseText != null) {
            var data = JSON.parse(myRequest3.responseText);
            if (data.term != "No class for the term") {
                term += "Winter" + " ";
                prerequisite += data.prerequisite;
                credit = data.credit;
            }
        }
    }
    myRequest3.send();

    myRequest.open("GET", url2, false);
    myRequest.onload = function () {
        if (myRequest3.responseText != null) {
            var data = JSON.parse(myRequest.responseText);
            if (data.term != "No class for the term") {
                term += "Spring/Summer" + " ";
                prerequisite += data.prerequisite;
                credit = data.credit;
            }
        }
    }
    myRequest.send();

    myRequest2.open("GET", url3, false);
    myRequest2.onload = function () {
        if (myRequest2.responseText != null) {
            var data = JSON.parse(myRequest2.responseText);
            if (data.term != "No class for the term") {
                term += "Fall" + " ";
                prerequisite += data.prerequisite;
                credit = data.credit;
            }
        }
    }
    myRequest2.send();


    return [term+"</br>","credits:"+credit+"</br>",prerequisite];
}
//console.log(courseNeededArray());
//console.log(getTermInfo("ENGG 140"));
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
function dragTest(elementId) {
    //const draggableElement = document.querySelector("#nct0");
    const draggableElement = document.querySelector(elementId);
    draggableElement.addEventListener("dragstart", e => {
        e.dataTransfer.setData("text/plain", draggableElement.id);
    });
    for (const dropZone of document.querySelectorAll(".course_cards")) {
        dropZone.addEventListener("dragover", e => {
            e.preventDefault();
            dropZone.classList.add("drop-zone--over");

            v

        });

        dropZone.addEventListener("dragleave", e => {
            dropZone.classList.remove("drop-zone--over");
        });
        dropZone.addEventListener("drop", e => {
            e.preventDefault();
            const droppedElementId = e.dataTransfer.getData("text/plain");
            const droppedElement = document.getElementById(droppedElementId);
            //show moreinfo in course card

            var newForAlern = "n" + droppedElementId;
            var newForAlern2 = "nn" + droppedElementId;
            //var content = document.getElementById(newForAlern).innerHTML;

            document.getElementById(newForAlern).style.visibility = "visible";
            document.getElementById(newForAlern).style.fontSize = "10px";
            document.getElementById(newForAlern).style.lineHeight = "110%";
            if(document.getElementById(newForAlern).innerHTML.length <=80){
                document.getElementById(newForAlern).style.fontSize = "20px";
            }
            if(document.getElementById(newForAlern).innerHTML.length <= 100 && document.getElementById(newForAlern).innerHTML.length >80){
                document.getElementById(newForAlern).style.fontSize = "12px";
            }
            


            dropZone.appendChild(droppedElement);
            dropZone.classList.remove("drop-zone--over");

        });
    }

    for (const dropZone of document.querySelectorAll(".courseTags")) {
        dropZone.addEventListener("dragover", e => {
            e.preventDefault();
            dropZone.classList.add("drop-zone--over");
        });

        dropZone.addEventListener("dragleave", e => {
            dropZone.classList.remove("drop-zone--over");
        });
        dropZone.addEventListener("drop", e => {
            e.preventDefault();
            const droppedElementId = e.dataTransfer.getData("text/plain");
            const droppedElement = document.getElementById(droppedElementId);
            //show less info in course tag
            var newForAlern = "n" + droppedElementId;
            document.getElementById(newForAlern).style.visibility = "hidden";

            dropZone.appendChild(droppedElement);
            dropZone.classList.remove("drop-zone--over");

        });

    }
}
/*y=0;
var x = "#nct" + y;
dragTest(x);
dragTest("#nct1");
dragTest("#nct2");
dragTest("#nct3");*/