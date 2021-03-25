/**
 * @param   {string}      inputText       the text field element
 */
function autocomplete(inputText, array2Check) {

    var currentFocus;
  
    /*execute when someone writes in the text field:*/
    inputText.addEventListener("input", function(e) {
        
        var a, i, val = this.value;
        
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        
        /*for each object in the array...*/
        for (i = 0; i < array2Check.length; i++) {

            /*check if the shortName of the course object starts with the same letters as the text field value:*/
            if (array2Check[i].short_name.toUpperCase().includes(val.toUpperCase())) {

                /*Define val.index */
                valIndex = array2Check[i].short_name.toUpperCase().indexOf(val.toUpperCase());
                
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                
                /*make the matching letters bold:*/
                b.innerHTML = array2Check[i].short_name.substr(0, valIndex);
                b.innerHTML += "<strong>" + array2Check[i].short_name.substr(valIndex, val.length) + "</strong>";
                b.innerHTML += array2Check[i].short_name.substr(val.length);
                
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + array2Check[i].short_name + "'>";
                
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inputText.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values, (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }

            /*check if the title of the course object starts with the same letters as the text field value:*/
            if (array2Check[i].title.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + array2Check[i].title.substr(0, val.length) + "</strong>";
                b.innerHTML += array2Check[i].title.substr(val.length);
                
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + array2Check[i].short_name + "'>";
                
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inputText.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values, (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    
    /*execute when a key on the keyboard is pressed:*/
    inputText.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        
        if (x) x = x.getElementsByTagName("div");
        
        if (e.keyCode == 40) {  //down
            /*If the arrow DOWN key is pressed, increase the currentFocus variable:*/
            currentFocus++;
            /*and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed, decrease the currentFocus variable:*/
            currentFocus--;
            /*and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {   //enter
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document, except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inputText) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}
