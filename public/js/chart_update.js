let amountOfContainerGarbageChart = new Chart(document.getElementById('container_distance_chart'), {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Een leuke label hier',
            data: [],
            borderWidth: 1,
            borderColor: "#DC3545",
            lineTension: 0.5,
            backgroundColor: 'rgba(255, 255, 255, 0.0)'
        }]
    },
    options: {
        legend: {
            display: false,
        },
        title: {
            display: true,
            fontColor: "#FFF",
            fontSize: 20,
            text: 'Container Distance'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    fontColor: 'white'
                },
            }],
            xAxes: [{
                ticks: {
                    fontColor: 'white'
                },
            }]
        }
    }
});
let amountOfAllContainerGarbageChart = new Chart(document.getElementById('garbage_all_chart'), {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'All containers',
            data: [],
            borderWidth: 1,
            borderColor: "#DC3545",
            lineTension: 0.5,
        }]
    },
    options: {
        legend: {
            display: false,
        },
        title: {
            display: true,
            fontColor: "#FFF",
            fontSize: 20,
            text: 'All containers in this city'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    fontColor: 'white'
                },
            }],
            xAxes: [{
                ticks: {
                    fontColor: 'white'
                },
            }]
        }
    }
})

// let updateGarbageChart = () => {
//     $.ajax({
//         url: '/dashboard/chart/container_distance',
//         type: 'GET',
//         dataType: 'JSON',
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(data) {
//             amountOfContainerGarbageChart.data.labels = data.labels;
//             amountOfContainerGarbageChart.data.datasets[0].data = data.data;
//             amountOfContainerGarbageChart.update();
//         },
//         error: function(data) {
//             console.log(data);
//         }
//     });
// }
// let updateGarbageAllChart = () => {
//     $.ajax({
//         url: '/dashboard/chart/all_container_distance',
//         type: 'GET',
//         dataType: 'JSON',
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(data) {
//             amountOfAllContainerGarbageChart.data.labels = data.labels;
//             amountOfAllContainerGarbageChart.data.datasets[0].data = data.data;
//             amountOfAllContainerGarbageChart.update();
//         },
//         error: function(data) {
//             console.log(data);
//         }
//     });
// }

let updateAllCharts = () => {
    $.ajax({
        url: '/dashboard/chart/update_realtime_containers',
        type: 'GET',
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            amountOfContainerGarbageChart.data.labels = data.container_distance_chart_labels;
            amountOfContainerGarbageChart.data.datasets[0].data = data.container_distance_chart_data;

            amountOfAllContainerGarbageChart.data.labels = data.container_distance_chart_for_all_cities_labels;
            amountOfAllContainerGarbageChart.data.datasets[0].data = data.container_distance_chart_for_all_cities_data;

            amountOfAllContainerGarbageChart.update();
            amountOfContainerGarbageChart.update();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

/**
 * Updates your charts every second
 */
setInterval(() => {
    updateAllCharts();
    // updateGarbageChart();
    // updateGarbageAllChart();
}, 1000)
