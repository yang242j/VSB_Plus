const colors = ["lightblue", "lightseagreen", "pink", "yellow", "Azure", "Bisque", "Coral", "Cyan", "Cornsilk", "Lavender"];
var pre_colorID = "", examDateDic = {/*"ENGG 400_Exam": new Date("Apr 20 2021")*/};

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
            //2.Fetch Course info JSON data
            fetchCourseJSON(short_name).done(function(result1) {
                var course_json = JSON.parse(result1);

                //3. Fetch Course section JSON data
                var lec_exam_id='0', lab_id='0'; // Init common section variables

                fetchAllSectionData(short_name, term)
                    .then(function (result) {
                        // Do something with the result
                        let lec_json_obj = JSON.parse(result[0]); //3.1.Fetch Lecture Section JSON data
                        let lab_json_obj = JSON.parse(result[1]); //3.2. Fetch Lab Section JSON data
                        let exam_json_obj = JSON.parse(result[2]); //3.3. Fetch Exam Section JSON data

                        // Generate combo array for section selector
                        combos = combinationGenerator(lec_json_obj, lab_json_obj);
                        //alert(combos);

                        //4.Append cards, calendars, exams
                        appendCourseCard(course_json, combos, BGC); //4.1.Append courseCard-list

                        if (lec_json_obj[lec_exam_id] || exam_json_obj[lec_exam_id]) {
                            appendCalendar(lec_json_obj[lec_exam_id], BGC); //4.2.1.Append lecture calendar event
                            appendExamList(exam_json_obj[lec_exam_id]); //4.2.2.Append exam list
                        } else {
                            console.warn(short_name + " does NOT have Lecture-Exam section_" + lec_exam_id);
                        }

                        if (lab_json_obj[lab_id]) {
                            appendCalendar(lab_json_obj[lab_id], BGC); //4.2.3.Append lab calendar event
                        } else {
                            console.warn(short_name + " does NOT have Lab section_" + lab_id);
                        }

                        //5.Store color id to prevent same color twice
                        pre_colorID = randomColorIndex; 
                    })
                    .catch(function (error) {
                        // Handle error
                        console.log("Section Data collection error -> ", error);
                    });
            }).fail(function() {
                console.error(short_name + "Course JSON Fetch FAILED");
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
        // Remove exam date from List
        removeExamList(short_name);
    }
}

function changeCalendarAndExam(combo) {
    // split combo into lec_exam_num and lab_num
    let lec_exam_num = combo.split('-')[0];
    let lab_num = combo.split('-')[1];

    alert(lec_exam_num + "\n" + lab_num);
    // remove old lecture event from calendar
    // appendd new lecture section into calendar
    // remove old lab event from calendar
    // appendd new lab event into calendar
    // remove old exam li from list
    // appendd new exam li into list 
}

function fetchCourseJSON(short_name) {
    return $.post('Model/course.php', { short_name: short_name }, function (data) {});
}

async function fetchAllSectionData(short_name, term) {
    const lec_obj = await $.post('Model/section.php', { short_name: short_name, schedule_type: "Lecture", term: term }, function (result) { });

    const lab_obj = await $.post('Model/section.php', { short_name: short_name, schedule_type: "Lab", term: term }, function (result) { });

    const exam_obj = await $.post('Model/section.php', { short_name: short_name, schedule_type: "Examination", term: term }, function (result) { });
    
    return [lec_obj, lab_obj, exam_obj];
}

function fetchRecJSON(courseCompletedList, major, term, maxNum) {
    return $.post('Model/courseREC.php', { courseCompletedList: courseCompletedList, major: major, term: term, maxNum: maxNum }, function(data) {});
}

function appendCourseCard(course_json, comboList, BGC) {
    let card_id = course_json.short_name + "_Card";
    
    let course_card_1 =
        "<div class='courseInfo courseCard' id='" + card_id + "' style='background-color:" + BGC + ";'>" +
        "<h2>" + course_json.short_name + "</h2>" +
        "<label for='sectionCombo'></label>" +
        "<select id='sectionSelector'>";
    
    let course_card_2 = "";
    $.each(comboList, function (index, combo) {
        if (index == 0) {
            course_card_2 += "<option value='" + combo + "'>" + combo + "</option>";
        } else {
            course_card_2 += "<option value='" + combo + "'>" + combo + "</option>";
        }
    });
    
    let course_card_3 =
        "</select>" +
        "<h4>" + course_json.title + "</h4>" +
        "<p>" + course_json.description + "</p>" +
        "</div>";
    
    document.getElementById("courseCardList").innerHTML += course_card_1 + course_card_2 + course_card_3;
}

