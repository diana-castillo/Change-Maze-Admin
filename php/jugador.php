<?php

session_start();
require_once "conexion.php";
require_once "alert.php";

class Jugador{
    
    static public function jugadoresCompletos() {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT DISTINCT jugador.* FROM jugador INNER JOIN seccion ON seccion.id_jugador = jugador.id INNER JOIN puntaje ON puntaje.id_jugador = jugador.id");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(Exception $e){} 
    }

    static public function jugadoresIncompletos() {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT DISTINCT jugador.* FROM jugador LEFT JOIN seccion ON seccion.id_jugador = jugador.id LEFT JOIN puntaje ON puntaje.id_jugador = jugador.id WHERE ISNULL(seccion.id_jugador) OR ISNULL(puntaje.id_jugador)");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(Exception $e){} 
    }

    static public function jugadorMostrarSecciones($id){
        try{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM seccion WHERE seccion.id_jugador = :id_s");
            $stmt->bindParam(":id_s", $id, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(Exception $e){}
    }

    static public function jugadorMostrarResultados($id) {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM resultados WHERE id_jugador = :id_jugador");
            $stmt->bindParam(":id_jugador", $id, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){} 
    }

    static public function avg_jugadores($campos){
        try{
            $sql = "SELECT ";
            foreach ($campos as $c) { $sql .= $c.","; }
            $sql = substr($sql, 0, -1);
            $sql .= " FROM resultados";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt -> execute();
            if(count($campos) != 1) return $stmt -> fetchAll(PDO::FETCH_NUM);
            else return $stmt -> fetchAll(PDO::FETCH_COLUMN, 0);

        }catch(Exception $e){} 
    }

    static public function eliminarJugador($ruta) {
        if(isset($_GET['idJugador'])){
            try{
                $stmt = Conexion::conectar()->prepare("DELETE FROM jugador WHERE id = :id");
                $stmt->bindParam(":id", $_GET['idJugador'], PDO::PARAM_INT);
                $stmt -> execute();
                echo alerts("Jugador eliminado con éxito","","success","OK",$ruta);
    
            }catch(Exception $e){
                echo alerts("Algo salió mal, jugador no eliminado",
                            "Por favor, intentalo de nuevo","error","OK",$ruta);
            } 
        }
    }
        
    static public function contarJugadores($ocupacion){
        try {
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS cantidad FROM jugador WHERE ocupacion = :ocupacion;");
            $stmt->bindParam(":ocupacion",$ocupacion, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){}
    }

    static public function seccionesJuego($calificacion_juego, $cambiar_juego){
        try{
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS cantidad FROM seccion 
            WHERE calificacion_juego = :calificacion_juego AND cambiar_juego = :cambiar_juego;");

            $stmt->bindParam(":calificacion_juego",$calificacion_juego, PDO::PARAM_STR);
            $stmt->bindParam(":cambiar_juego",$cambiar_juego, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e) {}
    }

    static public function contarEdades($edadMin, $edadMax){
        try {
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS cantidad FROM jugador WHERE edad BETWEEN :edadMin AND :edadMax;");
            $stmt->bindParam(":edadMin",$edadMin, PDO::PARAM_INT);
            $stmt->bindParam(":edadMax",$edadMax, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){}
    }
}