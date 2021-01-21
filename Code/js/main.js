/* When the user clicks on the nav-right buttons, 
toggle between hiding and showing the dropdown content */
function dropdownFunc() {
    document.getElementById("dropdown-menu").style.display = "block";
}

// Close the dropdown if the user clicks outside of it
var dropbtn = document.getElementById("dropbtn");
var usrimg = document.getElementById("usrimg");
var usertext = document.getElementById("usertext");
window.onclick = function(event) {
    if (event.target != dropbtn && event.target != usrimg && event.target != usertext) { 
        document.getElementById("dropdown-menu").style.display = "none";
        //console.log(dropbtn);
    }
    //console.log(document.getElementById("dropdown-menu").style.display);
}