function removeCourseCard(short_name) {
    var card_id = short_name + "_Card";
    try {
        document.getElementById(card_id).remove();
    } catch (e) {
        console.error(card_id + " remove FAILED");
    }
    
}

function appendCalendar(section, BGC) {
    // Manage the input values
    var event_id = section.short_name;
    var event_title = event_id + " [" + section.section_num + "]";
    var start_date = new Date(section['date_range'].slice(0, 12)).toISOString().substring(0, 10);
    var end_date = new Date(section['date_range'].slice(15)).toISOString().substring(0, 10);
    
    if (section.time == "TBA" || section.time == "?" || section.time == null) return;
    var start_time = get24HrsFrm12Hrs(section.time.split("-")[0]);
    var end_time = get24HrsFrm12Hrs(section.time.split("-")[1]);
    
    if (section.days == "TBA" || section.days == "?" || section.days == null) return;
    // Convert days characters into daysOfWeek number
    var daysOfWeek = [];
    for (var i = 0; i < section.days.length; i++) {
        switch (section.days[i].toUpperCase()) {
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
            // Assume NO Sunday (0) lecture or lab 
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

function appendExamList(section) {
    // Variable init
    var examDate_li, conflictExam, weekDay;
    var examDate_id = section.short_name + "_Exam";
    var examDate_course = section.short_name + " [" + section.section_num + "]";
    var examDate = new Date(section.date_range.slice(0, 12));

    // Check if exams are close or conflict
    for (var [key_id, value_date] of Object.entries(examDateDic)) {
        if (value_date.getTime() === examDate.getTime()) {
            conflictExam = true;
        } else if (Math.abs(value_date.getTime() - examDate.getTime()) <= 86400000) {
            conflictExam = true;
        } else {
            conflictExam = false;
        }
    }

    // Convert days to fullword
    switch (section.days.toUpperCase()) {
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
        examDate_li = "<li id='" + examDate_id + "'><mark>" + examDate_course + ": " + weekDay + ", " + examDate.toDateString().slice(3) + " " + section.time + "</mark></li>";
    } else {
        examDate_li = "<li id='" + examDate_id + "'>" + examDate_course + ": " + weekDay + ", " + examDate.toDateString().slice(3) + " " + section.time + "</li>";
    }
    document.getElementById("examDate_ul").innerHTML += examDate_li;
    examDateDic[examDate_id] = examDate;
    //console.log(examDateDic);
}

function removeExamList(sec_short_name) {
    var examDate_id = sec_short_name.concat("_Exam");
    try {
        // Append li
        document.getElementById(examDate_id).remove();
        // remove exam key and value from examDateDic
        delete examDateDic[examDate_id];
    } catch (e) {
        console.error("Exam date " + examDate_id + " remove FAILED");
    }
}

function tagGenerator(short_name, draggable = true) {
    var course_tag = "";

    if (draggable == true) {
        course_tag =
            "<div class='courseTag noDrop' id='" + short_name +
            "' draggable='true' ondragstart='drag(event)'>" + short_name +
            "</div>";
    } else {
        course_tag =
            "<div class='courseTag noDrag' id='" + short_name +
            "' draggable='false'>" + short_name +
            "</div>";
    }

    return course_tag;
}

function combinationGenerator(lec_obj, lab_obj) {
    var lec_exam_arr = [], lab_arr = [];
    
    for (var y = 0; y < lec_obj.length; y++) {
        lec_exam_arr.push(lec_obj[y].section_num);
    }

    for (var x = 0; x < lab_obj.length; x++) {
        lab_arr.push(lab_obj[x].section_num);
    }

    if (lab_arr.length == 0) {
        return lec_exam_arr;
    }

    combos = [];

    for(var i = 0; i < lec_exam_arr.length; i++)
    {
        for(var j = 0; j < lab_arr.length; j++)
        {
           combos.push(lec_exam_arr[i] + "-" + lab_arr[j])
        }
    }

    return combos;
}

function get24HrsFrm12Hrs(timeString) {
    // seperate H, M, am, pm
    var hours = Number(timeString.trim().match(/^(\d+)/)[1]);
    var minutes = Number(timeString.trim().match(/:(\d+)/)[1]);
    var AMPM = timeString.trim().match(/\s(.*)$/)[1];

    // Special cases
    if ( AMPM.toLowerCase() == "pm" && hours < 12 ) hours += 12;
    if ( AMPM.toLowerCase() == "am" && hours == 12 ) hours = 0;
    
    // Convertor
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if ( hours < 10 ) sHours = "0" + sHours;
    if ( minutes < 10 ) sMinutes = "0" + sMinutes;
    return sHours + ":" + sMinutes;;
}

function menuFunc3() {
    $(".stick-bottom").toggle({bottom: '0'}, 1000);
}