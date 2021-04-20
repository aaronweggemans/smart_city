/**
 * Returns all the streets based on the city id
 */
function getStreetData(selectBox) {
    console.log('GETTING STREETS');

    // Value from the option
    let city_id = selectBox.value;
    let select = $("#append_streets");

    $.ajax({
        url: "/ajax/get/streets",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        datatype: 'json',
        data: { city_id },
        success: function (data) {
            select.empty();

            data.forEach(({ street_id, street_name }) => {
                select.append('<option value="' + street_id + '">' + street_name + '</option>')
            });
        },
        error: function (error) {
            console.log('There went something wrong');
            console.log(error);
        }
    });
}
