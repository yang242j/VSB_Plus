var courseData;
var termData;
var electivesData;
var allCourse;

window.onload = function () {
    console.log(major);
    getTermData(major);
    getElectivesData(major);
    getAllCourse();
    
    
    showTerm(1);
    
    showENSE_electives();
    showCS_electives();
    showENEL_electives();
    showAllCourse();
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
// console.log(getTitle("CHEM 140"));

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
    
function showENSE_electives() {
    for (term in termData) {
        if (term = "Approved") {
            for (i = 0; i <= 6; i++) {
                document.getElementById("ense" + i).innerHTML = termData[term][i];
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
                for (i = 0; i < 12; i++) {
		if (electivesData[i] == null){
			return;
		}
            	else{ 
                	document.getElementById("cs" + i).innerHTML = electivesData[electives][i];
            	}
        }
        }
    
}
}

function showENEL_electives() {
    for (term in termData) {
        if (term = "Approved") {
            for (i = 14; i <= 15; i++) {
            /*for (i = 0; i < 12; i++) {*/
                document.getElementById("enel" + i).innerHTML = termData[term][i];
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
