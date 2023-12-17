document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('chart').getContext('2d');
    let chart;

    // Function to create the chart
    function createDoughnutChart(data) {
        if (chart) {
            chart.destroy(); // Destroy the previous chart if it exists
        }

        const colors = ['orange', 'green', 'yellow', 'lightgreen', 'blue', 'lightblue','purple','red'];
        const dataCounts = [0, 0, 0, 0, 0, 0, 0,0];

        data.forEach(cgpa => {
            if (cgpa === 10) {
                dataCounts[0]++;
            } else if (cgpa >= 9 && cgpa < 10) {
                dataCounts[1]++;
            } else if (cgpa >= 8 && cgpa < 9) {
                dataCounts[2]++;
            } else if (cgpa >= 7 && cgpa < 8) {
                dataCounts[3]++;
            } else if (cgpa >= 6 && cgpa < 7) {
                dataCounts[4]++;
            } else if (cgpa >= 5 && cgpa < 6) {
                dataCounts[5]++;
            } else if (cgpa >= 4 && cgpa < 5) {
                dataCounts[6]++;
            } else {
                dataCounts[7]++;
            }
        });

        const percentageData = dataCounts.map(count => ((count / data.length) * 100).toFixed(2));
        chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['10', '9-9.99', '8-8.99', '7-7.99', '6-6.99', '5-5.99', '4-4.99','below 3.99'],
                datasets: [{
                    data: percentageData,
                    backgroundColor: colors,
                    
                }],
            },

            options:{
                borderColor:'#9093bd',
                plugins:{
                    legend:{
                        display:true,
                    },
                },
            },
        });
    }

    // Function to fetch data from PHP
    function fetchData(semester) {
        const url = `fetch-donut.php?semester=${semester}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                createDoughnutChart(data);
            })
            .catch(error => console.error(error));
    }

    // Event listener for dropdown change
    const semesterSelect = document.getElementById('semesterSelect');
    semesterSelect.addEventListener('change', function () {
        const selectedSemester = semesterSelect.value;
        fetchData(selectedSemester);
    });

    fetchData(semesterSelect.value);
});
