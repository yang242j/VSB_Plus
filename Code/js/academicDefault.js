var courseData;
var termData;
var electivesData;
var allCourse;

window.onload = function () {
    console.log(major);
    getTermData(major);
    /*getMajor(major);*/
    getElectivesData(major);
    getAllCourse();
    
    
    showTerm(1);
    showAllCourse();
    showENSE_electives();
    showCS_electives();
    showENEL_electives();
    showENIN_electives();
    
    /*sort_Electives();*/
}




// function getStuInfo(major) {
//     return $.post('Model/courseREC.php', {
//         major: major,
//     }, function (data) {});
// }
//     // console.log(GetUrlRelativePath());
//     $.post('Model/sign_in.php', {
//         sid: sid,
//         password: password
        
//     }, function (data) {
//         // console.log("data is ", data)
//         var stu = JSON.parse(data);
//         //alert(stu);
//         var major = stu.major;
//         getTermData(major);
//     });
// }

//function fetchCourseJSON(short_name) {
//   return $.post('Model/course.php', {
//        short_name: short_name
//    }, function (data) {
//    	showCourseInfo(data);
//    });
//}

/*function showCourseInfo(data) {
	var dataCourse = JSON.parse(data);

	if(short_name ==)
	{
	return ("<p>" + "Faculty: " + dataCourse.faculty + "</p>" + 
	"<p>" + "Name: " + dataCourse.short_name + "</p>" + 
	"<p>" + "Title: " + dataCourse.title + "</p>" +
	"<p>" + "Credit: " + dataCourse.credit + "</p>" +
	"<p>" + "Description: " + dataCourse.description + "</p>" +
	"<p>" + "Prerequisite: " + dataCourse.prerequisite + "</p>");
	}

	return ("Course Info not found");
}*/

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
    }
    myRequest.send();
}

/*function course_Info() {
	for (i = 0; i < allCourseData.length; i++) {
	if (allCourseData[i].short_name == courseName && allCourseData[i].title != null
            return ("<p>" + "Title: " + allCourseData[i].title + "</p>" + 
			"<p>" + "Description: " + allCourseData[i].description + "</p>" +
			"<p>" + "Prerequisite: " + allCourseData[i].prerequisite + "</p>");
	}
		return ("Course Info not found");
	
}*/
	
function showTerm(pageNumber) {
    var i = 1;
    for (term in termData) {
        /*console.log(termData[term][0]);*/
        termNumber = "term" + pageNumber;
        if (term >= termNumber) {
            if (term != "Approved") {
                /*if (i <= 4) {*/
                if (i <= 10) {
                    /*if(pageNumber < 7) {*/
                    if (pageNumber < 12) {
                        document.getElementById("term" + i).innerHTML =
                            "<div class = 'tittle'>" + "<h2>" + term + ":" + "</h2></div>" +
                            "<div class = 'course_cards'>" + "<h3>" + termData[term][0] + "</h3>" +
                            "<p>" + getTitle(termData[term][0]) + "</p>" +
                            /*"<i class='fas fa-circle' id = 'circle1' style='font-size:24px;'></i>"+
                            "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                            "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                            "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/
                            "</div>" +


                            "<div class = 'course_cards'>" + "<h3>" + termData[term][1] + "</h3>" +
                            "<p>" + getTitle(termData[term][1]) + "</p>" +
                            /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/
                            "</div>" +

                            "<div class = 'course_cards'>" + "<h3>" + termData[term][2] + "</h3>" +
                            "<p>" + getTitle(termData[term][2]) + "</p>" +
                            /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/
                            "</div>" +

                            "<div class = 'course_cards'>" + "<h3>" + termData[term][3] + "</h3>" +
                            "<p>" + getTitle(termData[term][3]) + "</p>" +
                            /* "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                             "<i class='fas fa-circle' style='font-size:24px;color:red'></i>*/
                            "</div>" +

                            "<div class = 'course_cards'>" + "<h3>" + termData[term][4] + "</h3>" +
                            "<p>" + getTitle(termData[term][4]) + "</p>" +
                            /*  "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                               "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                               "<i class='fas fa-circle' style='font-size:24px;color:red'></i>"+
                               "<i class='fas fa-circle' style='font-size:24px;color:yellow'></i>*/
                            "</div>";
                      i = i + 1;
                    }
                }
            }
        }
    }
}

