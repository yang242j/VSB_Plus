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

function dropL(ev) {
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
            document.getElementById(short_name).classList.toggle("selected-course"); // Add selected-course class
            //2.Append courseCard-list
            appendCourseCard(short_name, BGC);
            pre_colorID = randomColorIndex; //2.1.Store color id
            //3.Append calendar
            appendCalendar(short_name);
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
        document.getElementById(short_name).classList.toogle =("selected-course"); // Remove selected-course class
        // Remove course card from middle section
        removeCourseCard(short_name);
        // Remove course event from calendar
        removeCalendar(short_name);
        
    }
}

function appendCourseCard(short_name, BGC) {
    
    $.post('Model/course.php', { short_name: short_name }, function(data) {
        var course_json = JSON.parse(data);
        var card_id = course_json.short_name + "_Card";
        var course_card =
            "<div class='courseInfo' id='" + card_id +
            "' style='background-color:" + BGC + ";'>" +
            "<h2>" + course_json.short_name + "</h2>" +
            "<h4>" + course_json.title + "</h4>" +
            "<p>Description: " + course_json.description + "</p>" +
            "</div>";
        document.getElementById("courseCardList").innerHTML += course_card;
    });
}

function removeCourseCard(short_name) {
    var card_id = short_name + "_Card";
    if (document.getElementById(card_id).remove()) {
        console.log(card_id + " remove SUCCESS");
    } else {
        console.log(card_id + " remove FAILED");
    }
}

function appendCalendar(short_name) {
    calendar.addEvent({
        id: short_name,
        title: short_name,
        start: '2021-01-12',
        end: '2021-01-13'
    });
}

function removeCalendar(short_name) {
    if (calendar.getEventById(short_name).remove()) {
        console.log("Calendar event " + short_name + " remove SUCCESS");
    } else {
        console.log("Calendar event " + short_name + " remove FAILED");
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