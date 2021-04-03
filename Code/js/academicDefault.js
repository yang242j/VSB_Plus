var courseData;
var termData;
var electivesData;
var allCourse;

var nameAbbr = {
    'ESE': 'Electronic Engineering',
    'EVSE': 'Environmental Engineering' ,
    'ISE': 'Industrial Engineering',
    'PSE': 'Petroleum Engineering',
    'SSE': 'Software engineering',
};
var takenClass = {
    "finish":   0,
    "unfinish": 0,
    'sum':0,
};

window.onload = function () {
    console.log(major);
    getTermData(major);
    getElectivesData(major);
    getAllCourse();
    
    
    showTerm(1);
    showAllCourse();

    markBorder();
}

function markBorder(){
    //fetch JSON data from takenClass database
    $.post('Model/takenClass.php', {
        sid: sid,
        password: pas
    }, function (data) {
        var dataJSON = JSON.parse(data);
        var takenCouList = [];
        for (i = 0; i < dataJSON.length; i++){
            takenCouList.push(dataJSON[i].course_ID)
        }
        // console.log(takenCouList);
        let eles = document.getElementsByClassName('course_cards');
        for (i = 0; i < eles.length; i++){
            short_name = eles[i].firstChild.innerHTML;
            // console.log(short_name);
            let ele = eles[i];
            if (takenCouList.includes(short_name)){
                ele.setAttribute('class', ele.getAttribute('class') + ' passCourse');
                takenClass.finish += 1;
            }
            else{
                ele.setAttribute('class', ele.getAttribute('class') + ' notPassCourse');
                takenClass.unfinish += 1;
            }
        }
        takenClass.sum = takenClass.finish + takenClass.unfinish;
        loadMajor();
    });
}

function loadMajor(){
    let ele = document.getElementById('major');
    ele.innerHTML = major;
    ele.setAttribute('title', nameAbbr[major]);

    let percen = parseInt(takenClass.finish * 100 / takenClass.sum);
    let grandParent = ele.parentNode.parentNode;
    let progress = "<div class='progress progress-striped' style='width: 100%;'>" + 
        "<div class='progress-bar progress-bar-warning' role='progressbar' " + 
             "aria-valuenow='60' aria-valuemin='0' aria-valuemax='100' " +
             "style='width: "+ percen +"%;''>" +
            "<span class='sr-only'>Course Progress</span> "+
            "<p style='color:black;';>Progress:"+percen+"%</p>" + 
        "</div>" +
        "</div>";
    grandParent.innerHTML += progress;
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

function getTitle(courseName) {
    for (i = 0; i < allCourseData.length; i++) {
        if (allCourseData[i].short_name == courseName && allCourseData[i].title != null)
            return ("<i>" + allCourseData[i].title + "</i>");
    }
    return ("Course Info not found");
}
 //console.log(getTitle("CHEM 140"));

function getTermData(major) {
    var myRequest = new XMLHttpRequest;
    var majorName = major;
    var url = "JSON/reqCourse/" + majorName + "_req.json";
    myRequest.open("GET", url, false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        termData = data;
    }
    myRequest.send();
}

function getElectivesData(major) {
    var myRequest = new XMLHttpRequest;
    var majorName = major;
    var url = "JSON/reqCourse/" + majorName + "_ele.json";
    myRequest.open("GET", url, false);
    myRequest.onload = function () {
        var data = JSON.parse(myRequest.responseText);
        electivesData = data;
        showElectives();    // 用XMLHttpRequest的话，数据最好是在这个function内，直接使用，而不是store data后使用
    }
    myRequest.send();
}
	
function showTerm(pageNumber) {
    var i = 1;
    for (term in termData) {
        /*console.log(termData[term][0]);*/
        termNumber = "term" + pageNumber;
        if (term >= termNumber) {
            if (term != "Approved") {
                if (i <= 10) {
                    if (pageNumber < 12) {
                        document.getElementById("term" + i).innerHTML =
                            "<div class = 'tittle'>" + "<h2>" + term + ":" + "</h2></div>" +
                            "<div class = 'course_cards' onclick=\'courseSelect(event)\'>" + "<h3>" + termData[term][0] + "</h3>" +
                            "<p>" + getTitle(termData[term][0]) + "</p>" +
                            "</div>" +


                            "<div class = 'course_cards' onclick=\'courseSelect(event)\'>" + "<h3>" + termData[term][1] + "</h3>" +
                            "<p>" + getTitle(termData[term][1]) + "</p>" +
                            "</div>" +

                            "<div class = 'course_cards' onclick=\'courseSelect(event)\'>" + "<h3>" + termData[term][2] + "</h3>" +
                            "<p>" + getTitle(termData[term][2]) + "</p>" +
 			    "</div>" +

                            "<div class = 'course_cards' onclick=\'courseSelect(event)\'>" + "<h3>" + termData[term][3] + "</h3>" +
                            "<p>" + getTitle(termData[term][3]) + "</p>" +
                            "</div>" +

                            "<div class = 'course_cards' onclick=\'courseSelect(event)\'>" + "<h3>" + termData[term][4] + "</h3>" +
                            "<p>" + getTitle(termData[term][4]) + "</p>" +
                            "</div>";
                      i = i + 1;
                    }
                }
            }
        }
    }
}


function showENSE_electives() {
    for (electives in electivesData) {
        if (electives = "ENSE") {
		document.getElementById("electives1").innerHTML = "<div class = 'electives_course'>" + 
					"<h3>" + electives + ":" + "</h3>" + "</div>";
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i <= 6; i++) {
                	// document.getElementById("ense" + i).innerHTML = electivesData[electives][i];
                	document.getElementById("a" + i).innerHTML = electivesData[electives][i];
			

            	}
           }            
     }
}