/*function sort_Electives() {
    for (term in termData) {
        if (term = "Approved") {
	        if(Approved.includes('CS 205') || Approved.includes('CS 315') || Approved.includes('CS 330') 
               || Approved.includes('CS 375') || Approved.includes('CS 405')
              || Approved.includes('CS 425')|| Approved.includes('CS 427'))
            {
                    showCS_electives();
            }
            }
        }
    
}*/

/*function getMajor(major)
{
	if(major = "SSE"){
		showENSE_electives();
    		showCS_electives();
    		showENEL_electives();
	} else if(major = "ISE"){
		showENEL_electives();
    		showENIN_electives();
    	}
}*/

/*function showENSE_electives() {
    for (term in termData) {
        if (term = "Approved") {
            for (i = 0; i <= 6; i++) {
                document.getElementById("ense" + i).innerHTML = termData[term][i];
            }
        }
    }
}*/

function showENSE_electives() {
    for (electives in electivesData) {
        if (electives = "ENSE") {
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i < 7; i++) {
                	document.getElementById("ense" + i).innerHTML = electivesData[electives][i];
            	}
           }            
     }
}

/*function showCS_electives() {
    for (term in termData) {
        if (term = "Approved") {
            for (i = 7; i <= 13; i++) {
                /*for (i = 0; i < 12; i++) {
                document.getElementById("cs" + i).innerHTML = termData[term][i];
            }
        }
        }
    
}*/

function showCS_electives() {
    for (electives in electivesData) {
        if (electives = "CS") {
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i < 7; i++) {
                	document.getElementById("cs" + i).innerHTML = electivesData[electives][i];
            	}
           }            
     }
}

/*function showENEL_electives() {
    for (term in termData) {
        if (term = "Approved") {
            for (i = 14; i <= 15; i++) {
            /*for (i = 0; i < 12; i++) {
                document.getElementById("enel" + i).innerHTML = termData[term][i];
            }
        }
    }

}*/

function showENEL_electives() {
    for (electives in electivesData) {
        if (electives = "ENEL") {
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i < 2; i++) {
                	document.getElementById("enel" + i).innerHTML = electivesData[electives][i];
            	}
           }            
     }
}

function showENIN_electives() {
    for (electives in electivesData) {
        if (electives = "ENIN") {
            /*for (i = 7; i <= 13; i++) {*/
                for (i = 0; i < 7; i++) {
                	document.getElementById("enin" + i).innerHTML = electivesData[electives][i];
            	}
           }            
     }
}

function showAllCourse() {
    for (i = 0; i < 12; i++) {
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

// 这个function可以不用的
function courseInfo() {

	for (i = 0; i < 12; i++) {
		
    //var element = document.getElementById("course_input");
		var course = document.getElementById("all" + i);
		
    //var input = element.value.toUpperCase();
		//var input_course = course.value.toUpperCase();
		
    //element.setAttribute("value", input);
		//course.setAttribute("value", input_course);
		
    //courseSelect(element);
		courseSelect(course);
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
    var courseInfo = "<h2 id='title'>" + jsonRsp.short_name + "</h2>" +
        "<ul>" +
        "<li><span class='bold'>Course Name</span>: <span id='fullName'>" + jsonRsp.title + "</span> </li>" +
        "<li>***<span class='bold'>Prerequisites</span>: <span id='preReqClass'>" + jsonRsp.prerequisite + "</span> ***</li>" +
        "<li><span class='bold'>Course Description</span>: " + jsonRsp.description + "</li>" + "</ul>";
    alert(courseInfo);
} 
