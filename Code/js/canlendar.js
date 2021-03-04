var semesters = ['Fall', 'Spring/Summer', 'Winter'];
var termNum = 0;
var startYear = 2015;
var statuColors = {
    'done': 'rgb(146, 141, 141)',
    'satisfy' : 'rgb(125, 233, 104)',
    'tepSatisfy': 'rgb(229, 231, 86)',
    'notSatisfy': 'rgb(224, 59, 59)',
};

var course_data = {
    "short_name" : "BUS 210",
    "title" : "Introduction to Marketing",
    "prerequisite" : "BUS 100 (or ADMN 100) and BUS 260 (or ADMN 260). Concurrent enrolment is allowed in BUS 260"
};

window.onload = function init(){
    $('tbody').click(divToggle);
    // $('#test').append(createBlock(course_data))

    $('.block').bind('dragstart', function(event){
        var data= event.originalEvent.dataTransfer;
		data.setData('text/plain',$(this).attr('id')); // Note: Make sure every block have a id
    });

    $('.cell').bind('dragover',function(e){
        e.originalEvent.preventDefault()
    })

    $('.cell').bind('drop',function(e){
        var text=e.originalEvent.dataTransfer.getData('text/plain')
        $(this).append($('#'+text))
    })

    $('#addColButton').click(function(e){
        addCol();
    });

    // addCol();
}

// Course Block Toggle click event
function divToggle(event){
    // Locate the element
    let div = event.target.closest('div');
    if (div.className != 'short_name') return;

    // Toggle the class 
    let blockDiv = div.parentNode;
    $(blockDiv).toggleClass("showDetail");
}

function createBlock(course_data){
    var $div= $("<div class='block' value='" + course_data.short_name + "'>" +
                    "<div class='short_name'><span class='toLeft'>+</span>" + course_data.short_name + 
                        "<span class='toRight dot'></span>" + 
                    "</div>" + 
                    "<ul>" + 
                        "<li><b>" + course_data.title + "</b></li>" + 
                        "<li><b>Prereq:</b>" + course_data.prerequisite + "</li>" +
                    "</ul>" + 
                "</div>");
    return $div;
}

function addCol(){
    let $col = $("<col width='200'>");
    $('colgroup').append($col);

    // Insert the titles to the title row
    let $th = $("<th>Term " + getTermNum + "<br> " + getYear() + " Fall<br>(Done)</th>");
    $th.insertBefore($('#addColButton'));
    
    // Insert cells to the default row and schedule row
    let $row1 = $("<td><div class='cell'></div></td> ")
    let $row2 = $("<td><div class='cell'></div></td> ")
    $('#defaultRow').append($row1);
    $('#scheduleRow').append($row2)
}

function getYear(){
    termNum / semesters.length()
}

function getSemester(){
    return semesters[termNum % semesters.length];
}

function getTermNum(){
    return termNum + 1;
}

