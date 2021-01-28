// Setup the gobal varible.
var colors = [
    "#99CCCC",
    "#CCFF99",
    "#99CCFF",
    "#CCFFFF",
    "#e4e2e2bd"
];

var seleFaculty = [];
var ALL_JSON;
var num_perid = 100;

window.onload = function init(){
    loadCourses();
}

function loadCourses(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        
        if (this.readyState == 4 && this.status == 200){
            // alert("ok");
            var jsonResponse = JSON.parse(this.responseText);
            loadCourseData(jsonResponse);
            ALL_JSON = jsonResponse;
        }
    };
    xhttp.open("GET", "JSON/ALL.json", false);
    xhttp.send();
}

function loadCourseData(json){
    length = Math.min(json.length, num_perid);
    for (index = 0; index < length; index++){
        addCourse(json[index], index);
    }
}

function addCourse(course_json, index){
    var color = colors[index % colors.length];
    var course_card = "<div class='course shadow round word_overflow' style='background-color:" + 
    color + ";' value='"+ course_json.short_name +"' onclick=\'courseSelect(this)\'>" +  
    "<span class='larger'>" + course_json.short_name + "</span>" + 
    "<div class='left credit'>" + course_json.credit + ".00 Credits</div>" + 
    "<br> <span class='bold'>" + course_json.title + "</span>" + 
    "<div class='description'>" + 
    "<span class='bold smaller'>Description: </span>"+
    "<span class='smaller'>" + course_json.description + "</span>" +
    "</div>"+
    "</div>"

    document.getElementById("course_list").innerHTML += course_card;
}

function courseSelect(event){
    var short_name = event.getAttribute("value");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.status == 404){
            document.getElementById("message").innerHTML = short_name + " cannot be found";
        }
        if (this.readyState == 4 && this.status == 200){
            var jsonRsp = JSON.parse(this.responseText);
            setCourse(jsonRsp);
            document.getElementById("message").innerHTML = short_name + " has been selected";
        }
    };
    // xmlhttp.open("GET", "getCourse.php?short_name=" + short_name, false);
    var json_url = "JSON/202020/" + short_name + ".json";
    xmlhttp.open("GET", json_url, false);
    xmlhttp.send();
}

function setCourse(jsonRsp){
    var detail = "<h2 id='title'>" + jsonRsp.short_name +"</h2>" + 
    "<ul>" +
        "<li><span class='bold'>Course Name</span>: <span id='fullName'>" + jsonRsp.title + "</span> </li>" +
        "<li>***<span class='bold'>Prerequisites</span>: <span id='preReqClass'>" + jsonRsp.prerequisite + "</span> ***</li>" +
        // <li>Labels: Project Class, *****</li>
        "<li><span class='bold'>Course Description</span>: " + jsonRsp.description + "</li>" 
        // "<li>Professor have taught: </li>"
    "</ul>"

    document.getElementById("popView").innerHTML = detail;
}

document.getElementById("classification").addEventListener("click",function(e){
    //Select the different faulties
    var target = e.target;
    var nodeId = target.id;
    var nodeClass = target.getAttribute("class");

    if (target.nodeName==="DIV" && nodeId == ""){
        if (nodeClass.search("selected") == -1){
            target.classList.add("selected");
            seleFaculty.push(target.innerHTML);
        }
        else{
            target.classList.remove("selected");
            var deleInde = seleFaculty.indexOf(target.innerHTML);
            seleFaculty.splice(deleInde, 1);
        }
    }
    reloadCourse();
});

function reloadCourse(){
    $("#course_list").empty();
    var loadData = [];
    if (seleFaculty.length == 0){
        loadData = ALL_JSON;
    }
    else{
        for(i = 0; i < ALL_JSON.length; i++){
            if(seleFaculty.find(element => element == ALL_JSON[i].faculty) != undefined){
                var insert = ALL_JSON[i];
                loadData.push(insert)
            }   
        }
    }
    loadCourseData(loadData);
}


document.getElementById("display_change").addEventListener("click",function(e){
    var target = document.getElementById("course_list");
    var nodeClass = target.getAttribute("class");

    if (nodeClass.search("tow_course_show") == -1){
        target.classList.add("tow_course_show");
        $(".credit").hide();
        $(".description").hide();
    }
    else{
        target.classList.remove("tow_course_show");
        $(".credit").show();
        $(".description").show();
    }
});

function courseSearch() {
    var element = document.getElementById("course_input");
    var input = element.value;
    element.setAttribute("value", input);
    courseSelect(element);
    // if (courseSelect(ele) == 404 ){
    //     // alert(courseSelect(ele));
    //     document.getElementById("message").innerHTML = input + " cannot be found";
    // }
    // // alert(courseSelect(ele))
    // document.getElementById("message").innerHTML = input + " has been selected";
}

function reline() {
    //Make the line between class
    jsPlumb.ready(function () {
        var common = {
            endpoint: 'Blank',
            anchor: ['Bottom', 'Top'],
            connector: ['Flowchart']
        }
        jsPlumb.connect({
            source: 'c12',
            target: 'c10',
            // overlays: [['Arrow', { width: 12, length: 12, location: 0.5 }]],
        }, common)
        jsPlumb.connect({
            source: 'c11',
            target: 'c10',
            // overlays: [['Arrow', { width: 12, length: 12, location: 0.5 }]],
        }, common)
        jsPlumb.draggable('c10')
    })

}
// reline()



$(document).ready(function () {
    var isHiden = false;	/*inital box status*/
    var eleid = 'c1';
    var titleObj = document.getElementById('title');
    var nameObj = document.getElementById('fullName');
    var preReqObj = document.getElementById('preReqClass');
    $('#c1').click(function () {
        titleObj.innerHTML = "ENSE 400";
        nameObj.innerHTML = "Systems Engineering Design Project";
        preReqObj.innerHTML = 'ENSE 470';
        if (eleid != 'c1'){
            if (isHiden) {
                $('#popView').animate({ right: '+=45%' });//box move right 
                isHiden = !isHiden;
            } else {
                $('#popView').animate({ right: '-=45%' }); //box move left
                $('#popView').animate({ right: '+=45%' });//box move right 
            }
            eleid = 'c1'
            return
        }
        if (isHiden) {
            $('#popView').animate({ right: '+=45%' });//box move right 
        } else {
            $('#popView').animate({ right: '-=45%' }); //box move left
        }
        eleid = 'c1'
        isHiden = !isHiden;
    });

    $('#c2').click(function () {
        titleObj.innerHTML = "ENEL 387";
        nameObj.innerHTML = "Microcontroller System Design";
        preReqObj.innerHTML = 'ENSE 352, ENEL 384';
        if (eleid != 'c2'){
            if (isHiden) {
                $('#popView').animate({ right: '+=45%' });//box move right 
                isHiden = !isHiden;
            } else {
                $('#popView').animate({ right: '-=45%' }); //box move left
                $('#popView').animate({ right: '+=45%' });//box move right 
            }
            eleid = 'c2'
            return
        }
        if (isHiden) {
            $('#popView').animate({ right: '+=45%' });//box move right 
        } else {
            $('#popView').animate({ right: '-=45%' }); //box move left
        }
        eleid = 'c2'
        isHiden = !isHiden;
    });
});