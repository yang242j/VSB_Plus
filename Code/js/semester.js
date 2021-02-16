const colors = ["lightblue", "lightseagreen", "pink", "yellow", "Azure", "Bisque", "Coral", "Cyan", "Cornsilk", "Lavender"];
var pre_colorID = "", examDateList = [new Date("Apr 20 2021")];

//Calendar init
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    initialDate: new Date(),
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    eventTimeFormat: {
        hour: "numeric",
        minute: "2-digit",
        meridiem: "short",
        hour12: true,
    },
    events: [],
});
calendar.render();

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    //console.log("drag", ev.target.id)
}

function dragEnter(ev) {
    //ev.target.style.backgroundColor = "green";
    //console.log("dragEnter", ev.target.id)
}

function dragLeave(ev) {
    //ev.target.style.backgroundColor = "black";
    //console.log("dragLeave", ev.target.id)
}

function dropL(ev, term) {
    var short_name = ev.dataTransfer.getData("Text");
    var randomColorIndex = "";
    do {
        randomColorIndex = Math.floor(Math.random() * colors.length);
        //console.log(randomColorIndex);
    } while (randomColorIndex == pre_colorID);
    var BGC = colors[randomColorIndex];

    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();

        //if exampleDiv exist, remove
        if($("#exampleDiv").length){	
            $( "#exampleDiv" ).remove();
        }

        //if tag exist, refuse to append
        if ($(".selected-course[id='" + short_name + "']").length) {	
            //console.log($(".selected-course[id='" + short_name + "']").length);
            console.log(short_name + " already exist in course List");
            return;
        } else {
            //console.log($(".left-section[id='" + short_name + "']").length);
            //1.Append courseTag-list
            document.getElementsByClassName("left-section")[0].appendChild(document.getElementById(short_name));
            document.getElementById(short_name).style.backgroundColor = BGC;
            document.getElementById(short_name).classList.add("selected-course"); // Add selected-course class
            //2.Fetch Course JSON data
            fetchCourseJSON(short_name).done(function(result1) {
                var course_json = JSON.parse(result1);
                
                //3.Append courseCard-list
                appendCourseCard(course_json, BGC);
                pre_colorID = randomColorIndex; //3.1.Store color id
                
                // Init common section variables
                var section_json_obj, section_id, section_num, sec_short_name, time, days, date_range;
                //4.Fetch Lecture Section JSON data
                fetchSectionJSON(short_name, schedule_type="Lecture", term).done(function (result2) {
                    section_json_obj = JSON.parse(result2);
                    section_id = "0";
                    if (section_json_obj[section_id]) {
                        section_num = section_json_obj[section_id].section_num;
                        sec_short_name = section_json_obj[section_id].short_name;
                        time = section_json_obj[section_id].time;
                        days = section_json_obj[section_id].days;
                        date_range = section_json_obj[section_id].date_range;
                        //5.Append calendar
                        appendCalendar(section_num, sec_short_name, time, days, date_range, BGC);
                    } else {
                        console.error("Something WRONG with " + short_name + " Lecture section");
                    }
                }).fail(function () {
                    console.error(short_name + "Leccture Section JSON Fetch ERROR");
                });
                
                //6. Fetch Laboratory Section JSON data
                fetchSectionJSON(short_name, schedule_type="Laboratory", term).done(function (result3) {
                    section_json_obj = JSON.parse(result3);
                    section_id = "0";
                    if (section_json_obj[section_id]) {
                        section_num = section_json_obj[section_id].section_num;
                        sec_short_name = section_json_obj[section_id].short_name;
                        time = section_json_obj[section_id].time;
                        days = section_json_obj[section_id].days;
                        date_range = section_json_obj[section_id].date_range;
                        //7.Append calendar
                        appendCalendar(section_num, sec_short_name, time, days, date_range, BGC);
                    } else {
                        console.error("Something WRONG with " + short_name + " Laboratory section");
                    }
                }).fail(function () {
                    console.error(short_name + "Laboratory Section JSON Fetch ERROR");
                });

                //8. Fetch Examination Section JSON data
                fetchSectionJSON(short_name, schedule_type="Examination", term).done(function (result4) {
                    section_json_obj = JSON.parse(result4);
                    section_id = "0";
                    if (section_json_obj[section_id]) {
                        section_num = section_json_obj[section_id].section_num;
                        sec_short_name = section_json_obj[section_id].short_name;
                        time = section_json_obj[section_id].time;
                        days = section_json_obj[section_id].days;
                        date_range = section_json_obj[section_id].date_range;
                        //9.Append exam list
                        appendExamList(section_num, sec_short_name, time, days, date_range);
                    } else {
                        console.error("Something WRONG with " + short_name + " Examination section");
                    }
                }).fail(function () {
                    console.error(short_name + "Examination Section JSON Fetch ERROR");
                });
            }).fail(function() {
                console.error(short_name + "Course JSON Fetch ERROR");
            });
        }
    }
}

function dropBR(ev) {
    var short_name = ev.dataTransfer.getData("text");
    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        // 1.Append tag at BR
        document.getElementsByClassName("bottom-right")[0].appendChild(document.getElementById(short_name));
        document.getElementById(short_name).style.backgroundColor = "DarkGrey"; // Set tag BGC to DarkGrey
        document.getElementById(short_name).classList.remove("selected-course"); // Remove selected-course class
        // Remove course card from middle section
        removeCourseCard(short_name);
        // Remove course event from calendar
        removeCalendar(short_name);
    }
}

