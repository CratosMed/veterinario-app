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
    private $especie = ""; // Campo nuevo
    private $color = "";
    private $sexo = "";
    private $fecha_nacimiento = "0000-00-00";
    private $alergias = "";
    private $propietarios_id = "";
    private $foto = ""; // Campo nuevo

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
    // Método para agregar un nuevo paciente
    public function post($json, $files)
    {
        $_respuestas = new respuestas;

        // Si el JSON es nulo, retorna error
        if ($json === null) {
            return $_respuestas->error_400();
        }

        $datos = json_decode($json, true);

        // Verificar si los campos requeridos están presentes
        if (!isset($datos['nombre']) || !isset($datos['genero']) || !isset($datos['especie']) || !isset($datos['propietarios_id'])) {
            return $_respuestas->error_400();
        }

        error_log(print_r($datos, true));
        error_log(print_r($_POST, true)); // Para verificar los datos POST
        error_log(print_r($_FILES, true)); // Para verificar los archivos subidos

        // Asignar valores
        $this->nombre = $datos['nombre'];
        $this->genero = $datos['genero'];
        $this->especie = isset($datos['especie']) ? $datos['especie'] : "";
        $this->color = isset($datos['color']) ? $datos['color'] : "";
        $this->sexo = isset($datos['sexo']) ? $datos['sexo'] : "";

        // Cambiar 'fecha_nacimiento' a 'fechaNacimiento'
        $this->fecha_nacimiento = isset($datos['fechaNacimiento']) ? $datos['fechaNacimiento'] : "0000-00-00";

        $this->alergias = isset($datos['alergias']) ? $datos['alergias'] : "";
        $this->propietarios_id = isset($datos['propietarios_id']) ? $datos['propietarios_id'] : "";

        // Verificar si hay una imagen subida
        if (isset($files['foto']) && !empty($files['foto']['name'])) {
            $this->foto = $this->guardarFoto($files['foto']); // Asegúrate que este método retorne la ruta
        } else {
            $this->foto = ""; // O asignar un valor por defecto si no hay foto
        }

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

    // Método privado para insertar paciente
    private function insertarPaciente()
    {
        $query = "INSERT INTO " . $this->table . " (nombre, genero, especie, color, sexo, fecha_nacimiento, alergias, propietarios_id, foto)
                  VALUES ('$this->nombre', '$this->genero', '$this->especie', '$this->color', '$this->sexo', '$this->fecha_nacimiento', '$this->alergias', '$this->propietarios_id', '$this->foto')";
        $resp = parent::nonQueryId($query);
        return $resp;
    }
    // Método para manejar la subida de imágenes
    private function guardarFoto($file)
    {
        $directorio = "imagenes_pacientes/"; // Directorio donde guardar las imágenes
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid() . "." . $extension;
        $ruta = $directorio . $nombreArchivo;

        // Mover el archivo al servidor
        if (move_uploaded_file($file['tmp_name'], $ruta)) {
            return $ruta; // Devolver la ruta donde se guardó la imagen
        } else {
            return null; // Si falla la subida
        }
    }
    // Método para actualizar un paciente
    public function put($json, $files)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];
            $this->nombre = isset($datos['nombre']) ? $datos['nombre'] : $this->nombre;
            $this->genero = isset($datos['genero']) ? $datos['genero'] : $this->genero;
            $this->especie = isset($datos['especie']) ? $datos['especie'] : $this->especie;
            $this->color = isset($datos['color']) ? $datos['color'] : $this->color;
            $this->sexo = isset($datos['sexo']) ? $datos['sexo'] : $this->sexo;
            $this->fecha_nacimiento = isset($datos['fecha_nacimiento']) ? $datos['fecha_nacimiento'] : $this->fecha_nacimiento;
            $this->alergias = isset($datos['alergias']) ? $datos['alergias'] : $this->alergias;
            $this->propietarios_id = isset($datos['propietarios_id']) ? $datos['propietarios_id'] : $this->propietarios_id;

            // Verificar si se ha subido una nueva imagen
            if (isset($files['foto'])) {
                $this->foto = $this->guardarFoto($files['foto']);
            }

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
                  SET nombre = '$this->nombre', genero = '$this->genero', especie = '$this->especie', color = '$this->color', sexo = '$this->sexo', 
                  fecha_nacimiento = '$this->fecha_nacimiento', alergias = '$this->alergias', propietarios_id = '$this->propietarios_id', foto = '$this->foto' 
                  WHERE id = '$this->id'";
        $resp = parent::nonQuery($query);
        return ($resp >= 1) ? $resp : 0;
    }

    // Método para eliminar paciente
    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
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

        // Eliminar paciente
        $query = "DELETE FROM pacientes WHERE id = '$id'";
        $deleteResult = parent::nonQuery($query);

        if ($deleteResult > 0) {
            return array(
                'status' => 'success',
                'result' => array('id' => $id),
                'message' => 'Paciente y sus registros han sido eliminados correctamente'
            );
        } else {
            return $_respuestas->error_500();
        }
    }
}
