<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class citas extends conexion
{
    private $table = "citas";
    private $id = "";
    private $paciente_id = "";
    private $fecha = "0000-00-00";
    private $hora = "00:00:00";
    private $titulo = "";
    private $descripcion = "";
    private $recurrencia = "";

    // Método para listar citas
    public function listaCitas($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;

        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT c.*, p.nombre as nombre_paciente 
                  FROM " . $this->table . " c
                  JOIN pacientes p ON c.paciente_id = p.id 
                  LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    // Método para obtener una cita por ID
    public function obtenerCita($id)
    {
        $query = "SELECT c.*, p.nombre as nombre_paciente 
                  FROM " . $this->table . " c
                  JOIN pacientes p ON c.paciente_id = p.id
                  WHERE c.id = '$id'";
        return parent::obtenerDatos($query);
    }

    // Método para crear una nueva cita
    public function crearCita($json)
    {
        $_respuestas = new respuestas;

        $datos = json_decode($json, true);

        // Verificar si los campos requeridos están presentes
        if (!isset($datos['paciente_id']) || !isset($datos['fecha']) || !isset($datos['hora']) || !isset($datos['titulo']) || !isset($datos['recurrencia'])) {
            return $_respuestas->error_400();
        }

        // Asignar valores
        $this->paciente_id = $datos['paciente_id'];
        $this->fecha = $datos['fecha'];
        $this->hora = $datos['hora'];
        $this->titulo = $datos['titulo'];
        $this->descripcion = isset($datos['descripcion']) ? $datos['descripcion'] : "";
        $this->recurrencia = $datos['recurrencia'];

        // Insertar cita
        $resp = $this->insertarCita();
        if ($resp) {
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array("id" => $resp);
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }

    // Método privado para insertar cita
    private function insertarCita()
    {
        $query = "INSERT INTO " . $this->table . " (paciente_id, fecha, hora, titulo, descripcion, recurrencia)
                  VALUES ('$this->paciente_id', '$this->fecha', '$this->hora', '$this->titulo', '$this->descripcion', '$this->recurrencia')";
        $resp = parent::nonQueryId($query);
        return $resp;
    }

    // Método para actualizar una cita con el método PUT
    public function updateCita($json)
    {
        $_respuestas = new respuestas;

        $datos = json_decode($json, true);

        // Verificar si los datos requeridos están presentes
        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        }

        // Asignar valores
        $this->id = $datos['id'];
        $this->paciente_id = isset($datos['paciente_id']) ? $datos['paciente_id'] : "";
        $this->fecha = isset($datos['fecha']) ? $datos['fecha'] : "0000-00-00";
        $this->hora = isset($datos['hora']) ? $datos['hora'] : "00:00:00";
        $this->titulo = isset($datos['titulo']) ? $datos['titulo'] : "";
        $this->descripcion = isset($datos['descripcion']) ? $datos['descripcion'] : "";
        $this->recurrencia = isset($datos['recurrencia']) ? $datos['recurrencia'] : "";

        // Actualizar cita
        $resp = $this->modificarCita();
        if ($resp) {
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array("id" => $this->id);
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }

    // Método privado para modificar cita
    private function modificarCita()
    {
        $query = "UPDATE " . $this->table . " 
                  SET paciente_id = '$this->paciente_id', fecha = '$this->fecha', hora = '$this->hora', titulo = '$this->titulo', 
                      descripcion = '$this->descripcion', recurrencia = '$this->recurrencia' 
                  WHERE id = '$this->id'";
        $resp = parent::nonQuery($query);
        return ($resp >= 1) ? $resp : 0;
    }

    // Método para eliminar una cita
    public function deleteCita($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        }

        $id = $datos['id'];

        $query = "DELETE FROM " . $this->table . " WHERE id = '$id'";
        $deleteResult = parent::nonQuery($query);

        if ($deleteResult > 0) {
            return array(
                'status' => 'success',
                'result' => array('id' => $id),
                'message' => 'Cita eliminada correctamente'
            );
        } else {
            return $_respuestas->error_500();
        }
    }
}
