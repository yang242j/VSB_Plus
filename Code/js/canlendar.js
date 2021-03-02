window.onload = function init(){
    $('tbody').click(function(event){

        let target = event.target;
        console.log(target);

        // let td = event.target.closest('td');

        // if (!td) return;
        // console.log(event.target);
    });
}