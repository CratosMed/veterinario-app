<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class propietarios extends conexion
{
    private $table = "propietarios";
    private $id = "";
    private $cedula = "";
    private $nombre = "";
    private $apellido = "";
    private $direccion = "";
    private $telefono = "";
    private $correo = "";
    private $deuda = "";
    // private $token = ""; // Se comenta el token ya que no se usará

    public function listaPropietarios($pagina = 1)
    {
        $inicio  = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT id, nombre, apellido, cedula, telefono, direccion, correo, deuda FROM " . $this->table . " limit $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerPropietarios($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }

    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        // Ya no es necesario validar el token
        // if (!isset($datos['token'])) {
        //     return $_respuestas->error_401();
        // } else {
        // $this->token = $datos['token'];
        // $arrayToken = $this->buscarToken();
        // if ($arrayToken) {

        if (!isset($datos['cedula']) || !isset($datos['telefono'])) {
            return $_respuestas->error_400();
        } else {
            $this->cedula = $datos['cedula'];
            $this->telefono = $datos['telefono'];

            // Verificar y asignar los demás campos
            if (isset($datos['nombre'])) {
                $this->nombre = $datos['nombre'];
            }
            if (isset($datos['apellido'])) {
                $this->apellido = $datos['apellido'];
            }
            if (isset($datos['direccion'])) {
                $this->direccion = $datos['direccion'];
            }
            if (isset($datos['correo'])) {
                $this->correo = $datos['correo'];
            }
            if (isset($datos['deuda'])) {
                $this->deuda = $datos['deuda'];
            }

            $resp = $this->insertarPropietarios();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array("id" => $resp);
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
        // }
        // else {
        //     return $_respuestas->error_401("El Token que envió es inválido o ha caducado");
        // }
        // }
    }

    private function insertarPropietarios()
    {
        $query = "INSERT INTO " . $this->table . " (cedula, nombre, apellido, direccion, telefono, correo, deuda) 
        VALUES ('" . $this->cedula . "', '" . $this->nombre . "', '" . $this->apellido . "', '" . $this->direccion . "', '" . $this->telefono . "', '" . $this->correo . "', '" . $this->deuda . "')";

        $resp = parent::nonQueryId($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }

    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        // Ya no es necesario validar el token
        // if (!isset($datos['token'])) {
        //     return $_respuestas->error_401();
        // } else {
        // $this->token = $datos['token'];
        // $arrayToken = $this->buscarToken();
        // if ($arrayToken) {

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];
            if (isset($datos['nombre'])) {
                $this->nombre = $datos['nombre'];
            }
            if (isset($datos['apellido'])) {
                $this->apellido = $datos['apellido'];
            }
            if (isset($datos['cedula'])) {
                $this->cedula = $datos['cedula'];
            }
            if (isset($datos['direccion'])) {
                $this->direccion = $datos['direccion'];
            }
            if (isset($datos['telefono'])) {
                $this->telefono = $datos['telefono'];
            }
            if (isset($datos['correo'])) {
                $this->correo = $datos['correo'];
            }
            if (isset($datos['deuda'])) {
                $this->deuda = $datos['deuda'];
            }

            $resp = $this->modificarPropietarios();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array("id" => $this->id);
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
        // }
        // else {
        //     return $_respuestas->error_401("El Token que envió es inválido o ha caducado");
        // }
        // }
    }

    private function modificarPropietarios()
    {
        $query = "UPDATE " . $this->table . " SET nombre ='" . $this->nombre . "', apellido = '" . $this->apellido . "', direccion = '" . $this->direccion . "', cedula = '" . $this->cedula . "', telefono = '" . $this->telefono . "', correo = '" . $this->correo . "', deuda = '" . $this->deuda . "' WHERE id = '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

    public function delete($json)

    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos['id'])) {
            return $_respuestas->error_400(); // Error si no se pasa el ID.
        }

        $id = $datos['id'];

        // Verifica si el propietario tiene pacientes asociados
        $queryCheck = "SELECT COUNT(*) as total FROM pacientes WHERE propietarios_id = '$id'";
        $result = parent::obtenerDatos($queryCheck);
        if ($result[0]['total'] > 0) {
            // Si tiene pacientes asociados, devolvemos un error
            return array(
                'status' => 'error',
                'result' => array(
                    'error_id' => 'foreign_key',
                    'message' => 'No se puede eliminar el cliente porque tiene pacientes asociados.'
                )
            );
        }

        // Si no tiene pacientes asociados, intentamos eliminarlo
        $query = "DELETE FROM propietarios WHERE id = '$id'";
        $deleteResult = parent::nonQuery($query);

        if ($deleteResult > 0) {
            return array(
                'status' => 'success',
                'result' => array(
                    'id' => $id
                ),
                'message' => 'Cliente eliminado correctamente'
            );
        } else {
            return $_respuestas->error_500(); // Error interno si la eliminación falla.
        }
    }


    private function eliminarPropietarios()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = '" . $this->id . "'";
        try {
            $resp = parent::nonQuery($query);
            if ($resp >= 1) {
                return $resp; // Eliminación exitosa
            } else {
                return 0; // No se eliminó nada
            }
        } catch (mysqli_sql_exception $e) {
            $_respuestas = new respuestas;
            // Manejar la excepción específica para la restricción de clave foránea
            if ($e->getCode() == 23000) { // Código de error para violación de clave foránea
                return $_respuestas->error_foreign_key();
            }
            // Para otros errores
            return $_respuestas->error_500("Error al intentar eliminar el propietario.");
        }
    }


    // Funciones relacionadas con el token ya no son necesarias
    // private function buscarToken() { }
    // private function actualizarToken($tokenid) { }
}
