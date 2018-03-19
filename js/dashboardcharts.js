 

    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';
    // -- Area Chart Example
    function area_chart(area)
    {
        var max_area = parseInt(area.max_area)+parseInt(8);
        //console.log(area.dates);
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            //labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
            labels: area.dates,
            datasets: [{
              label: "Siniestros",
              lineTension: 0.3,
              backgroundColor: "rgba(2,117,216,0.2)",
              borderColor: "rgba(2,117,216,1)",
              pointRadius: 5,
              pointBackgroundColor: "rgba(2,117,216,1)",
              pointBorderColor: "rgba(255,255,255,0.8)",
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(10, 2, 121, 0.98)",
              pointHitRadius: 20,
              pointBorderWidth: 2,
              data:area.servicios,
              //data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451],
            },
            {
              label: "Servicios",
              lineTension: 0.3,
              backgroundColor: "rgba(226, 29, 18, 0.66)",
              borderColor: "rgba(226,29,18,1)",
              pointRadius: 5,
              pointBackgroundColor: "rgba(226, 29, 18, 0.66)",
              pointBorderColor: "rgba(255,255,255,0.8)",
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(121, 2, 2, 0.98)",
              pointHitRadius: 20,
              pointBorderWidth: 2,
              data:area.siniestros,
              //data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451],
            }],
          },
          options: {
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: true
                },
                ticks: {
                  maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  min: 0,
                  max: max_area,
                  maxTicksLimit: 5
                },
                gridLines: {
                  color: "rgba(0, 0, 0, .125)",
                }
              }],
            },
            legend: {
              display: true
            }
          }
        });
        area = null;
    }
    // -- Bar Chart Example
    function bar_chart(bar)
    {
      var max_bar = parseInt(bar.max_bar)+parseInt(100);
      var ctx = document.getElementById("myBarChart");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          //labels: ["January", "February", "March", "April", "May", "June"],
          labels: bar.month,
          datasets: [{
            label: "Siniestros",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            labels:bar.siniestros_percent,
            data: bar.siniestros,          
          },
          {
            label: "Servicios tomados",
            backgroundColor: "rgba(226,29,18,1)",
            borderColor: "rgba(226,29,18,1)",
            labels:bar.services_percent,
            data: bar.servicios,
          }],
         
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'month'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 6
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: max_bar,
                maxTicksLimit: 5
              },
              gridLines: {
                display: true
              }
            }],
          },
          legend: {
            display: true
          },
          tooltips: {
            callbacks: {
              label:function(tooltipItem, data) {
              var label = data.datasets[tooltipItem.datasetIndex].labels[tooltipItem.index];
              var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
              return label + ': ' + value;
             }
            }
          }
        }
      });
    }

    // -- Pie Chart Example
    function pie_chart(pie)
    {
       var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: pie.year,
            datasets: [{
              //data: [12.21, 15.58, 11.25, 8.32],
              data: pie.datos,
              backgroundColor: ['#007bff', '#dc3545'],
            }],
          },
        });
    }
   