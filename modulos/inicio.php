<style>
    /* Cuando la pantalla es menor a 900px  (tablets y teléfonos inteligentes)*/
    @media only screen and (max-width : 900px) {
        .container{
            width:90%;
        }
    }

    /* Cuando la pantalla es mayor a 900px */
    @media only screen and (min-width : 901px) {
        .container{
            width:60%;
        }
    }

    .chart-container {
      width: 100%;
      height: 50vh;
      margin: auto;
    }
</style>

<?php
  include 'menu.php';

  $jugador = new Jugador();

  $campos = array("busqueda_rutina", "reaccion_emocional", "enfoque_corto_plazo", "rigidez_cognitiva");
  $avg_jugadores = $jugador -> avg_jugadores($campos); //Resultados de todos los jugadores

  $estudiantes = $jugador -> contarJugadores('ESTUDIANTE') -> cantidad;
  $profesionistas = $jugador -> contarJugadores('PROFESIONISTA') -> cantidad;

  $bueno_no = $jugador -> seccionesJuego(1,0) -> cantidad;
  $bueno_si = $jugador -> seccionesJuego(1,1) -> cantidad;
  $malo_no = $jugador -> seccionesJuego(0,0) -> cantidad;
  $malo_si = $jugador -> seccionesJuego(0,1) -> cantidad;

  $entre16y20 = $jugador -> contarEdades(16,20) -> cantidad;
  $entre21y25 = $jugador -> contarEdades(21,25) -> cantidad;
  $entre26y30 = $jugador -> contarEdades(26,30) -> cantidad;
  $entre31y35 = $jugador -> contarEdades(31,35) -> cantidad;
  $entre36y40 = $jugador -> contarEdades(36,40) -> cantidad;
  $entre41y45 = $jugador -> contarEdades(41,45) -> cantidad;
  $mayorA45 = $jugador -> contarEdades(45,99) -> cantidad;
?>

<div class="container mt-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Total de muestras</h6>
            </div>
            
            <div class="card-body p-5">

              <div class="card chart-container">
                <canvas id="scatterChart"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>

<div class="container mt-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Secciones del Juego</h6>
            </div>
            
            <div class="card-body p-5">

              <div class="card chart-container">
                <canvas id="barChart"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>

<div class="container mt-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Jugadores</h6>
            </div>
            
            <div class="card-body p-5">

              <div class="card chart-container">
                <canvas id="pieChart"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>

<div class="container mt-5 mb-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Edades</h6>
            </div>
            
            <div class="card-body p-5">

              <div class="card chart-container">
                <canvas id="horizontalBarChart"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>