function fetchCourseJSON(short_name) {
    return $.post('Model/course.php', { short_name: short_name }, function (data) {});
}

function fetchSectionJSON(short_name, schedule_type, term) {
    return $.post('Model/section.php', { short_name: short_name, schedule_type: schedule_type, term: term }, function(data) {});
}

function appendCourseCard(course_json, BGC) {
    var card_id = course_json.short_name + "_Card";
    var course_card =
        "<div class='courseInfo' id='" + card_id +
        "' style='background-color:" + BGC + ";'>" +
        "<h2>" + course_json.short_name + "</h2>" +
        "<h4>" + course_json.title + "</h4>" +
        "<p>Description: " + course_json.description + "</p>" +
        "</div>";
    document.getElementById("courseCardList").innerHTML += course_card;
}

function removeCourseCard(short_name) {
    var card_id = short_name + "_Card";
    try {
        document.getElementById(card_id).remove();
    } catch (e) {
        console.error(card_id + " remove FAILED");
    }
    
}

function appendCalendar(section_num, short_name, time, days, date_range, BGC) {
    // Manage the input values
    var event_id = short_name;
    var event_title = event_id.concat(" [", section_num, "]");
    var start_date = new Date(date_range.slice(0, 12)).toISOString().substring(0, 10);
    var end_date = new Date(date_range.slice(15)).toISOString().substring(0, 10);
    var start_time = get24HrsFrm12Hrs(time.slice(0, 7));
    var end_time = get24HrsFrm12Hrs(time.slice(10));
    var daysOfWeek = [];

    // Convert the daysOfWeek
    for (var i = 0; i < days.length; i++) {
        switch (days[i].toUpperCase()) {
            case "M":
                daysOfWeek.push("1");
                break;
            case "T":
                daysOfWeek.push("2");
                break;
            case "W":
                daysOfWeek.push("3");
                break;
            case "R":
                daysOfWeek.push("4");
                break;
            case "F":
                daysOfWeek.push("5");
                break;
            case "S":
                daysOfWeek.push("6");
                break;
            // Assume NO Sunday lecture or lab 
        }
    }

    // Try to append the calendar
    try {
        calendar.addEvent({
            allDay: false,
            timeFormat: 'h(:mm)t',
            id: event_id,
            title: event_title,
            startRecur: start_date,
            endRecur: end_date,
            startTime: start_time,
            endTime: end_time,
            daysOfWeek: daysOfWeek,
            textColor: "black",
            color: BGC,
        });
    } catch (e) {
        console.error("Calendar event" + event_title + " append FAILED");
    }
}

function removeCalendar(short_name) {
    try {
        calendar.getEventById(short_name).remove();
    } catch (e) {
        console.error("Calendar event" + short_name + " remove FAILED");
    }
}

function appendExamList(section_num, sec_short_name, time, days, date_range) {
    // Variable init
    var examDate_li, conflictExam, weekDay;
    var examDate_id = sec_short_name.concat(" [", section_num, "]");
    var examDate = new Date(date_range.slice(0, 12)).toDateString();

    // Check if exams are close or conflict
    for (var i = 0; i < examDateList.length; i++) {
        if (examDateList[i].getTime() === examDate.getTime()) {
            conflictExam = true;
        } else if (Math.abs(examDateList[i].getTime() - examDate.getTime()) <= 86400000) {
            conflictExam = true;
        } else {
            conflictExam = false;
        }
    }

    // Convert days to fullword
    switch (days.toUpperCase()) {
        case "M":
            weekDay = "Monday";
            break;
        case "T":
            weekDay = "Tuesday";
            break;
        case "W":
            weekDay = "Wednesday";
            break;
        case "R":
            weekDay = "Thursday";
            break;
        case "F":
            weekDay = "Friday";
            break;
        case "S":
            weekDay = "Saturday";
            break;
        // Assume NO Sunday exam
    }

    if (conflictExam == true) {
        examDate_li = "<li id='" + examDate_id + "'><mark>" + examDate_id + ": " + weekDay + ", " + examDate.slice(3) + " " + time + "</mark></li>";
    } else {
        examDate_li = "<li id='" + examDate_id + "'>" + examDate_id + ": " + weekDay + ", " + examDate.slice(3) + " " + time + "</li>";
    }
    document.getElementById("examDate_ul").innerHTML += examDate_li;
    examDateList.push(examDate);
    console.log(examDateList);
}

function removeExamList() {

}

function tagGenerator(short_name, draggable = true) {
    var course_tag = "";

    if (draggable == true) {
        course_tag =
            "<div class='courseTag' id='" + short_name +
            "' draggable='true'>" + short_name +
            "</div>";
    } else {
        course_tag =
            "<div class='courseTag noDrag' id='" + short_name +
            "' draggable='false'>" + short_name +
            "</div>";
    }

    return course_tag;
}

function get24HrsFrm12Hrs(timeString) {
    // seperate H, M, am, pm
    var hours = Number(timeString.match(/^(\d+)/)[1]);
    var minutes = Number(timeString.match(/:(\d+)/)[1]);
    var AMPM = timeString.match(/\s(.*)$/)[1];

    // Special cases
    if(AMPM.toLowerCase() == "pm" && hours<12) hours = hours+12;
    if(AMPM.toLowerCase() == "am" && hours==12) hours = 0;
    
    // Convertor
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if(hours<10) sHours = "0" + sHours;
    if(minutes<10) sMinutes = "0" + sMinutes;
    return sHours + ":" + sMinutes;;
}

function menuFunc3() {
    $(".stick-bottom").toggle({bottom: '0'}, 1000);
}