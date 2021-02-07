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
    var dataTitle = ev.dataTransfer.getData("Text");
    const randomColorIndex = Math.floor(Math.random() * colors.length);
    var BGC = colors[randomColorIndex];

    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        //1.Append courseTag-list
        document.getElementsByClassName("left-section")[0].appendChild(document.getElementById(dataTitle));
        document.getElementById(dataTitle).style.backgroundColor = BGC;
        //console.log(randomColorIndex, colors[randomColorIndex], dataTitle, "left");

        //2.Append courseCard-list in class="middle-section" id="courseCard_list"
        var course_json = "";
        $.post('../Model/course.php', dataTitle, function(data){
            course_json = data;
        });
        var course_card =
            "<div class='courseInfo' style='background-color:" + BGC + ";>" +
            "<h2>" + course_json.short_name + "</h2>" +
            "<h4>" + course_json.title + "</h4>" +
            "<p>Description: " + course_json.description + "</p>" +
            "</div>";
        document.getElementById("courseCard_list").innerHTML += course_card;

        //3.Append calendar
        calendar.addEvent({
            id: dataTitle,
            title: dataTitle,
            start: '2021-01-12',
            end: '2021-01-13'
        });
    }
    //ev.target.style.backgroundColor = "";
}

function dropBR(ev) {
    var dataTitle = ev.dataTransfer.getData("text");
    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        document.getElementsByClassName("bottom-right")[0].appendChild(document.getElementById(dataTitle));
        const randomColorIndex = Math.floor(Math.random() * colors.length);
        document.getElementById(dataTitle).style.backgroundColor = colors[randomColorIndex];
        //console.log(randomColorIndex, colors[randomColorIndex], dataTitle, "bottom-right");

        calendar.getEventById(dataTitle).remove();
    }
    ev.target.style.backgroundColor = "";
}
