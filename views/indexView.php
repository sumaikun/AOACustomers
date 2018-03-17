  <?php
      //print_r($post);
      //exit;
      include('subviews/header.php');
     
   ?>

   <?php

        if($max_month_days == 0)
        {
            $max_month_days=1; 
        }        

        $portion = ceil($max_month_days/8);      

        $grados = ceil($portion*8/260);

        //echo "grados ".$grados;

        //echo "grados para la animación ".ceil($current_days/$grados);

        $defined_degree = ceil($current_days/$grados)-135;

        $second_degree = $defined_degree-2;



    ?>
  
<link rel="stylesheet" type="text/css" href="css/boardstyles.css">

 <style>

  @keyframes pendulum {

    10% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    20% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    30% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    40% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    50% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    60% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    70% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    80% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    90% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    100% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
  
}

@keyframes compass_effect{
    0%{
        transform:rotate(<?php echo $defined_degree ?>deg);
    }

    10% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    20% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    30% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    40% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    50% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    60% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    70% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    80% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
    90% {
        transform:rotate(<?php echo $second_degree ?>deg);
    }
    100% {
        transform:rotate(<?php echo $defined_degree ?>deg);
    }
}
</style>

<div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Gráficas</li>
      </ol>
      <?php if($_SESSION['rol']==1): ?>
        <form method="post">
          <div class="form-group inner_img">
            <label class="form-control">Aseguradora</label>
              <select  class="form-control" name="aseguradora_select" onchange="this.form.submit()" required>
                  <option value="0">Selecciona</option>
                <?php foreach($aseguradoras as $aseguradora) { $currents = $aseguradora->id.','.$aseguradora->tipo; ?>
                  <option value="<?php echo $aseguradora->id.','.$aseguradora->tipo ?>" <?php  if($saseguradora == $currents): ?> 
                  selected <?php endif ?> > <?php echo $aseguradora->nombre ?> </option>
                <?php } ?>
              </select>
          </div>
        </form>
      <br>
      <?php endif ?>
      <!-- Area Chart Example-->
      <div class="card mb-3 inner_img">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Siniestros por 10 dias</div>
        <div class="card-body">
          <canvas id="myAreaChart" width="100%" height="30"></canvas>
        </div>
        <div class="card-footer small text-muted">Actualizado</div>
  
          <label>Semana:</label> <input <?php if(isset($post['area_week'])){ echo "value='".$post['area_week']."'"; }
           else{ echo "value=".date('o')."-W".date('W'); } ?>  type="week" onchange="catch_data(164)" class="datepicker" name="area_inicio"> <input type="hidden"> 
         
       
      </div>   



      <div class="card mb-3 inner_img">
        <div class="card-header">
          <i class="fa fa-clock"></i> Dias de servicio</div>
        <div class="row">        
          <div class="container text-center">
            <div class="col-lg-12 col-md-12">
               <div class="t_container">
                  <div id="tachometer">
                    <div style="position:absolute; margin-top:65%; width:101%; text-align:center;">
                      <span id="clock_text">Días:</span>
                      <br>
                      <span style="font-size: 2.5em; margin-right: 5px;" id="clock_text"><?php echo $current_days ?></span>
                    </div>
                                <div class="ii">
                                    <div><b><span class="num_1"></span></b></div>
                                    <div><b></b></div>
                                    <div><b><span class="num_2 tach_text"><?php //echo $portion ?></span></b></div>
                                    <div><b></b></div>
                                    <div><b><span class="num_3 tach_text"><?php //echo $portion*2 ?></span></b></div>
                                    <div><b></b></div>
                                    <div><b><span class="num_4 tach_text"><?php //echo $portion*3 ?></span></b></div>
                                    <div><b></b></div>
                                    <div><b><span class="num_5 tach_text"><?php //echo $portion*4 ?></span></b></div>
                                    <div><b></b></div>
                                    <div><b><span class="num_6 tach_text"><?php //echo $portion*5 ?></span></b></div>
                                    <div><b></b></div>
                                    <div><b><span class="num_7 tach_text"><?php //echo $portion*6 ?></span></b></div>
                                    <div><b></b></div>
                                    <div><b><span class="num_8 tach_text"><?php //echo $portion*7 ?></span></b></div>
                                    <div><b></b></div>
                                    <div><b style="background:#B40404 !important;"><span style="word-wrap:normal;" class="num_9 tach_text"><?php echo $portion*8 ?></span></b></div>
                                </div> 
                              <div id="redline"></div>
                              <div id="yellowline"></div>
                              <div id="orangeline"></div>
                        <div class="line"></div>
                       <div class="pin"><div class="inner"></div></div> 
                    </div>
                </div> 
            </div>
          </div> 
        </div>         
      </div>

      <div class="row">
        <div class="col-lg-8">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3 inner_img">
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> Siniestros este mes</div>
            <div class="card-body">
              <canvas id="myBarChart" width="100" height="50"></canvas>
            </div>
            <div class="card-footer small text-muted">Actualizado</div>
            <form method="post">
                <label>Mes</label>
                <input type="month" onchange="catch_data(625)" <?php if(isset($post['bar_month'])){  ?>  value="<?php echo $post['bar_month']  ?>"  <?php } else {
                  echo "value = ".date('o-m');
                } ?> class="datepicker" name="sbar_month">
              
            </form>
          </div>
        </div>
        <div class="col-lg-4">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3 inner_img">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i> Siniestros este año</div>
            <div class="card-body">
              <canvas id="myPieChart" width="100%" height="100"></canvas>
            </div>
            <div class="card-footer small text-muted">Actualizado</div>
        
                <label>Año</label>
                <select  onchange="catch_data(625)" width="100%" name="year_bar">
                  <option>Selecciona</option>
                  <?php for($i=$year_min;$i<=date('o');$i++){  ?>
                    <option <?php if(isset($post['pie_year'])){ if($post['pie_year'] == $i) { echo "selected"; } } else { if($i==date('o')) { echo "selected"; }  } ?>    value="<?php echo $i ?>"><?php echo $i ?></option>
                  <?php } ?>
                </select>
              
            
          </div>
        </div>
      </div>
      <form method="post"  id="inner_data_form"> 
        <input type="hidden" name="area_week">
        <input type="hidden" name="bar_month">
        <input type="hidden" name="pie_year">
        <input type="hidden" name="scroll_move">
        <input type="hidden" name="aseguradora_select">
        <!--<div class="form-group">
          <button class="btn btn-success form-control">Filtrar</button>
        </div>-->
      </form>
    </div>
     
    </div>
    
  </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
  <?php include('subviews/footer.php') ?>

  <script>


    

    var scrolling = <?php if(isset($post['scroll_move'])){ echo $post['scroll_move'];} else{ echo 164; }  ?>

    $( document ).ready(function() {
      var y = $(window).scrollTop();
      //164
      //620
      $("html, body").animate({ scrollTop:  scrolling}, 600);

        setInterval(function(){
            check_view_content();
        }, 500);
      }     
    );

    function catch_data(scrollmove)
    {
      //console.log("triggered");
      $("input[name='area_week']").val($("input[name='area_inicio']").val());
      $("input[name='bar_month']").val($("input[name='sbar_month']").val());
      $("input[name='pie_year']").val($("select[name='year_bar']").val());
      <?php if($_SESSION['rol']==1): ?>
      $("input[name='aseguradora_select']").val($("select[name='aseguradora_select']").val());
      <?php endif ?>
      $("input[name='scroll_move']").val(scrollmove);
      document.getElementById("inner_data_form").submit();
      
    }

    var dates_label = <?php echo json_encode($datearray) ?>;
    var counts_data = <?php echo json_encode($countarray) ?>;
    var counts2_data = <?php echo json_encode($countarray2) ?>;

    var bar_label = <?php echo json_encode(array_reverse($bar_labels)) ?>;

    var total_services = <?php echo json_encode($total_month_services) ?>;

    var total_siniesters = <?php echo json_encode($total_month_siniesters) ?>;

    var total_services_percent = <?php echo json_encode($total_month_services_percent) ?>;

    var total_siniesters_percent = <?php echo json_encode($total_month_siniesters_percent) ?>;

    var year_siniesters = <?php echo json_encode($year_siniesters) ?>;

    var year_labels = <?php echo json_encode($year_labels) ?>;

    var max_bar = <?php echo $max_bar ?>;

    var max_area = <?php echo $max_area ?>;

    //console.log(dates_label);
    //console.log(counts_data);

    console.log(total_services[0]);

    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';
    // -- Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        //labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
        labels: dates_label,
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
          data:counts_data,
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
          data:counts2_data,
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
    // -- Bar Chart Example
    var ctx = document.getElementById("myBarChart");
    var myLineChart = new Chart(ctx, {
      type: 'bar',
      data: {
        //labels: ["January", "February", "March", "April", "May", "June"],
        labels: bar_label,
        datasets: [{
          label: "Siniestros",
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",
          labels:total_siniesters_percent,
          data: total_siniesters,          
        },
        {
          label: "Servicios tomados",
          backgroundColor: "rgba(226,29,18,1)",
          borderColor: "rgba(226,29,18,1)",
          labels:total_services_percent,
          data: total_services,
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
    // -- Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: year_labels,
        datasets: [{
          //data: [12.21, 15.58, 11.25, 8.32],
          data: year_siniesters,
          backgroundColor: ['#007bff', '#dc3545'],
        }],
      },
    });
  </script>

    <script>

    var matched, browser;

    jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

          var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
              /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
              /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
              /(msie) ([\w.]+)/.exec( ua ) ||
              ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
              [];

          return {
              browser: match[ 1 ] || "",
              version: match[ 2 ] || "0"
          };
      };

      matched = jQuery.uaMatch( navigator.userAgent );
      browser = {};

      if ( matched.browser ) {
          browser[ matched.browser ] = true;
          browser.version = matched.version;
      }

      // Chrome is Webkit, but Webkit is also Safari.
      if ( browser.chrome ) {
          browser.webkit = true;
      } else if ( browser.webkit ) {
          browser.safari = true;
      }

      jQuery.browser = browser;  




      /*  if ($.browser.mozilla)
    {
        if ($('.datepicker')[0].type != 'date') $('.datepicker').datepicker();
        $(function () {
            $(".datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1900:2015",
                dateFormat: "yy-mm-dd",
                defaultDate: '1900-01-01'
            });
        });
    }*/


    function check_view_content()
    {
        console.log("execute");
        var process = (function ($, window, document, undefined) {         
          function checkAnimation() {
            var $elem = $('.t_container');

              if (isElementInViewport($elem)) {                 
                console.log("encontrado");
                 $(".line").css("animation","compass_effect 10s infinite , pendulum 10s 1"); 
              }
              else{
               
              }
           
          }

          checkAnimation();

        }(jQuery, window, document));

    }

   function isElementInViewport(el) {
      var rect = el[0].getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
      );
    }
    
</script>
