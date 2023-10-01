<?php
  include 'menu.php';
?>

<div class="container" style="background:#ffffff; padding:0; width:90%;">
  <div class="card-deck mb-5 mt-5">

    <div class="card mb-2 box-shadow">

      <div class="card-header">
        <h6 class="text-center">Jugadores con registro completo</h6>
      </div>

      <div class="card-body">

        <table class="display compact cell-border dt-responsive mb-2 tablas" width="100%">

          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Sexo</th>
              <th>Edad</th>
              <th>Ocupación</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $jugador = new Jugador();
            $jugadores = $jugador -> jugadoresCompletos();
            
            foreach($jugadores as $key => $value) {
              echo '<tr>
                      <td>'.($key+1).'</td>
                      <td>'.$value["nombre_completo"].'</td>
                      <td>'.$value["correo"].'</td>
                      <td>'.$value["sexo"].'</td>
                      <td>'.$value["edad"].'</td>
                      <td>'.$value["ocupacion"].'</td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-primary btnInfoJugador" title="Mostrar información" data-bs-toggle="modal" data-bs-target="#modalInfoJugador" idInfoJugador="'.$value["id"].'">
                            <i class="bi bi-file-text text-light"></i>
                          </button>
                          <button type="button" class="btn btn-danger btnEliminarJugador" title="Eliminar" idJugador="'.$value["id"].'">
                            <i class="bi bi-trash text-light"></i>
                          </button>
                        </div>
                      </td>
                    </tr>';
            }
            ?>

          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal mostrar información del usuario -->
<div class="modal fade bd-example-modal-lg" id="modalInfoJugador" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header card-header">
        <h5 class="modal-title">Información</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div>
          <h6 class="text-center">Secciones jugadas</h6>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered text-center" id="table_modal_secciones">
            <thead>
              <tr>
                <th>Numero de respuesta</th>
                <th>Calificacion del juego</th>
                <th>Cambiar de juego</th>
                <th>Suerte del nivel</th>
                <th>Total de monedas en el nivel</th>
                <th>Monedas obtenidas</th>
                <th>Nivel actual</th>
                <th>Tiempo transcurrido</th>
              </tr>
            </thead>

            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {

var rol = '<?php echo $_SESSION['rol'];?>' ;
if(rol == "Usuario"){
  const btns = document.getElementsByClassName('btnEliminarJugador')
  for(const btn of btns)
    btn.style.visibility = 'hidden';
}

document.getElementById("DataTables_Table_0_length").classList.add("mb-3");
document.getElementById("DataTables_Table_0_filter").classList.add("mb-3");
  
})

$(document).on("click", ".btnEliminarJugador", function(){

  var idJugador = $(this).attr("idJugador");

  swal.fire({
      title:"¿Está seguro de borrar el jugador?",
      text: "Esta acción es irreversible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6", 
      cancelButtonColor: "#d33",
      confirmButtonText: "Borrar",
      cancelButtonText: "Cancelar"
  }).then((result)=>{
      if(result.value){
        window.location = "completos?idJugador="+idJugador;
      }
  })
})

$(document).on("click", ".btnInfoJugador", function(){
  var idInfoJugador = $(this).attr("idInfoJugador");
  var datos = new FormData();
  datos.append("idInfoJugador", idInfoJugador);

  $.ajax({
        url:"./ajax/jugadores.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
          const table_sec = document.getElementById('table_modal_secciones');
          for (var i = table_sec.rows.length - 1; i > 0; i--)
            table_sec.deleteRow(i);

          let rows = 1;
          for(let registro of respuesta){
            let row = table_sec.insertRow(rows++);
            row.insertCell(0).innerHTML = Number(registro["num_respuesta"]) + 1;

            var calificacion = (registro["calificacion_juego"] == 1) ? "Bueno" : "Malo";
            row.insertCell(1).innerHTML = calificacion;

            var cambiar = (registro["cambiar_juego"] == 1) ? "Sí" : "No";
            row.insertCell(2).innerHTML = cambiar;

            var suerte = (registro["suerte"] == 1) ? "Buena" : "Mala";
            row.insertCell(3).innerHTML = suerte;

            row.insertCell(4).innerHTML = registro["monedas_nivel"];
            row.insertCell(5).innerHTML = registro["monedas_obtenidas"];
            row.insertCell(6).innerHTML = registro["nivel_actual"];

            var seconds = registro["tiempo_transcurrido"];
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds - (hours * 3600)) / 60);
            var partInSeconds = seconds - (hours * 3600) - (minutes * 60);
            partInSeconds = partInSeconds.toString().padStart(2,'0');
            row.insertCell(7).innerHTML = `${hours}:${minutes}:${partInSeconds}`;
          } 
        }
    });
})

</script>

<?php
  $jugador = new Jugador();
  $jugador -> eliminarJugador("completos");
?>  