function showCS_electives() {
    for (electives in electivesData) {
        if (electives = "CS") {
		document.getElementById("electives2").innerHTML = "<div class = 'electives_course'>" + 
					"<h3>" + electives + ":" + "</h3>" + "</div>";
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i < 7; i++) {
                	// document.getElementById("cs" + i).innerHTML = electivesData[electives][i];
                    document.getElementById("b" + i).innerHTML = electivesData[electives][i];
			
				

            	}
           }            
     }
}

function showENEL_electives() {
    for (electives in electivesData) {
        if (electives = "ENEL") {
		document.getElementById("electives3").innerHTML = "<div class = 'electives_course'>" + 
					"<h3>" + electives + ":" + "</h3>" + "</div>";
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i < 2; i++) {
                	// document.getElementById("enel" + i).innerHTML = electivesData[electives][i];
                    document.getElementById("c" + i).innerHTML = electivesData[electives][i];
			

            	}
           }            
     }
}

function showENIN_electives() {
    for (electives in electivesData) {
        if (electives = "ENIN") {
		document.getElementById("electives1").innerHTML = "<div class = 'electives_course'>" + 
					"<h3>" + electives + ":" + "</h3>" + "</div>";
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i < 9; i++) {
                	// document.getElementById("enin" + i).innerHTML = electivesData[electives][i];
                    document.getElementById("a" + i).innerHTML = electivesData[electives][i];
            	}
           }            
     }
}

function showENGG_electives() {
    for (electives in electivesData) {
        if (electives = "ENGG") {
		document.getElementById("electives2").innerHTML = "<div class = 'electives_course'>" + 
					"<h3>" + electives + ":" + "</h3>" + "</div>";
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i < 1; i++) {
                	// document.getElementById("enin" + i).innerHTML = electivesData[electives][i];
                    document.getElementById("b" + i).innerHTML = electivesData[electives][i];
            	}
           }            
     }
}

function showAllCourse() {
    for (i = 0; i < 12; i++) {
        // document.getElementById("all" + i).innerHTML = allCourseData[i].short_name;
        document.getElementById("all" + i).innerHTML = allCourseData[i].short_name;
    }
}

var counter = 0;
function allLeft() {
    counter -= 1;
    k = 0;
    
    if (counter >= 0) {
        for (i = 0; i < 12; i++) {
            document.getElementById("all" + i).innerHTML = "";
        }

        for (i = 12 * counter; i < 12 * (counter + 1); i++) {
            if (i > allCourseData.length) {
                document.getElementById("all" + k).innerHTML = " ";
            } else {
                document.getElementById("all" + k).innerHTML = allCourseData[i].short_name;
            }
            k = k + 1;
        }
    } else {
        counter = 1;
    }
}

function allRight() {
    j = 0;
    if (allCourseData[i].short_name != null) {
        counter += 1;
    }
    
    if (counter >= 0) {
        for (i = 0; i < 12; i++) {
            document.getElementById("all" + i).innerHTML = "";
        }
        for (i = 12 * counter; i < 12 * (counter + 1); i++) {
            if (allCourseData[i] == null) return;
            if (i > allCourseData.length) {
                document.getElementById("all" + j).innerHTML = " ";
            } else {
                document.getElementById("all" + j).innerHTML = allCourseData[i].short_name;
            }
            j = j + 1;
        }
    } else {
        counter = 1;
    }
}


function courseSelect(event) {
    let target = event.srcElement;
    var short_name = target.innerHTML;
    console.log(short_name);
    selected(short_name);
}

function selected(short_name) {
    console.log("get set course funciton");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {       
            var jsonRsp = JSON.parse(this.responseText);
            setCourse(jsonRsp);
    };

    // xmlhttp.open("GET", "getCourse.php?short_name=" + short_name, false); // Get the data from database by the server php file
    var json_url = "JSON/202020/" + short_name + ".json"; //Get the course information from the locat 
    xmlhttp.open("GET", json_url, false);
    xmlhttp.send();
}

function setCourse(jsonRsp) {
		
    var courseInfo = "" + jsonRsp.short_name + "\n" +
        "Course Name: " + jsonRsp.title + "\n" + 
        "Prerequisites: " + jsonRsp.prerequisite + "\n" + 
        "Course Description: " + "\n" +
	jsonRsp.description + "\n";
		
    alert(courseInfo);
} 

function showElectives() {

	for(electives in electivesData){
		if (electives == "ENSE") {
			showENSE_electives();
		}
		if (electives == "CS") {
			showCS_electives();
		}
		if (electives == "ENEL"){
			showENEL_electives();
		}
		if (electives == "ENIN") {
			showENIN_electives();
		}
		if (electives == "ENGG") {
			showENGG_electives();
		}
	}
}


