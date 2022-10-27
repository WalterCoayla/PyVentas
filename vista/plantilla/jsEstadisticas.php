<script type="text/javascript">
    $(function () {
     var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }
  var mode = 'index'
  var intersect = true

  var $graf = $('#grafModelosXMarcas');
  
  var graf = new Chart($graf, {
    type: 'bar',
    data: {
      labels: <?=json_encode($labels)?>,
      datasets: [
        {
          backgroundColor: '#00ccff',
          borderColor: '#007b00',
          data: <?=json_encode($data)?>
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 10) {
                value /= 10
                value += 'k'
              }

              return  value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  });
        
/// ESTADÍSTICAS
});
</script>
