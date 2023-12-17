<!DOCTYPE html>
<html>
<head>
  <title>Student Data Visualization</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="./MYsrc/MYstudent.css">

        <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #rollNumberInput {
            padding: 10px;
            font-size: 16px;
            border: 1.5px solid black; /* Google blue color */
            border-radius: 4px;
            margin-right: 10px;
        }

        #submitBTN {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4285F4; /* Google blue color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #submitBTN:hover {
            background-color: #1A73E8; /* Slightly darker blue on hover */
        }
    </style>

</head>
<body>
  <div id="myHead" style="background:lightgreen">
    <h3 align="center" style="color:black">SACHIN VERMA</h3>
    <h2 align="center" style="color:black">PROJECT: STUDENTS RESULTS DATA VISUALIZATION WEB APP</h2>
    </div>

     <div>
    <input type="text" id="rollNumberInput" placeholder="Enter Roll Number eg. 101">
    <button id="submitBTN" onclick="showData()">Show Result</button>
    <hr>
 </div>
    
    
   <div id="studentInfo" class="chart-box" style="display: none;">
  <h2 align="center">SEM IV</h2><hr>
  <h2 align="left">Student Name: <span id="studentNameText"></span></h2>
  <h2 align="left">Roll Number: <span id="rollNumberText"></span></h2>
  <h2 align="left">Grade: <span id="gradeText"></span></h2>
  <h2 align="left">Rank: <span id="rankText"></span></h2>
   </div>

 

  <div class="chart-box">
  <table id="data-table"></table>
  </div>



    <div class="chart-box">
    <canvas id="myStackedBarChart"></canvas>
    </div>
    

  <div class="chart-box">
    <canvas id="myLineChart"></canvas>
  </div>



  <script>
    let studentData = [];
let myStackedBarChart;
let myLineChart;

async function fetchData() {
                    const response = await fetch('getDataStudent.php');
                    if (!response.ok) {
                        throw new Error('Failed to fetch data');
                    }
                    const data = await response.json();
                    studentData = data;
                    return studentData;
                }




