<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class procedimientos extends conexion
{
    private $table = "procedimientos"; // Asegúrate de que esta tabla exista en tu base de datos
    private $id = "";
    private $fecha = "0000-00-00";
    private $anestesiologo = "";
    private $cirujano = "";
    private $valoracion_asa = "";
    private $peso = 0;
    private $patologias = "";
    private $medicacion = "";
    private $observaciones = "";
    private $paciente_id = "";

    // Listar procedimientos con paginación
    public function listaprocedimientos($pagina = 1)
    {
        $inicio  = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT procedimientos.*, pacientes.nombre as nombre_paciente FROM " . $this->table . " 
                  JOIN pacientes ON procedimientos.paciente_id = pacientes.id LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    // Obtener detalles de un procedimiento por ID
    public function obtenerprocedimiento($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }
    public function obtenerprocedimientos($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE paciente_id = '$id'";
        return parent::obtenerDatos($query);
    }

    // Insertar nuevo procedimiento
    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        // Validar campos obligatorios
        if (!isset($datos['paciente_id'])) {
            return $_respuestas->error_400();
        } else {
            // Asignar valores a las propiedades
            $this->paciente_id = $datos['paciente_id'];
            if (isset($datos['fecha'])) {
                $this->fecha = $datos['fecha'];
            }
            if (isset($datos['anestesiologo'])) {
                $this->anestesiologo = $datos['anestesiologo'];
            }
            if (isset($datos['cirujano'])) {
                $this->cirujano = $datos['cirujano'];
            }
            if (isset($datos['valoracion_asa'])) {
                $this->valoracion_asa = $datos['valoracion_asa'];
            }
            if (isset($datos['peso'])) {
                $this->peso = $datos['peso'];
            }
            if (isset($datos['patologias'])) {
                $this->patologias = $datos['patologias'];
            }
            if (isset($datos['medicacion'])) {
                $this->medicacion = $datos['medicacion'];
            }
            if (isset($datos['observaciones'])) {
                $this->observaciones = $datos['observaciones'];
            }

            $resp = $this->insertarprocedimiento();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id" => $resp
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    // Método para insertar el procedimiento en la base de datos
    private function insertarprocedimiento()
    {
        $query = "INSERT INTO " . $this->table . " (fecha, anestesiologo, cirujano, valoracion_asa, peso, 
                  patologias, medicacion, observaciones, paciente_id)
                  VALUES ('" . $this->fecha . "', '" . $this->anestesiologo . "', '" . $this->cirujano . "', 
                  '" . $this->valoracion_asa . "', '" . $this->peso . "', '" . $this->patologias . "', 
                  '" . $this->medicacion . "', '" . $this->observaciones . "', '" . $this->paciente_id . "')";
        $resp = parent::nonQueryId($query);
        return $resp ? $resp : 0;
    }

    // Actualizar procedimiento
    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        // Verificar ID del procedimiento
        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];

            // Asignar campos
            if (isset($datos['fecha'])) {
                $this->fecha = $datos['fecha'];
            }
            if (isset($datos['anestesiologo'])) {
                $this->anestesiologo = $datos['anestesiologo'];
            }
            if (isset($datos['cirujano'])) {
                $this->cirujano = $datos['cirujano'];
            }
            if (isset($datos['valoracion_asa'])) {
                $this->valoracion_asa = $datos['valoracion_asa'];
            }
            if (isset($datos['peso'])) {
                $this->peso = $datos['peso'];
            }
            if (isset($datos['patologias'])) {
                $this->patologias = $datos['patologias'];
            }
            if (isset($datos['medicacion'])) {
                $this->medicacion = $datos['medicacion'];
            }
            if (isset($datos['observaciones'])) {
                $this->observaciones = $datos['observaciones'];
            }
            if (isset($datos['paciente_id'])) {
                $this->paciente_id = $datos['paciente_id'];
            }

            $resp = $this->modificarprocedimiento();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id" => $this->id
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    // Método para modificar procedimiento
    private function modificarprocedimiento()
    {
        $query = "UPDATE " . $this->table . " SET fecha = '" . $this->fecha . "', anestesiologo = '" . $this->anestesiologo . "', 
                  cirujano = '" . $this->cirujano . "', valoracion_asa = '" . $this->valoracion_asa . "', 
                  peso = '" . $this->peso . "', patologias = '" . $this->patologias . "', 
                  medicacion = '" . $this->medicacion . "', observaciones = '" . $this->observaciones . "', 
                  paciente_id = '" . $this->paciente_id . "' WHERE id = '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        return $resp >= 1 ? $resp : 0;
    }

    // Eliminar procedimiento
    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];
            $resp = $this->eliminarprocedimiento();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id" => $this->id
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    // Método para eliminar procedimiento
    private function eliminarprocedimiento()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id= '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        return $resp >= 1 ? $resp : 0;
    }
}
