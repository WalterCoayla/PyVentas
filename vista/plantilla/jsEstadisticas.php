<?php 
//var_dump($data);exit();
?>
<script type="text/javascript">
    $(function () {
     var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }
    // alert(ticksStyle)
  var mode = 'index'
  var intersect = true

  var $graf = $('#grafModelosXMarcas');
  // eslint-disable-next-line no-unused-vars
  
  var graf = new Chart($graf, {
    type: 'bar',
    data: {
      labels: <?=json_encode($labels)?>,
      //labels: ['Marca1', 'Marca2', 'Marca3', 'Marca4'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: <?=json_encode($data)?>
          //  data: ["1000", "2000", "3000", "2500"]
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
