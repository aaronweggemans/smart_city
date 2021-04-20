console.log('Realtime chart imported...');

let ctx = document.getElementById('chart_realtime_update');
let myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Een leuke label hier',
            data: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            xAxes: [],
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
        }
    }
});

let updateChart = () => {
    $.ajax({
        url: '/dashboard/chart/data',
        type: 'GET',
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            myChart.data.labels = data.labels;
            myChart.data.datasets[0].data = data.data;
            myChart.update();
        },
        error: function(data) {
            console.log(data);
        }
    })
}

/**
 * Updates your charts every second
 */
setInterval(() => {
    updateChart()
}, 1000)
