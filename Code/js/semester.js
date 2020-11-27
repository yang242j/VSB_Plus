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
    var data = ev.dataTransfer.getData("text");
    const colors = ["#B73225", "#DCE1E3", "#DDAF94"];
    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        document.getElementsByClassName("left-section")[0].appendChild(document.getElementById(data));
        const randomColorIndex = Math.floor(Math.random() * colors.length);
        document.getElementById(data).style.backgroundColor = colors[randomColorIndex];
        console.log(randomColorIndex, colors[randomColorIndex], data, "bottom-right");
    }
    ev.target.style.backgroundColor = "";
}

function dropBR(ev) {
    var data = ev.dataTransfer.getData("text");
    const colors = ["#B73225", "#DCE1E3", "#DDAF94"];
    if (ev.target.classList.contains("noDrop")) {
        ev.preventDefault();
    } else {
        ev.preventDefault();
        document.getElementsByClassName("bottom-right")[0].appendChild(document.getElementById(data));
        const randomColorIndex = Math.floor(Math.random() * colors.length);
        document.getElementById(data).style.backgroundColor = colors[randomColorIndex];
        console.log(randomColorIndex, colors[randomColorIndex], data, "bottom-right");
    }
    ev.target.style.backgroundColor = "";
}