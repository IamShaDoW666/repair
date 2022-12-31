(function($){ 
    "use strict"; 
    $(function () {
    var donutChartCanvas = $('#stock-chart').get(0).getContext('2d')
    var donutData        = {
      labels: [
        lang.stock_value_by_price,
        lang.stock_value_by_cost,
        lang.profit_estimate,
      ],
      datasets: [
        {
          data: [<?php echo($stock->stock_by_price) ? $stock->stock_by_price : 0; ?>,<?php echo($stock->stock_by_cost) ? $stock->stock_by_cost : 0; ?>,<?php echo($stock->stock_by_price - $stock->stock_by_cost); ?>],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
});
})(jQuery); 