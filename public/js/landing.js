// When document is ready
$(document).ready(() => {

    // When scrolling
    $(window).scroll(() => {
        let distance = $('body').scrollTop();

        $('.jumbotron').css('background-position', `0px ${distance/8}px`);
        $('#title-section').css('bottom', `${distance/4}px`)

        if(distance >= 1400) {
            $('.featurette-one').css('margin-left', distance / 24)
        }

        if(distance >= 1800) {
            $('.featurette-two').css('bottom', distance / 12)
        }

        if(distance >= 2750) {
            $('.feature-one').css('left', distance / 64);
            $('.feature-two').css('top', distance / 32);
            $('.feature-three').css('top', (distance / 16) - 50);
            console.log(distance);
        }
    })
})
