function genGraph(sections) {
    //Compute the data for graph
    var lab_count = [0,0,0];
    var lecture_count = [0,0,0];
    var labels_list = ['2020 Spring/Summer', '2020 Fall', '2021 Winter'];
    for (var i in sections) {
        var sec = sections[i];
        // console.log(sec);
        if (sec.schedule_type == 'Lecture'){
            var index = labels_list.indexOf(sec.term);
            lecture_count[index] += 1;
        }else if (sec.schedule_type == 'Lab'){
            var index = labels_list.indexOf(sec.term);
            lab_count[index] += 1;
        }
    }
    // console.log(lecture_count);

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
                label: 'Number of Lab',
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
                label: 'Number of Lecture',
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

function genChart1(data, divId){
  //Compute the data for graph
  var goodGrade = 0;
  var generalGrade = 0;
  var poorGrade = 0;
  var notPass = 0;
  var total_class = 46;

  // Loop the data and compute the datas.
  var labels_list = new Set();
  for (var i in data) {
      var takenCourse = data[i];
      labels_list.add(takenCourse.term);

      var grade = takenCourse.final_grade
      if (grade == 'NP') notPass += 1;
      if (parseInt(grade) >= 80) goodGrade += 1;
      if (parseInt(grade) >= 65) generalGrade += 1;
      if (parseInt(grade) >= 50) poorGrade += 1;
      
  }
  var left_class = total_class - goodGrade - generalGrade - poorGrade; 

  //In case, there is no 'canvas' element in the html
  var canvasID = divId + 'Chart';
  if (!document.getElementById(canvasID)) {
      $('#' + divId).html(createCanvas(canvasID, 100, 100));
  }

  // Get the canvas element to generate the graph
  var ctx = document.getElementById(canvasID).getContext('2d');

  // Set the data and color parameters
  data = {
    datasets: [{
        // data: [goodGrade, generalGrade, poorGrade, notPass, left_class],
        data: [goodGrade, generalGrade, poorGrade, notPass],
        backgroundColor: ['#99CC33','#99CCFF',
        '#FF6666', '#333333','#CCCCCC',
        // 'rgba(54, 162, 235, 0.2)',
        // 'rgba(255, 206, 86, 0.2)',
        // 'rgba(75, 192, 192, 0.2)',
        // 'rgba(153, 102, 255, 0.2)',
    ]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Good Grade',
        'Generate',
        'Poor',
        'NP',
        // 'Untaken',
    ]
};

  var chart = new Chart(ctx, {
      type: 'doughnut',
      data: data,
      options: {}
  });
}

function genChart2(data, divId){
    var grade = {};
    var term_list = [];
    for (var i in data) {
        var takenCourse = data[i];
        var final_grade = parseInt(takenCourse.final_grade);

        if (!Number.isNaN(final_grade)){
            if (term_list.indexOf(takenCourse.term) != -1){
                grade[takenCourse.term].push(final_grade);
            }
            else{
                term_list.push(takenCourse.term);
                grade[takenCourse.term] = [final_grade];
            }
        }
    }

    var ave_grades = [];
    term_list.forEach((term)=>{
        var sum = 0;
        // console.log(term);
        grade[term].forEach((grade_value)=>{sum += grade_value});
        // console.log(sum);
        // console.log(grade[term].length);
        ave_grades.push(sum/grade[term].length);
    });


    //In case, there is no 'canvas' element in the html
    var canvasID = divId + 'Chart';
    if (!document.getElementById(canvasID)) {
        $('#' + divId).html(createCanvas(canvasID, 200, 100));
    }
  
    // Get the canvas element to generate the graph
    var ctx = document.getElementById(canvasID).getContext('2d');
  
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: term_list,
            datasets: [{
                label: 'Performance Semester',
                data: ave_grades,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {scales:{yAxes:[{ticks:{beginAtZero: true}}]}}
    });
}
