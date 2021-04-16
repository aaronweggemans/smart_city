$(document).ready(() => {
    google.charts.load('current', {
        'packages': ['map'],
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'

    });
    google.charts.setOnLoadCallback(drawMap);

    function drawMap() {
        var data = google.visualization.arrayToDataTable([
            ['Lat', 'Long', 'Name'],
            [52.494813, 5.453970, 'Container Landstrekenwijk Lelystad'],
            [52.498118, 5.071932, 'Container Boelenspark Volendam'],
            [52.340460, 4.864875, 'Container F. Roeskestraat Amsterdam'],
            [52.256277, 5.221814, 'Container Stationsweg Laren'],
            [52.811366, 4.998068, 'Container Kerkhoflaan Middenmeer'],
            [52.949056, 4.762349, 'Container Anemonenstraat Den Helder'],
            [52.631512, 4.750322, 'Container Waagplein Alkmaar'],
            [50.846480, 5.689271, 'Container Verwerhoek Maastricht'],
            [52.218156, 6.908757, 'Container Espoortlaan Enschede'],
            [53.205749, 6.622959, 'Container Euvelgunnerweg Groningen'],
            [51.502406, 3.601299, 'Container Essenlaan Middelburg'],
        ]);

        var options = {
            showTooltip: true,
            showInfoWindow: true,
        };

        let chart_div = document.getElementById('chart_div')

        if(chart_div !== null) {
            var map = new google.visualization.Map(chart_div);
            map.draw(data, options);
        }

    }
})
