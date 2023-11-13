<?php
require_once("class.conexion.php");
class ViajesReales extends Conexion {
    
    public function __construct(){
        $this->con = $this->connect();
        $this->date = date("Y-m-d");
    }
    
    // method declaration
    public function obtenerDatos() {
        echo $consulta = "SELECT
                        a.cliente,
                        a.origen,
                        a.fecha,
                        a.tracto,
                        SUM(a.kilometraje) AS kilometraje
                    FROM
                        viajesreales a
                    WHERE
                        a.fecha >= '{$this->date} 00:00:00'
                        AND a.fecha <= '{$this->date} 23:00:00'
                    GROUP BY 
                        a.cliente,
                        a.origen,
                        a.fecha;";
        $respuestaConsulta = $this->con->query($consulta);

        if ($respuestaConsulta) {
            $datos = $respuestaConsulta->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } else {
            echo "Error al ejecutar la consulta: " . $this->con->errorInfo()[2];
        }
    }

    public function imprimirDatos() {
        // Obtener los datos
        $datos = $this->obtenerDatos();
    
        // Verificar si se obtuvieron datos
        if (!empty($datos)) {
            // Recorrer cada registro
            foreach ($datos as $registro) {
                // Imprimir los datos del registro
                echo "Cliente: " . $registro['cliente'] . "<br>";
                echo "Origen: " . $registro['origen'] . "<br>";
                echo "Fecha: " . $registro['fecha'] . "<br>";
                echo "Tracto: " . $registro['tracto'] . "<br>";
                echo "Kilometraje: " . $registro['kilometraje'] . "<br>";
                echo "<hr>";  // Línea horizontal para separar los registros
            }
        } else {
            echo "No se encontraron datos.";
        }
    }
}



// Crear una instancia 
$viajes = new ViajesReales();

// Llamar al método para imprimir
$viajes->imprimirDatos();


?>