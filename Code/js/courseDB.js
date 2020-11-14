function setFilter(){
    var program = document.getElementById("program").value;
    var faculty = document.getElementById("faculty").value;
    document.getElementById("filter_cond").innerHTML = "Program: " + program + "<br> Faculty: " + faculty;
}