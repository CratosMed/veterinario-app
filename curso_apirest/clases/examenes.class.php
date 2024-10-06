<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class examenes extends conexion
{
    private $table = "examenes";
    private $id = "";
    private $fecha = "";
    private $tipo = "";
    private $descripcion = "";
    private $foto = "";
    private $paciente_id = "";

    // Método para listar exámenes
    public function listaExamenes($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;

        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM " . $this->table . " LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    // Método para obtener un examen por ID
    public function obtenerExamen($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }
    public function obtenerExamenes($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE paciente_id = '$id'";
        return parent::obtenerDatos($query);
    }

    // Método para agregar un nuevo examen
    public function post($json, $files)
    {
        $_respuestas = new respuestas;

        if ($json === null) {
            return $_respuestas->error_400();
        }

        // Verificar los campos requeridos
        if (!isset($json['tipo']) || !isset($json['descripcion']) || !isset($json['paciente_id'])) {
            return $_respuestas->error_400();
        }

        // Asignar valores
        $this->tipo = $json['tipo'];
        $this->fecha = date("Y-m-d"); // Fecha actual
        $this->descripcion = $json['descripcion'];
        $this->paciente_id = $json['paciente_id'];

        // Manejar la imagen si está presente
        if (isset($files['foto']) && !empty($files['foto']['name'])) {
            $this->foto = $this->guardarFoto($files['foto']);
        } else {
            $this->foto = ""; // O valor por defecto
        }

        // Insertar examen
        $resp = $this->insertarExamen();
        if ($resp) {
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array("id" => $resp);
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }

    // Método privado para insertar examen
    private function insertarExamen()
    {
        $query = "INSERT INTO " . $this->table . " (fecha, tipo, descripcion, foto, paciente_id)
                  VALUES ('$this->fecha', '$this->tipo', '$this->descripcion', '$this->foto', '$this->paciente_id')";
        $resp = parent::nonQueryId($query);
        return $resp;
    }

    // Método para manejar la subida de imágenes
    private function guardarFoto($file)
    {
        $directorio = "imagenes_examenes/";
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid() . "." . $extension;
        $ruta = $directorio . $nombreArchivo;

        if (move_uploaded_file($file['tmp_name'], $ruta)) {
            return $ruta;
        } else {
            return null;
        }
    }

    // Método para actualizar un examen
    public function updateExamen($id, $json, $files)
    {
        $_respuestas = new respuestas;

        if (empty($id)) {
            return $_respuestas->error_400();
        }

        $this->id = $id;
        $this->tipo = isset($json['tipo']) ? $json['tipo'] : "";
        $this->descripcion = isset($json['descripcion']) ? $json['descripcion'] : "";
        $this->paciente_id = isset($json['paciente_id']) ? $json['paciente_id'] : "";

        // Si hay una nueva imagen, guardarla
        if (isset($files['foto']) && !empty($files['foto']['name'])) {
            $this->foto = $this->guardarFoto($files['foto']);
        } else {
            $this->foto = isset($json['foto']) ? $json['foto'] : ""; // Mantener la foto actual
        }

        $resp = $this->modificarExamen();
        if ($resp) {
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array("id" => $this->id);
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }

    // Método privado para modificar examen
    private function modificarExamen()
    {
        $query = "UPDATE " . $this->table . " 
                  SET tipo = '$this->tipo', descripcion = '$this->descripcion', foto = '$this->foto', paciente_id = '$this->paciente_id' 
                  WHERE id = '$this->id'";
        $resp = parent::nonQuery($query);
        return ($resp >= 1) ? $resp : 0;
    }

    // Método para eliminar un examen
    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        }

        $id = $datos['id'];

        // Eliminar el examen
        $query = "DELETE FROM " . $this->table . " WHERE id = '$id'";
        $deleteResult = parent::nonQuery($query);

        if ($deleteResult > 0) {
            return array(
                'status' => 'success',
                'result' => array('id' => $id),
                'message' => 'Examen eliminado correctamente'
            );
        } else {
            return $_respuestas->error_500();
        }
    }
}
