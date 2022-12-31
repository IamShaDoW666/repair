(function($){ 
    "use strict"; 
    var main_chart, months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    $.fn.UseTooltip = function () {
    var previousPoint = null;

    jQuery(this).on("plothover", function (event, pos, item) {

    if (item) {
    if (previousPoint != item.dataIndex) {
        previousPoint = item.dataIndex;

        $("#tooltip").remove();
            
        var x = item.datapoint[0];
        var y = item.datapoint[1];     

        if(item.series.data[item.dataIndex].length >= 3){
            payments = item.series.data[item.dataIndex][2];
            var p = `<br>`;
            $.each(payments, function(x, item){
                p += x + `: ` + item + '<br>';
            });

        }

        showTooltip(item.pageX, item.pageY,
            "<strong>" + moment(x).format('DD MMM YYYY') + "</strong>" + p);
    }
    }
    else {
    $("#tooltip").remove();
    previousPoint = null;
    }
    });
    };

    function showTooltip(x, y, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
    top: y + 5,
    left: x - 40,
    opacity: 0.80,
    position: "absolute",
    display: "none",
    border: "1px solid #fdd",
    padding: "2px",
    "background-color": "#fee",
    opacity: 0.80
    }).appendTo("body").fadeIn(200);
    }

    jQuery(function(){
        

    let order_data = JSON.parse($('#reports_data').val());

        let order_counts = order_data['order_counts'];
        $.each(order_counts, function(x, y){
            order_counts[x][0] = new Date(order_counts[x][0]);
        });
        order_data['order_counts'] = order_counts;

        let order_repairs = order_data['order_repairs'];
        $.each(order_repairs, function(x, y){
            order_repairs[x][0] = new Date(order_repairs[x][0]);
        });
        order_data['order_repairs'] = order_repairs;


        var drawGraph = function( highlight ) {
        var series = [
            
            {
            label: "Gross sales amount",
            data: order_data.order_counts,
            yaxis: 2,
            color: '#b1d4ea',
            points: { show: true, radius: 5, lineWidth: 2, fillColor: '#fff', fill: true },
            lines: { show: true, lineWidth: 2, fill: false },
            shadowSize: 0,
            },
            


            
            
            
        ];

        if ( highlight !== 'undefined' && series[ highlight ] ) {
            highlight_series = series[ highlight ];

            highlight_series.color = '#9c5d90';

            if ( highlight_series.bars ) {
            highlight_series.bars.fillColor = '#9c5d90';
            }

            if ( highlight_series.lines ) {
            highlight_series.lines.lineWidth = 5;
            }
        }

        main_chart = jQuery.plot(
            jQuery('.chart-placeholder.main'),
            series,
            {
            legend: {
                show: false
            },
            grid: {
                color: '#aaa',
                borderColor: 'transparent',
                borderWidth: 0,
                hoverable: true
            },
            xaxes: [ {
                color: '#aaa',
                position: "bottom",
                tickColor: 'transparent',
                mode: "time",
                timeformat: "%d %b",
                monthNames: months,
                tickLength: 2,
                minTickSize: [1, "day"],
                font: {
                color: "#aaa"
                }
            } ],
            yaxes: [
                {
                min: 0,
                minTickSize: 1,
                tickDecimals: 0,
                color: '#d4d9dc',
                font: { color: "#aaa" }
                },
                {
                position: "right",
                min: 0,
                tickDecimals: 2,
                alignTicksWithAxis: 1,
                color: 'transparent',
                font: { color: "#aaa" }
                }
            ],
            }
        );

        jQuery('.chart-placeholder').resize();
        };

        drawGraph();

        jQuery(document).on("hover", ".highlight_series", function (e) {
            drawGraph( jQuery(this).data('series') );
        });
    });
    $(".chart-placeholder.main").UseTooltip();
})(jQuery); 
