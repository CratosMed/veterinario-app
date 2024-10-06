<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class antiparasitarios extends conexion
{
    private $table = "antiparasitarios";
    private $table2 = "paciente";
    private $id = "";
    private $tipo = "";
    private $fecha = "0000-00-00";
    private $numero_serie = "";
    private $dosis = "";
    private $peso = "";
    private $descripcion = "";
    private $paciente_id = "";

    public function listaantiparasitarios($pagina = 1)
    {
        $inicio  = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT antiparasitarios.*, paciente.nombre as nombre_paciente 
                  FROM " . $this->table . " 
                  JOIN " . $this->table2 . " ON antiparasitarios.paciente_id = paciente.id 
                  LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function obtenerantiparasitario($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }
    public function obtenerantiparasitarios($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE paciente_id = '$id'";
        return parent::obtenerDatos($query);
    }

    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['tipo']) || !isset($datos['fecha']) || !isset($datos['numero_serie']) || !isset($datos['paciente_id'])) {
            return $_respuestas->error_400();
        } else {
            $this->tipo = $datos['tipo'];
            $this->fecha = $datos['fecha'];
            $this->numero_serie = $datos['numero_serie'];
            $this->dosis = isset($datos['dosis']) ? $datos['dosis'] : null;
            $this->peso = isset($datos['peso']) ? $datos['peso'] : null;
            $this->descripcion = isset($datos['descripcion']) ? $datos['descripcion'] : null;
            $this->paciente_id = $datos['paciente_id'];

            $resp = $this->insertarantiparasitarios();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array("id" => $resp);
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarantiparasitarios()
    {
        $query = "INSERT INTO " . $this->table . " (tipo, fecha, numero_serie, dosis, peso, descripcion, paciente_id) 
                  VALUES ('" . $this->tipo . "', '" . $this->fecha . "', '" . $this->numero_serie . "', '" . $this->dosis . "', '" . $this->peso . "', '" . $this->descripcion . "', '" . $this->paciente_id . "')";
        $resp = parent::nonQueryId($query);
        return $resp ? $resp : 0;
    }

    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];
            if (isset($datos['tipo'])) $this->tipo = $datos['tipo'];
            if (isset($datos['fecha'])) $this->fecha = $datos['fecha'];
            if (isset($datos['numero_serie'])) $this->numero_serie = $datos['numero_serie'];
            if (isset($datos['dosis'])) $this->dosis = $datos['dosis'];
            if (isset($datos['peso'])) $this->peso = $datos['peso'];
            if (isset($datos['descripcion'])) $this->descripcion = $datos['descripcion'];
            if (isset($datos['paciente_id'])) $this->paciente_id = $datos['paciente_id'];

            $resp = $this->modificarAntiparasitario();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array("id" => $this->id);
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarAntiparasitario()
    {
        $query = "UPDATE " . $this->table . " SET tipo ='" . $this->tipo . "', fecha = '" . $this->fecha . "', numero_serie = '" . $this->numero_serie . "', 
                  dosis = '" . $this->dosis . "', peso = '" . $this->peso . "', descripcion = '" . $this->descripcion . "', paciente_id = '" . $this->paciente_id . "' 
                  WHERE id = '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        return $resp ? $resp : 0;
    }

    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];
            $resp = $this->eliminarAntiparasitario();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array("id" => $this->id);
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function eliminarAntiparasitario()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id= '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        return $resp ? $resp : 0;
    }
}
