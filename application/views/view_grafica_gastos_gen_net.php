
<img id="mock" src="">

<script type="text/javascript">

  $( document ).ready(function() {

      Highcharts.setOptions({
            lang: {
            thousandsSep: ','  //permite las comas en los numeros
            },
            colors: ['#1f497d', '#98DCFB', '#EE411C', '#04a205', '#d03604', '#f4b300']  //define el color para cada columna
      });



      Highcharts.chart('container', {
          data: {
            table: 'datatable'
          },
          chart: {
            type: 'column'
          },
          title: {
            text: 'Gastos Generales'
          },
          subtitle: {
            text: '<?php echo $sub;?>'
          },
          xAxis: {
                    type: 'category'
                 },
          yAxis: {
            allowDecimals: false,
            title: {
              text: 'Total'
            }
          },
          credits: {
                enabled: false
            },
          legend: {
                enabled: false
          },
          html:{
            enable: true
          },
          plotOptions: {
                            series: {
                                borderWidth: 0,
                                colorByPoint: true,
                                dataLabels: {
                                    enabled: true,
                                    format: '${point.y:,.0f}'
                                }
                            }
                        },
          tooltip: {
            formatter: function () {
              return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
            }
          }
        }, function(chart) { // on complete

          chart.renderer.text('#Transac', 10, 378)
              .css({
                  color: '#4572A7',
                  fontSize: '16px'
              })
              .add();

      });

      $(".highcharts-grid-line").hide();
      $(".highcharts-credits").hide();
      $("#img_login").remove();

});

</script>

<div id="container" style="min-width: 310px;  margin: 0 auto"></div>

<table id="datatable" hidden>
    <thead>
        <tr>
          <th></th>
          <th>Tarifa</th>
        </tr>
    </thead>
<?php 

foreach ($grafica as $key => $value) {

    print_r("
      <tbody>
        <tr>
          <th>".$value->name.'<br><div>'.$value->total_boletos."</div></th>
          <td>".$value->y."</td>
        </tr>
      </tbody>");
      
  } 

?>

</table>

<div id="div_cont_boletos" hidden>
<br><br>
<?php
    $cont = count($grafica);
    $cont_col = 8 / $cont;
?>
  <div class="col-md-8"> 

     <div class="row">
        <?php
         
          foreach ($grafica as $key => $value) {
            
            print_r('
             
                    <div class="col-md-'.$cont_col.'">
                      '.$value->total_boletos.'
                    </div>
                   

              ');
              
          } 

        ?>
      </div>
  </div>
  
  <?php 

    print_r('<input type="hidden" value="'.$cont.'" id="txthid_cont_bol">');

  ?>

</div>

