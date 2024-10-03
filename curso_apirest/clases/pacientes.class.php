<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class pacientes extends conexion
{
    private $table = "pacientes";
    private $table2 = "propietarios";
    private $id = "";
    private $fecha = "";
    private $nombre = "";
    private $raza = "";
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

        // $datos = json_decode($json, true);
        // error_log($datos);
        // Verificar si los campos requeridos están presentes
        if (!isset($json['nombre']) || !isset($json['raza']) || !isset($json['especie']) || !isset($json['propietarios_id'])) {
            return $_respuestas->error_400();
        }

        // Asignar valores
        $this->nombre = $json['nombre'];
        $this->fecha = date("Y-m-d"); // Si no llega, usa la fecha actual
        $this->raza = $json['raza'];
        $this->especie = isset($json['especie']) ? $json['especie'] : "";
        $this->color = isset($json['color']) ? $json['color'] : "";
        $this->sexo = isset($json['sexo']) ? $json['sexo'] : "";

        // Cambiar 'fecha_nacimiento' a 'fechaNacimiento'
        $this->fecha_nacimiento = isset($json['fechaNacimiento']) ? $json['fechaNacimiento'] : "0000-00-00";

        $this->alergias = isset($json['alergias']) ? $json['alergias'] : "";
        $this->propietarios_id = isset($json['propietarios_id']) ? $json['propietarios_id'] : "";

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
        $query = "INSERT INTO " . $this->table . " (nombre, fecha, raza, especie, color, sexo, fecha_nacimiento, alergias, propietarios_id, foto)
                  VALUES ('$this->nombre','$this->fecha', '$this->raza', '$this->especie', '$this->color', '$this->sexo', '$this->fecha_nacimiento', '$this->alergias', '$this->propietarios_id', '$this->foto')";
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
    public function updatePaciente($id)
    {
        $_respuestas = new respuestas;

        // Verificar si el ID es nulo o está vacío
        if (empty($id)) {
            return $_respuestas->error_400();
        }

        // Asignar los datos del formulario
        $this->id = $id;
        $this->nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
        $this->raza = isset($_POST['raza']) ? $_POST['raza'] : "";
        $this->especie = isset($_POST['especie']) ? $_POST['especie'] : "";
        $this->color = isset($_POST['color']) ? $_POST['color'] : "";
        $this->sexo = isset($_POST['sexo']) ? $_POST['sexo'] : "";
        $this->fecha_nacimiento = isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : "0000-00-00";
        $this->alergias = isset($_POST['alergias']) ? $_POST['alergias'] : "";
        $this->propietarios_id = isset($_POST['propietarios_id']) ? $_POST['propietarios_id'] : "";

        // Verificar si se ha subido una imagen nueva y guardarla
        if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
            $this->foto = $this->guardarFoto($_FILES['foto']);
        } else {
            // Si no hay imagen nueva, mantenemos la foto anterior o dejamos el campo vacío
            $this->foto = isset($_POST['foto']) ? $_POST['foto'] : ""; // Si el frontend envía la URL o nombre de la imagen anterior
        }

        // Llamada para actualizar el paciente en la base de datos
        $resp = $this->modificarPaciente();
        if ($resp) {
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array("id" => $this->id);
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }


    // Método para modificar paciente en la base de datos
    private function modificarPaciente()
    {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = '$this->nombre', raza = '$this->raza', especie = '$this->especie', color = '$this->color', 
                      sexo = '$this->sexo', fecha_nacimiento = '$this->fecha_nacimiento', alergias = '$this->alergias', 
                      propietarios_id = '$this->propietarios_id', foto = '$this->foto' 
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
