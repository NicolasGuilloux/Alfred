var color = Chart.helpers.color;

var ctx = document.getElementById("myChart").getContext('2d');
var myChart;

/**
 * Ajax call to get the chart data
 *
 * @param String    Date of the report
 * @param Function  Callback function on success
 */
function loadDoc(date, callback) {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
            callback(this.responseText);
    };

    var url = window.location.protocol + "//" + window.location.hostname + "/reports/" + sensor_id + "/chart/" + date;
    console.log("Get data from " + url);

    xhttp.open("GET", url, true);
    xhttp.send();
}

/**
 * Update the chart
 *
 * @param Array New data
 */
function updateChart(data) {
    myChart.data.datasets[0].data = data.datasets[0].data;
    myChart.data.labels = data.labels;
    myChart.update();
}

/**
 * Event listener when the datepicker changes
 * Fetch the data and update the chart
 */
function getChart(date) {

    // Get the data and update the graphic
    loadDoc(date, function(response) {
        var array = JSON.parse(response);

        // Init the chart
        if( array.type && !myChart )
            myChart = new Chart(ctx, array);

        // Update the chart
        else if (array.type && myChart)
            updateChart(array.data);

        // Clear the chart
        else if(myChart)
            ctx.clear();

    });
};
