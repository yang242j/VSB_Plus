var isMobile = window.matchMedia('(max-width: 1080px)').matches
if (isMobile) $(".menu-icon").click();

/* When the user clicks on the nav-right buttons,
toggle between hiding and showing the content with id */
function toogleDisplay(id) {
  document.getElementById(id).classList.toggle("hidden");
}

// Menu toggle function
function menuFunc1(x) {
    x.classList.toggle("change");
}

function menuFunc2(x) {
    var element = document.getElementsByClassName(x);
    
    for (var i = 0; i < element.length; i++) {
        element[i].classList.toggle("hidden");
    }

}

// Help to parse the json datas
function allParse(response){
    var result = [];
    var all = JSON.parse(response);
    for (index = 0; index < all.length; index++){
        var course = JSON.parse(response[index]);
        result.push(course);
    }
    return result;
}

// Example to get basic infomation by using AJAX
function getBasicInfo($sid, $jsonResult){
    $.post('./Api.php/Student/BasicInfo', {'sid': $sid}, function(data){
        json = JSON.parse(data)
        console.log(json["data"].name);
        $jsonResult =  json["data"];
    });
}

