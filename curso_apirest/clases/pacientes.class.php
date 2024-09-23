<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class pacientes extends conexion
{

    private $table = "pacientes";
    private $table2 = "propietarios";
    private $id = "";
    private $nombre = "";
    private $genero = "";
    private $color = "";
    private $sexo = "";
    private $sena_particular = "";
    private $procedencia = "";
    private $fecha_nacimiento = "0000-00-00";
    private $alergias = "";
    private $enfermedades_anteriores = "";
    private $antecedentes_familiares = "";
    private $propietarios_id = "";

    // Método para listar pacientes
    public function listaPacientes($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;

        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        // Consulta para obtener los pacientes junto con sus propietarios
        $query = "SELECT p.*, o.nombre as nombre_propietario, o.telefono 
                  FROM " . $this->table . " p
                  JOIN " . $this->table2 . " o ON p.propietarios_id = o.id 
                  LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    // Método para obtener un paciente por ID
    public function obtenerPaciente($id)
    {
        $query = "SELECT p.*, o.nombre as nombre_propietario, o.cedula 
                  FROM " . $this->table . " p
                  JOIN propietarios o ON p.propietarios_id = o.id
                  WHERE p.id = '$id'";
        return parent::obtenerDatos($query);
    }

    // Método para agregar un nuevo paciente
    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['nombre']) || !isset($datos['genero'])) {
            return $_respuestas->error_400();
        } else {
            // Asignar datos al paciente
            $this->nombre = $datos['nombre'];
            $this->genero = $datos['genero'];
            $this->color = isset($datos['color']) ? $datos['color'] : "";
            $this->sexo = isset($datos['sexo']) ? $datos['sexo'] : "";
            $this->fecha_nacimiento = isset($datos['fecha_nacimiento']) ? $datos['fecha_nacimiento'] : "0000-00-00";
            $this->sena_particular = isset($datos['sena_particular']) ? $datos['sena_particular'] : "";
            $this->procedencia = isset($datos['procedencia']) ? $datos['procedencia'] : "";
            $this->alergias = isset($datos['alergias']) ? $datos['alergias'] : "";
            $this->enfermedades_anteriores = isset($datos['enfermedades_anteriores']) ? $datos['enfermedades_anteriores'] : "";
            $this->antecedentes_familiares = isset($datos['antecedentes_familiares']) ? $datos['antecedentes_familiares'] : "";
            $this->propietarios_id = isset($datos['propietarios_id']) ? $datos['propietarios_id'] : "";

            // Insertar paciente
            $resp = $this->insertarPaciente();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array("id" => $resp);
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    // Método privado para insertar paciente
    private function insertarPaciente()
    {
        $query = "INSERT INTO " . $this->table . " (nombre, genero, color, sexo, fecha_nacimiento, sena_particular, procedencia, alergias, enfermedades_anteriores, antecedentes_familiares, propietarios_id)
                  VALUES ('$this->nombre', '$this->genero', '$this->color', '$this->sexo', '$this->fecha_nacimiento', '$this->sena_particular', '$this->procedencia', '$this->alergias', '$this->enfermedades_anteriores', '$this->antecedentes_familiares', '$this->propietarios_id')";
        $resp = parent::nonQueryId($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }

    // Método para actualizar un paciente
    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            // Asignar datos actualizados
            $this->id = $datos['id'];
            $this->nombre = isset($datos['nombre']) ? $datos['nombre'] : $this->nombre;
            $this->genero = isset($datos['genero']) ? $datos['genero'] : $this->genero;
            $this->color = isset($datos['color']) ? $datos['color'] : $this->color;
            $this->sexo = isset($datos['sexo']) ? $datos['sexo'] : $this->sexo;
            $this->fecha_nacimiento = isset($datos['fecha_nacimiento']) ? $datos['fecha_nacimiento'] : $this->fecha_nacimiento;
            $this->sena_particular = isset($datos['sena_particular']) ? $datos['sena_particular'] : $this->sena_particular;
            $this->procedencia = isset($datos['procedencia']) ? $datos['procedencia'] : $this->procedencia;
            $this->alergias = isset($datos['alergias']) ? $datos['alergias'] : $this->alergias;
            $this->enfermedades_anteriores = isset($datos['enfermedades_anteriores']) ? $datos['enfermedades_anteriores'] : $this->enfermedades_anteriores;
            $this->antecedentes_familiares = isset($datos['antecedentes_familiares']) ? $datos['antecedentes_familiares'] : $this->antecedentes_familiares;
            $this->propietarios_id = isset($datos['propietarios_id']) ? $datos['propietarios_id'] : $this->propietarios_id;

            // Actualizar paciente
            $resp = $this->modificarPaciente();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array("id" => $this->id);
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    // Método privado para modificar paciente
    private function modificarPaciente()
    {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = '$this->nombre', genero = '$this->genero', color = '$this->color', sexo = '$this->sexo', fecha_nacimiento = '$this->fecha_nacimiento', 
                  sena_particular = '$this->sena_particular', procedencia = '$this->procedencia', alergias = '$this->alergias', enfermedades_anteriores = '$this->enfermedades_anteriores', 
                  antecedentes_familiares = '$this->antecedentes_familiares', propietarios_id = '$this->propietarios_id' 
                  WHERE id = '$this->id'";
        $resp = parent::nonQuery($query);
        return ($resp >= 1) ? $resp : 0;
    }

    // Método para eliminar paciente
    // Método para eliminar paciente
    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400(); // Error si no se pasa el ID.
        }

        $id = $datos['id'];

        // Eliminar historias asociadas al paciente
        $queryDeleteHistorias = "DELETE FROM historias WHERE pacientes_id = '$id'";
        parent::nonQuery($queryDeleteHistorias);

        // Eliminar vacunas asociadas al paciente
        $queryDeleteVacunas = "DELETE FROM vacunas WHERE pacientes_id = '$id'";
        parent::nonQuery($queryDeleteVacunas);

        // Eliminar desparasitaciones asociadas al paciente
        $queryDeleteDesparasitaciones = "DELETE FROM desparasitaciones WHERE pacientes_id = '$id'";
        parent::nonQuery($queryDeleteDesparasitaciones);

        // Ahora eliminar el paciente
        $query = "DELETE FROM pacientes WHERE id = '$id'";
        $deleteResult = parent::nonQuery($query);

        if ($deleteResult > 0) {
            return array(
                'status' => 'success',
                'result' => array(
                    'id' => $id
                ),
                'message' => 'Paciente y sus registros han sido eliminados correctamente'
            );
        } else {
            return $_respuestas->error_500(); // Error interno si la eliminación falla.
        }
    }
}
    

    // Método privado para eliminar paciente