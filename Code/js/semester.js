const colors = ["lightblue", "lightseagreen", "pink", "yellow", "Azure", "Bisque", "Coral", "Cyan", "Cornsilk", "Lavender"];
var dataList = [];

function termSelector() {
    var term = document.getElementById("term").value;
    document.getElementById("termDemo").innerHTML = "You selected: " + term;
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    console.log("drag", ev.target.id)
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
    var dataTitle = ev.dataTransfer.getData("text");

    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        document.getElementsByClassName("left-section")[0].appendChild(document.getElementById(dataTitle));
        const randomColorIndex = Math.floor(Math.random() * colors.length);
        document.getElementById(dataTitle).style.backgroundColor = colors[randomColorIndex];
        console.log(randomColorIndex, colors[randomColorIndex], dataTitle, "left");

        dataList.push({
            title: dataTitle,
            start: '2021-01-12T10:30:00',
            end: '2021-01-12T12:30:00'
        });
        console.log(dataList);

        draw(dataList);
    }
    ev.target.style.backgroundColor = "";
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
        console.log(randomColorIndex, colors[randomColorIndex], dataTitle, "bottom-right");

        for (var i = 0; i < dataList.length; i++) {
            if (dataList[i].title == dataTitle) { dataList.splice(i, 1); }
        }
        console.log(dataList);

        draw(dataList);
    }
    ev.target.style.backgroundColor = "";
}

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '2021-01-01',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        }
    });
    calendar.render();
});

function draw(data) {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '2021-01-01',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: data
    });
    calendar.render();
}
