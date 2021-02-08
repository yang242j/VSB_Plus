const colors = ["lightblue", "lightseagreen", "pink", "yellow", "Azure", "Bisque", "Coral", "Cyan", "Cornsilk", "Lavender"];

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

function termSelector() {
    var term = document.getElementById("term").value;
    document.getElementById("termDemo").innerHTML = "You selected: " + term;
}

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
    const randomColorIndex = Math.floor(Math.random() * colors.length);
    var BGC = colors[randomColorIndex];

    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        //1.Append courseTag-list
        document.getElementsByClassName("left-section")[0].appendChild(document.getElementById(short_name));
        document.getElementById(short_name).style.backgroundColor = BGC;
        //console.log(short_name);

        //if exampleDiv exist, remove
        if($("#exampleDiv").length){	
            $( "#exampleDiv" ).remove();
        }

        //if tag exist, refuse to append
        var tagExist = $("#" + short_name).parents(".left-section").length == 1;
        if ( tagExist ) {
            console.log(short_name + " already exist in course List");
            $("#" + short_name).parents(".left-section").css({"color": "red", "border": "2px solid red"});
        } else {
            //2.Append courseCard-list
            appendCourseCard(short_name, BGC);
            //3.Append calendar
            appendCalendar(short_name);
        }
    }
    //ev.target.style.backgroundColor = "";
}

function dropBR(ev) {
    var short_name = ev.dataTransfer.getData("text");
    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        document.getElementsByClassName("bottom-right")[0].appendChild(document.getElementById(short_name));
        const randomColorIndex = Math.floor(Math.random() * colors.length);
        document.getElementById(short_name).style.backgroundColor = colors[randomColorIndex];
        //console.log(randomColorIndex, colors[randomColorIndex], short_name, "bottom-right");

        calendar.getEventById(short_name).remove();
    }
    ev.target.style.backgroundColor = "";
}

function appendCourseCard(short_name, BGC) {
    
    $.post('Model/course.php', { short_name: short_name }, function(data) {
        var course_json = JSON.parse(data);
        var course_card =
            "<div class='courseInfo' id=" + course_json.short_name +
            " style='background-color:" + BGC + ";'>" +
            "<h2>" + course_json.short_name + "</h2>" +
            "<h4>" + course_json.title + "</h4>" +
            "<p>Description: " + course_json.description + "</p>" +
            "</div>";
        document.getElementById("courseCard_list").innerHTML += course_card;
    });
}

function appendCalendar(short_name) {
    calendar.addEvent({
        id: short_name,
        title: short_name,
        start: '2021-01-12',
        end: '2021-01-13'
    });
}
