function pageUp() {
    document.getElementById("card1").innerHTML = "<h3>Year:</h3>" + "<p>4th</p>" + "<p></p>";
    document.getElementById("card2").innerHTML = "<h3>Average:</h3>" + "<p>75</p>" + "<p></p>";
    document.getElementById("card3").innerHTML = "<h3>GPA:</h3>" + "<p>3.6</p>" + "<p></p>";
    document.getElementById("card4").innerHTML = "<h3>Holds</h3>" + "<p>No Hold</p>" + "<p></p>";
}

function pageDown() {
    document.getElementById("card1").innerHTML = "<h3>Credit Earned:</h3>" + "<p>120/136</p>" + "<p></p>";
    document.getElementById("card2").innerHTML = "<h3>Year:</h3>" + "<p>4th</p>" + "<p></p>";
    document.getElementById("card3").innerHTML = "<h3>Course Left:</h3>" + "<p>6</p>" + "<p></p>";
    document.getElementById("card4").innerHTML = "<h3>GPA:</h3>" + "<p>3.6</p>" + "<p></p>";
}

window.onload = function () {
    loadPieChart(sid);
    loadLineChart(sid);
    console.log("init web")
}

function loadPieChart(sid) {
    // console.log(sid);
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        // console.log(data);
        var jsonData = JSON.parse(data);
        var divId = 'pieChart';
        genChart1(jsonData, divId);
    });
}

function loadLineChart(sid) {
    $.post('Model/takenClass.php', { sid: sid, password: sid }, function (data) {
        var jsonData = JSON.parse(data);
        var divId = 'lineChart';
        genChart2(jsonData, divId);
    });
}
