/*
    Alfred, the sustainable butler
    Designed by Nicolas Guilloux - https://nicolasguilloux.eu/

    University College Cork - MSc Interactive Media
    Student n°117221997

    Based on this work: https://github.com/kossa/laradminator
*/

/**
 * Add onClick event to make the div bigger
 */
$('.clickable').click(function(evt) {

    var current = evt.target;

    while( current && !current.className.includes("col") )
        current = current.parentNode;

    if(current) {
        $(current).addClass('transition');
        $(current).toggleClass('col-md-12');
    }
});
