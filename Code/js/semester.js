const colors = ["lightblue", "lightseagreen", "pink", "yellow", "Azure", "Bisque", "Coral", "Cyan", "Cornsilk", "Lavender"];
var pre_colorID = "";

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
    events: []
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
                
                //4.Fetch Lecture Section JSON data
                fetchSectionJSON(short_name, schedule_type="Lecture", term).done(function (result2) {
                    var section_json_obj = JSON.parse(result2);
                    //5.Append calendar
                    appendCalendar(section_json_obj, BGC);
                }).fail(function () {
                    console.error(short_name + "Leccture Section JSON Fetch ERROR");
                });
                
                //6. Fetch Laboratory Section JSON data
                fetchSectionJSON(short_name, schedule_type="Laboratory", term).done(function (result2) {
                    var section_json_obj = JSON.parse(result2);
                    //7.Append calendar
                    appendCalendar(section_json_obj, BGC);
                }).fail(function () {
                    console.error(short_name + "Laboratory Section JSON Fetch ERROR");
                });

                //8. Fetch Examination Section JSON data
                fetchSectionJSON(short_name, schedule_type="Examination", term).done(function (result2) {
                    var section_json_obj = JSON.parse(result2);
                    //9.Append calendar
                    appendCalendar(section_json_obj, BGC);
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

function appendCalendar(section_json, BGC) {
    var myObj = {
        Term: term,            
        Course_List: courseList,
        Course_Completed: courseCompletedList,
        Course_Recommended: courseRecommendedList,
    };
    console.log(section_json);
    
    calendar.addEvent({
        id: section_json.short_name,
        title: section_json.short_name,
        start: '2021-01-12',
        end: '2021-01-13'
    });
}

function removeCalendar(short_name) {
    try {
        calendar.getEventById(short_name).remove();
    } catch (e) {
        console.error("Calendar event" + short_name + " remove FAILED");
    }
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

function menuFunc3() {
    $(".stick-bottom").toggle({bottom: '0'}, 1000);
}