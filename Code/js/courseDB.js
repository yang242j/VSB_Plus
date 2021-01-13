document.getElementById("classification").addEventListener("click",function(e){
    //Select the different faulties
    var target = e.target;
    var nodeId = target.id;
    var nodeClass = target.getAttribute("class");

    if (target.nodeName==="DIV" && nodeId == ""){
        if (nodeClass.search("selected") == -1){
            target.classList.add("selected");
        }
        else{
            target.classList.remove("selected");
        }
    }
});

document.getElementById("display_change").addEventListener("click",function(e){
    var target = document.getElementById("course_list");
    var nodeClass = target.getAttribute("class");

    if (nodeClass.search("tow_course_show") == -1){
        target.classList.add("tow_course_show");
    }
    else{
        target.classList.remove("tow_course_show");
    }
});


function setFilter() {
    var program = document.getElementById("program").value;
    var faculty = document.getElementById("faculty").value;
    document.getElementById("filter_cond").innerHTML = "Program: " + program + "<br> Faculty: " + faculty;

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