<script>
  // Para gráfica de dispersión
  async function testPCA(avg_jugadores) {
      let WCluster = window['w-cluster'];
      let resultado = await WCluster.PCA(avg_jugadores, { nCompNIPALS: 2 });
      return resultado;
  }

  let avg_jugadores = <?php echo json_encode($avg_jugadores); ?>;
  var avg_float = [];
  var tmp = [];

  // Convertir datos a flotantes
  for (let i = 0; i < avg_jugadores.length; i++) {
      for (let j = 0; j < 4; j++)
          tmp.push(parseFloat(avg_jugadores[i][j]));

      avg_float.push(tmp);
      tmp = [];
  }
  
  testPCA(avg_float).then(resultado => { 
      var datasets = [[],[]]; // [[grupo1],[grupo2]]
      var grupo = []; // Lista de grupo de cada jugador. 1 = resistente; 0 = no resistente

      // Sacar promedio de c/u y meter grupo en lista
      for(let i = 0; i < avg_float.length; i++) {
          var promedio = (avg_float[i][0] + avg_float[i][1] + avg_float[i][2] + (1 - avg_float[i][3])) / 4;
          if (promedio > 0.5)
              grupo.push(0);
          else
              grupo.push(1);
      }

      // Guardar datos de los grupos en datasets
      for (let i = 0; i < resultado.length; i++) { 
          if (grupo[i] == 0)
              datasets[0].push({ x: resultado[i][0] , y: resultado[i][1] }); // no resistentes
          else
              datasets[1].push({ x: resultado[i][0] , y: resultado[i][1] }); // resistentes
      }

      var ctx = document.getElementById("scatterChart").getContext("2d");
      var myScatter = Chart.Scatter(ctx, {
      data: {
          datasets: [{
              label: "Jugadores no resistentes al cambio",
              borderColor: 'rgb(255, 99, 132)',
              backgroundColor: 'rgba(255, 99, 132, 0.5)',
              data: datasets[0]
          }, {
              label: "Jugadores resistentes al cambio",
              borderColor: 'rgb(54, 162, 235)',
              backgroundColor: 'rgba(54, 162, 235, 0.5)',
              data: datasets[1]
          }
      ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        showLines: false,
        elements: {
            point: {
                radius: 5
            }
        }
      }
      });
      
  });

  // Gráfica de barras
  var barCanvas = document.getElementById("barChart");

  var yesData = {
    label: 'Sí cambiar el juego',
    data: [<?php echo $bueno_si ?>, <?php echo $malo_si ?>],
    backgroundColor: '#3D55F3'
  };
  
  var noData = {
    label: 'No cambiar el juego',
    data: [<?php echo $bueno_no ?>, <?php echo $malo_no ?>],
    backgroundColor: '#EE313F'
  };
  
  var barData = {
    labels: ["Bueno", "Malo"],
    datasets: [yesData, noData]
  };
  
  var barOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: "Calificación",
          fontColor: "grey"
        },
        barPercentage: 1,
        categoryPercentage: 0.6
      }],
      yAxes: [{
        scaleLabel: {
          display: true,
          labelString: "Secciones",
          fontColor: "grey"
        },
        ticks: {
            min: 0,
            max: <?php echo max($bueno_si, $bueno_no, $malo_si, $malo_no) ?>,
            callback: function(value) {if (value % 1 === 0) {return value;}}
        }
      }]
    }
  };
  
  var barChart = new Chart(barCanvas, {
    type: 'bar',
    data: barData,
    options: barOptions
  });

  // Gráfica de pastel
  var pieCanvas = document.getElementById("pieChart");

  var pieData = {
      labels: [
          "Estudiantes",
          "Profesionistas"
      ],
      datasets: [
      {
        data: [<?php echo $estudiantes ?>, <?php echo $profesionistas ?>],
        backgroundColor: [
            "#FF6384",
            "#3DEBF3"
        ]
      }]
  };

  var pieOptions = {
    responsive: true,
    maintainAspectRatio: false,
  };

  var pieChart = new Chart(pieCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  });

  //Gráfica de barras horizontal
  var horizontalBarCanvas = document.getElementById("horizontalBarChart");

  var ageData = {
    label: 'Jugadores',
    data: [<?php echo $mayorA45 ?>, <?php echo $entre41y45 ?>, <?php echo $entre36y40 ?>, <?php echo $entre31y35 ?>, <?php echo $entre26y30 ?>, <?php echo $entre21y25?>, <?php echo $entre16y20 ?>],
    backgroundColor: '#037CA4'
  };

  var horizontalBarData = {
    labels: ["Mayor a 45", "Entre 41 y 45", "Entre 36 y 40", "Entre 31 y 35", "Entre 26 y 30", "Entre 21 y 25", "Entre 16 y 20"],
    datasets: [ageData]
  };

  var horizontalBarOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: "Número de jugadores",
          fontColor: "grey"
        },
        ticks: {
            min: 0,
            max: <?php echo max($mayorA45, $entre41y45, $entre36y40, $entre31y35, $entre26y30, $entre21y25, $entre16y20) ?>,
            callback: function(value) {if (value % 1 === 0) {return value;}}
        }
      }],
      yAxes: [{
        scaleLabel: {
          display: true,
          labelString: "Rangos de edad (años)",
          fontColor: "grey"
        },
        barPercentage: 1
      }]
    }
  };

  var horizontalBarChart = new Chart(horizontalBarCanvas, {
    type: 'horizontalBar',
    data: horizontalBarData,
    options: horizontalBarOptions
  });

</script>