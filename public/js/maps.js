$(document).ready(() => {
    google.charts.load('current', {
        'packages': ['map'],
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
    });

    google.charts.setOnLoadCallback(drawMap);

    function drawMap() {
        $.ajax({
            url: "/ajax/get/all_streets",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            datatype: 'json',
            success: function (street_object) {
                let all_streets = [['Lat', 'long', 'Name']];

                street_object.forEach(({latitude, longitude, street_name}) => {
                    all_streets.push([latitude, longitude, street_name]);
                });

                var data = google.visualization.arrayToDataTable(all_streets);

                var options = {
                    showTooltip: true,
                    showInfoWindow: true,
                };

                let chart_div = document.getElementById('chart_div')

                if (chart_div !== null) {
                    var map = new google.visualization.Map(chart_div);
                    map.draw(data, options);
                }
            },
            error: function (error) {
                console.log('There went something wrong');
                console.log(error);
            }
        });
    }
})
