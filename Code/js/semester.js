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
            //2.Fetch JSON data
            var [course_data, section_data] = fetchJSONData(short_name, term);
            //3.Append courseCard-list
            appendCourseCard(course_data, BGC);
            pre_colorID = randomColorIndex; //2.1.Store color id
            //4.Append calendar
            appendCalendar(section_data);
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

function fetchJSONData(short_name, term) {
    var course_data, section_data;
    $.post('Model/course.php', { short_name: short_name }, function(data1) {
        course_data = data1;
    });
    $.post('Model/section.php', { short_name: short_name, term: term }, function(data2) {
        section_data = data2;
    });
    return [course_data, section_data];
}

function appendCourseCard(course_data, BGC) {
    console.log(JSON.parse(course_data));
    var course_json = JSON.parse(course_data);
    var card_id = course_json["short_name"] + "_Card";
    var course_card =
        "<div class='courseInfo' id='" + card_id +
        "' style='background-color:" + BGC + ";'>" +
        "<h2>" + course_json['short_name'] + "</h2>" +
        "<h4>" + course_json['title'] + "</h4>" +
        "<p>Description: " + course_json['description'] + "</p>" +
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

function appendCalendar(section_json) {
    calendar.addEvent({
        id: section_json['short_name'],
        title: section_json['short_name'],
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