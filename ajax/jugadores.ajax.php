<?php

require_once '../php/jugador.php';

class AjaxJugadores{

    public $id;

    public function ajaxJugadorMostrarSecciones(){
        $respuesta = Jugador::jugadorMostrarSecciones($this->id);
        echo json_encode($respuesta);
    }
}

if(isset($_POST["idInfoJugador"])){
    $mostrar = new AjaxJugadores();
    $mostrar -> id = $_POST["idInfoJugador"];
    $mostrar -> ajaxJugadorMostrarSecciones();
}