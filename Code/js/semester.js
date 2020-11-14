function termSelector() {
    var term = document.getElementById("term").value;
    document.getElementById("termDemo").innerHTML = "You selected: " + term;
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function dragEnter(ev) {
    ev.target.style.backgroundColor = "";
}

function dragLeave(ev) {
    ev.target.style.backgroundColor = "";
}

function dropL(ev) {
    var data = ev.dataTransfer.getData("text");
    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        document.getElementsByClassName("left-section")[0].appendChild(document.getElementById(data));
    }
    ev.target.style.backgroundColor = "";
}

function dropBR(ev) {
    var data = ev.dataTransfer.getData("text");
    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        document.getElementsByClassName("bottom-right")[0].appendChild(document.getElementById(data));
    }
    ev.target.style.backgroundColor = "";
}