async function displayTable(student) {
  const table = document.getElementById('data-table');

  
  while (table.firstChild) {
    table.removeChild(table.firstChild);
  }

  const tableHeader = document.createElement('tr');
  const headerColumns = ['Subjects', 'Internal', 'Practical', 'Theory', 'Semesters', 'SGPI'];

  headerColumns.forEach((column) => {
    const th = document.createElement('th');
    th.textContent = column;
    tableHeader.appendChild(th);
  });

  table.appendChild(tableHeader);

  let totalInternal = 0;
  let totalPractical = 0;
  let totalTheory = 0;

  const studentSubjects = studentData.filter((data) => data.rollNumber === student.rollNumber);

  studentSubjects.forEach((data, index) => {
    const row = document.createElement('tr');

    const subjectCell = document.createElement('td');
    subjectCell.textContent = data.subjects;
    row.appendChild(subjectCell);

    const internalCell = document.createElement('td');
    const internalScore = data.internal;
    internalCell.textContent = internalScore;
    if (internalScore < 10) {
      internalCell.style.backgroundColor = 'red';
    }
    row.appendChild(internalCell);
    totalInternal += internalScore;

    const practicalCell = document.createElement('td');
    const practicalScore = data.practical;
    practicalCell.textContent = practicalScore;
    if (practicalScore < 20) {
      practicalCell.style.backgroundColor = 'red';
    }
    if (index === studentSubjects.length - 1) {
      practicalCell.style.backgroundColor = 'rgba(185,185,185, 1)';
      practicalCell.textContent = 'NA';
    }
    row.appendChild(practicalCell);
    totalPractical += practicalScore;

    const theoryCell = document.createElement('td');
    const theoryScore = data.theory;
    theoryCell.textContent = theoryScore;
    if (theoryScore < 30) {
      theoryCell.style.backgroundColor = 'red';
    }
    row.appendChild(theoryCell);
    totalTheory += theoryScore;
    
    const semesterCell = document.createElement('td');
    semesterCell.textContent = data.semester;
    if (index === studentSubjects.length - 1) {
      semesterCell.style.backgroundColor =  'rgba(185,185,185, 1)';
    }
    row.appendChild(semesterCell);

    const cgpaCell = document.createElement('td');
    cgpaCell.textContent = data.CGPA;

    if (index === studentSubjects.length - 1) {
      cgpaCell.style.backgroundColor =  'rgba(185,185,185, 1)';
      cgpaCell.textContent="";
    }

    row.appendChild(cgpaCell);

    table.appendChild(row);
  });

  const totalRow = document.createElement('tr');

  const totalLabelCell = document.createElement('td');
  totalLabelCell.textContent = 'Total';
  totalLabelCell.setAttribute('colspan', '5');
  totalRow.appendChild(totalLabelCell);

  const totalSumCell = document.createElement('td');
  const totalSum = totalInternal + totalPractical + totalTheory;
  totalSumCell.textContent = totalSum;
  totalRow.appendChild(totalSumCell);

  table.appendChild(totalRow);

  // Calculate rank based on total score
  const studentScores = studentData.reduce((scores, data) => {
    const rollNumber = data.rollNumber;
    const score = data.internal + data.practical + data.theory;
    
    if (!scores[rollNumber]) {
      scores[rollNumber] = score;
    } else {
      scores[rollNumber] += score;
    }
    
    return scores;
  }, {});

  const sortedStudents = Object.entries(studentScores)
    .sort(([, scoreA], [, scoreB]) => scoreB - scoreA);

  const rank = sortedStudents.findIndex(([rollNumber]) => rollNumber === student.rollNumber) + 1;
  const totalStudents = sortedStudents.length;

  const rankText = document.getElementById('rankText');
  rankText.textContent = `${rank}/${totalStudents}`;
  
}


    async function chartStackedBar(student) {
      const subjects = [];
      const internalScores = [];
      const practicalScores = [];
      const theoryScores = [];

      studentData.forEach(data => {
        if (data.rollNumber === student.rollNumber) {
          subjects.push(data.subjects);
          internalScores.push(data.internal);
          practicalScores.push(data.practical);
          theoryScores.push(data.theory);
        }
      });

      const stackedData = {
        labels: subjects,
        datasets: [
          {
            label: 'Internal 25M',
            data: internalScores,
            backgroundColor: 'rgba(0,96,200,0.8)',
            borderColor: 'rgba(0,0,0,1)',
            borderWidth: 0,
          },
          {
            label: 'Practical 50M',
            data: practicalScores.slice(0, -1),
            backgroundColor: 'rgba(246,53,0,0.8)',
            borderColor: 'rgba(0,0,0,1)',
            borderWidth: 0,
          },
          {
            label: 'Theory 75M',
            data: theoryScores,
            backgroundColor: 'rgba(44, 158, 0, 1)',
            borderColor: 'rgba(1, 1, 1, 1)',
            borderWidth: 0,
          },
        ],
      };

      const stackedConfig = {
        type: 'bar',
        data: stackedData,
        options: {
          scales: {
            x: {
              stacked: true,
            },
            y: {
              beginAtZero: true,
              min: 0,
              max: 150,
              ticks: {
                stepSize: 15,
              },
              stacked: true,
            },
          },
        },
        plugins: [window.ChartDataLabels],
      };

      if (myStackedBarChart) {
        myStackedBarChart.destroy();
      }

      myStackedBarChart = new Chart(document.getElementById('myStackedBarChart'), stackedConfig);
    }

    async function chartLine(student) {
        const semesters = [];
        const cgpaScores = [];

        studentData.forEach(data => {
          if (data.rollNumber === student.rollNumber) {
            semesters.push(data.semester);
            cgpaScores.push(data.CGPA);
          }
        });


  

  const lineData = {
    labels: semesters.slice(0, -1),
    datasets: [
      {
        label: 'SGPI',
        data: cgpaScores.slice(0, -1), // Remove the last element from the data array
        backgroundColor: ['rgba(0,96,200,0.8)'],
        fill: false,
        borderColor: 'rgba(0,0,0,1)',
        borderWidth: 2,
        pointRadius: 5,
        pointBackgroundColor: ['rgba(0,96,200,0.8)'],
        pointBorderColor: 'rgba(0,0,0,1)',
      },
    ],
  };

  const lineConfig = {
  type: 'line',
  data: lineData,
  options: {
    scales: {
      x: {
        grid: {
          display: false,
        },
      },
      y: {
        beginAtZero: true,
        min: 0,
        max: 10,
        ticks: {
          stepSize: 1,
        },
      },
    },
    plugins: {
      tooltip: {
        enabled: true
      },
      legend: {
        display: true 
      },
      datalabels: {
        display: true,
        anchor: 'end', 
        align: 'top',
        offset: 2,
        color: 'rgba(0, 0, 0, 1)',
        font: {
          weight: 'bold',
          size: 15,
        },
        formatter: function (value) {
          return value.toFixed(2);
        },
      },
    },
  },

      
        plugins: [window.ChartDataLabels],
      };

  if (myLineChart) {
    myLineChart.destroy(); // Destroy existing line chart
  }

  myLineChart = new Chart(document.getElementById('myLineChart'), lineConfig);
}



async function showData() {
  const rollNumberInput = document.getElementById('rollNumberInput');
  const rollNumberText = document.getElementById('rollNumberText');
  const studentNameText = document.getElementById('studentNameText');
  const gradeText = document.getElementById('gradeText');
  const studentInfo = document.getElementById('studentInfo');
  const chartBoxes = document.getElementsByClassName('chart-box');
  const rollNumber = rollNumberInput.value;

   
  

  if (rollNumber.trim() === '') {
    alert('Please enter a roll number.');
    return;
  }

  const student = studentData.find(data => data.rollNumber === rollNumber);

  if (student) {
    rollNumberText.textContent = student.rollNumber;
    studentNameText.textContent = student.student_name;
    gradeText.textContent = student.grade;
    await displayTable(student);
    await chartStackedBar(student);
    await chartLine(student);
    studentInfo.style.display = 'block'; 
    Array.from(chartBoxes).forEach(box => {
     box.style.display = 'block';
   });
    rollNumberInput.style.display = 'none';
    submitBTN.style.display='none';

  } else {
    alert('No data found for the entered roll number.');
    studentInfo.style.display = 'none'; // Hide 
  }
}

    

document.addEventListener("DOMContentLoaded", function() {
            fetchData().then(() => {
              displayTable(student);
              chartStackedBar(student);
              chartLine(student);
            });
        });
    
    
  </script>
  
</body>
</html>