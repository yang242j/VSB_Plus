function genGraph(sections) {
    //Compute the data for graph
    var lab_count = [0,0,0];
    var lecture_count = [0,0,0];
    var labels_list = ['2020 Spring/Summer', '2020 Fall', '2021 Winter'];
    for (var i in sections) {
        var sec = sections[i];
        console.log(sec);
        if (sec.schedule_type == 'Lecture'){
            var index = labels_list.indexOf(sec.term);
            lecture_count[index] += 1;
        }else if (sec.schedule_type == 'Lab'){
            var index = labels_list.indexOf(sec.term);
            lab_count[index] += 1;
        }
    }
    console.log(lecture_count);

    //In case, there is no 'canvas' element in the html
    if (!document.getElementById('chart')) {
        $('#graph').html(createCanvas('chart', 200, 200));
    }

    // Get the canvas element to generate the graph
    var ctx = document.getElementById("chart").getContext('2d');

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels_list,
            datasets: [{
                label: 'Lab count',
                data: lab_count,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                    // 'rgba(54, 162, 235, 0.2)',
                    // 'rgba(255, 206, 86, 0.2)',
                    // 'rgba(75, 192, 192, 0.2)',
                    // 'rgba(153, 102, 255, 0.2)',
                    // 'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)'
                    // 'rgba(54, 162, 235, 1)',
                    // 'rgba(255, 206, 86, 1)',
                    // 'rgba(75, 192, 192, 1)',
                    // 'rgba(153, 102, 255, 1)',
                    // 'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            },{
                label: 'Lecture count',
                data: lecture_count,
                backgroundColor: [
                    // 'rgba(255, 99, 132, 0.2)',
                    // 'rgba(54, 162, 235, 0.2)',
                    // 'rgba(255, 206, 86, 0.2)',
                    // 'rgba(75, 192, 192, 0.2)',
                    // 'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    // 'rgba(255, 99, 132, 1)',
                    // 'rgba(54, 162, 235, 1)',
                    // 'rgba(255, 206, 86, 1)',
                    // 'rgba(75, 192, 192, 1)',
                    // 'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {scales:{yAxes:[{ticks:{beginAtZero: true}}]}}
    });

}

function createCanvas(id, width, height) {
    var canvasNode = document.createElement('canvas');
    canvasNode.id = id;
    canvasNode.width = width;
    canvasNode.height = height;
    return canvasNode;
}

function showGraph(name){
    var short_name = {'short_name':name};
    $.post('Model/section.php', short_name, function (data, status) {
        genGraph(JSON.parse(data));
        // return JSON.parse(data);
    });
}