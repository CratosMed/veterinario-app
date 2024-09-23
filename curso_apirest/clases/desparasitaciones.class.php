<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class desparasitaciones extends conexion
{

    private $table = "desparasitaciones";
    private $table2 = "pacientes";
    private $id = "";
    private $producto = "";
    private $pacientes_id = "";
    private $fecha = "0000-00-00";
    private $token = "";
    //912bc00f049ac8464472020c5cd06759

    public function listadesparasitaciones($pagina = 1)
    {
        $inicio  = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "select desparasitaciones.*, pacientes.nombre as nombre_paciente from " . $this->table . "," . $this->table2 . " where desparasitaciones.pacientes_id = pacientes.id limit $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerdesparasitaciones($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }

    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['producto']) || !isset($datos['fecha'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->producto = $datos['producto'];
                    $this->fecha = $datos['fecha'];

                    if (isset($datos['pacientes_id'])) {
                        $this->pacientes_id = $datos['pacientes_id'];
                    }

                    $resp = $this->insertardesparasitaciones();
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
            } else {
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }
    }


    private function insertardesparasitaciones()
    {
        $query = "INSERT INTO " . $this->table . " (producto,fecha,pacientes_id)
        values
        ('" . $this->producto . "','" .  $this->fecha . "','" . $this->pacientes_id . "')";
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

        if (!isset($datos['token'])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['id'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->id = $datos['id'];
                    if (isset($datos['producto'])) {
                        $this->producto = $datos['producto'];
                    }
                    if (isset($datos['fecha'])) {
                        $this->fecha = $datos['fecha'];
                    }

                    if (isset($datos['pacientes_id'])) {
                        $this->pacientes_id = $datos['pacientes_id'];
                    }

                    $resp = $this->modificardesparasitacion();
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
            } else {
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }
    }


    private function modificardesparasitacion()
    {
        $query = "UPDATE " . $this->table . " SET producto ='" . $this->producto .  "', fecha = '" . $this->fecha . "', pacientes_id = '" .
            $this->pacientes_id . "' WHERE id = '" . $this->id . "'";

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

        if (!isset($datos['token'])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if ($arrayToken) {

                if (!isset($datos['id'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->id = $datos['id'];
                    $resp = $this->eliminardesparasitacion();
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
            } else {
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }
    }


    private function eliminardesparasitacion()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id= '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }


    private function buscarToken()
    {
        $query = "SELECT  TokenId,UsuarioId,Estado from usuarios_token WHERE Token = '" . $this->token . "' AND Estado = 'Activo'";
        $resp = parent::obtenerDatos($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }


    private function actualizarToken($tokenid)
    {
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuarios_token SET Fecha = '$date' WHERE TokenId = '$tokenid' ";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}
