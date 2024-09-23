<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class vacunas extends conexion
{

    private $table = "vacunas";
    private $table2 = "pacientes";
    private $id = "";
    private $nombre = "";
    private $numero = "";
    private $pacientes_id = "";
    private $fecha = "0000-00-00";
    private $token = "";
    //912bc00f049ac8464472020c5cd06759

    public function listavacunas($pagina = 1)
    {
        $inicio  = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "select vacunas.*, pacientes.nombre as nombre_paciente from " . $this->table . "," . $this->table2 . " where vacunas.pacientes_id = pacientes.id limit $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenervacunas($id)
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
                if (!isset($datos['nombre']) || !isset($datos['numero'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->nombre = $datos['nombre'];
                    $this->numero = $datos['numero'];

                    if (isset($datos['fecha'])) {
                        $this->fecha = $datos['fecha'];
                    }

                    if (isset($datos['pacientes_id'])) {
                        $this->pacientes_id = $datos['pacientes_id'];
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
            } else {
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }
    }


    private function insertarvacunas()
    {
        $query = "INSERT INTO " . $this->table . " (nombre,fecha,numero,pacientes_id)
        values
        ('" . $this->nombre . "','" . $this->fecha . "','" . $this->numero . "','" . $this->pacientes_id . "')";
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
                    if (isset($datos['nombre'])) {
                        $this->nombre = $datos['nombre'];
                    }
                    if (isset($datos['fecha'])) {
                        $this->fecha = $datos['fecha'];
                    }
                    if (isset($datos['numero'])) {
                        $this->numero = $datos['numero'];
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
            } else {
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }
    }


    private function modificarvacuna()
    {
        $query = "UPDATE " . $this->table . " SET nombre ='" . $this->nombre . "',fecha = '" . $this->fecha . "', numero = '" . $this->numero . "', pacientes_id = '" .
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
            } else {
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }
    }


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
