function setFilter() {
    var program = document.getElementById("program").value;
    var faculty = document.getElementById("faculty").value;
    document.getElementById("filter_cond").innerHTML = "Program: " + program + "<br> Faculty: " + faculty;

}

function reline() {
    //Make the line between class
    jsPlumb.ready(function () {

        jsPlumb.connect({
            source: 'c12',
            target: 'c10',
            overlays: [['Arrow', { width: 12, length: 12, location: 0.5 }]],
            endpoint: 'Blank',
            anchor: ['Bottom', 'Top'],
            connector: ['Straight']
        })
        jsPlumb.connect({
            source: 'c11',
            target: 'c10',
            overlays: [['Arrow', { width: 12, length: 12, location: 0.5 }]],
            endpoint: 'Blank',
            anchor: ['Bottom', 'Top'],
            connector: ['Straight']
        })

    })

}


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