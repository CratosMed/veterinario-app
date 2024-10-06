<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class vacunas extends conexion
{
    private $table = "vacunas";
    private $id = "";
    private $fecha = "0000-00-00";
    private $numero_serie = "";
    private $tipo = "";
    private $dosis = "";
    private $descripcion = "";
    private $peso = "";
    private $pacientes_id = "";

    // Listar vacunas con paginación
    public function listavacunas($pagina = 1)
    {
        $inicio  = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT vacunas.*, pacientes.nombre as nombre_paciente FROM " . $this->table . " 
                  JOIN pacientes ON vacunas.pacientes_id = pacientes.id LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    // Obtener detalles de una vacuna por ID
    public function obtenervacuna($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }

    public function obtenervacunas($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE paciente_id = '$id'";
        return parent::obtenerDatos($query);
    }
    // Insertar nueva vacuna
    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        // Validar campos obligatorios
        if (!isset($datos['numero_serie']) || !isset($datos['tipo']) || !isset($datos['dosis']) || !isset($datos['pacientes_id'])) {
            return $_respuestas->error_400();
        } else {
            $this->numero_serie = $datos['numero_serie'];
            $this->tipo = $datos['tipo'];
            $this->dosis = $datos['dosis'];
            $this->pacientes_id = $datos['pacientes_id'];

            if (isset($datos['fecha'])) {
                $this->fecha = $datos['fecha'];
            }
            if (isset($datos['descripcion'])) {
                $this->descripcion = $datos['descripcion'];
            }
            if (isset($datos['peso'])) {
                $this->peso = $datos['peso'];
            }

            $resp = $this->insertarvacunas();
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

    // Método para insertar la vacuna en la base de datos
    private function insertarvacunas()
    {
        $query = "INSERT INTO " . $this->table . " (fecha, numero_serie, tipo, dosis, descripcion, peso, pacientes_id)
                  VALUES ('" . $this->fecha . "', '" . $this->numero_serie . "', '" . $this->tipo . "', '" . $this->dosis . "', 
                          '" . $this->descripcion . "', '" . $this->peso . "', '" . $this->pacientes_id . "')";
        $resp = parent::nonQueryId($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }

    // Actualizar vacuna
    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        // Verificar ID de la vacuna
        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];

            if (isset($datos['numero_serie'])) {
                $this->numero_serie = $datos['numero_serie'];
            }
            if (isset($datos['tipo'])) {
                $this->tipo = $datos['tipo'];
            }
            if (isset($datos['dosis'])) {
                $this->dosis = $datos['dosis'];
            }
            if (isset($datos['fecha'])) {
                $this->fecha = $datos['fecha'];
            }
            if (isset($datos['descripcion'])) {
                $this->descripcion = $datos['descripcion'];
            }
            if (isset($datos['peso'])) {
                $this->peso = $datos['peso'];
            }
            if (isset($datos['pacientes_id'])) {
                $this->pacientes_id = $datos['pacientes_id'];
            }

            $resp = $this->modificarvacuna();
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

    // Método para modificar vacuna
    private function modificarvacuna()
    {
        $query = "UPDATE " . $this->table . " SET numero_serie ='" . $this->numero_serie . "', tipo = '" . $this->tipo . "',
                  dosis = '" . $this->dosis . "', fecha = '" . $this->fecha . "', descripcion = '" . $this->descripcion . "', 
                  peso = '" . $this->peso . "', pacientes_id = '" . $this->pacientes_id . "' WHERE id = '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

    // Eliminar vacuna
    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];
            $resp = $this->eliminarvacuna();
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

    // Método para eliminar vacuna
    private function eliminarvacuna()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id= '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}
