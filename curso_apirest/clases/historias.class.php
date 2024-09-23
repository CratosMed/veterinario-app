<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class historias extends conexion
{

    private $table = "historias";
    private $table2 = "pacientes";
    private $id = "";
    private $comida = "";
    private $estado_reproductivo = "";
    private $temperatura = "";
    private $frecuencia_cardiaca = "";
    private $frecuencia_respiratoria = "";
    private $peso = "";
    private $motivo_consulta = "0000-00-00";
    private $anamnecicos = "";
    private $constantes_fisiologicas = "";
    private $actitud = "";
    private $condicion_corporal = "";
    private $estado_deshidratacion = "";
    private $mucosa = "";
    private $oral = "";
    private $ojos = "";
    private $aparato_reproductor = "";
    private $rectal = "";
    private $oidos = "";
    private $nodulos = "";
    private $piel = "";
    private $locomocion = "";
    private $pacientes_id = "";
    private $token = "";
    //912bc00f049ac8464472020c5cd06759

    public function listahistorias($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;

        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1));
        }

        $query = "
            SELECT 
                historias.*, 
                pacientes.nombre AS nombre_paciente, 
                propietarios.nombre AS nombre_propietario 
            FROM 
                historias
            JOIN 
                pacientes ON historias.pacientes_id = pacientes.id
            JOIN 
                propietarios ON pacientes.propietarios_id = propietarios.id 
            LIMIT 
                $inicio, $cantidad
        ";

        $datos = parent::obtenerDatos($query);
        return $datos;
    }



    public function obtenerhistorias($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE pacientes_id = '$id'";
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
                if (!isset($datos['comida']) || !isset($datos['estado_reproductivo'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->comida = $datos['comida'];
                    $this->estado_reproductivo = $datos['estado_reproductivo'];

                    if (isset($datos['temperatura'])) {
                        $this->temperatura = $datos['temperatura'];
                    }
                    if (isset($datos['frecuencia_cardiaca'])) {
                        $this->frecuencia_cardiaca = $datos['frecuencia_cardiaca'];
                    }
                    if (isset($datos['motivo_consulta'])) {
                        $this->motivo_consulta = $datos['motivo_consulta'];
                    }
                    if (isset($datos['frecuencia_respiratoria'])) {
                        $this->frecuencia_respiratoria = $datos['frecuencia_respiratoria'];
                    }
                    if (isset($datos['frecuencia_respiratoria'])) {
                        $this->frecuencia_respiratoria = $datos['frecuencia_respiratoria'];
                    }
                    if (isset($datos['peso'])) {
                        $this->peso = $datos['peso'];
                    }
                    if (isset($datos['constantes_fisiologicas'])) {
                        $this->constantes_fisiologicas = $datos['constantes_fisiologicas'];
                    }
                    if (isset($datos['actitud'])) {
                        $this->actitud = $datos['actitud'];
                    }
                    if (isset($datos['condicion_corporal'])) {
                        $this->condicion_corporal = $datos['condicion_corporal'];
                    }
                    if (isset($datos['estado_deshidratacion'])) {
                        $this->estado_deshidratacion = $datos['estado_deshidratacion'];
                    }
                    if (isset($datos['mucosa'])) {
                        $this->mucosa = $datos['mucosa'];
                    }
                    if (isset($datos['oral'])) {
                        $this->oral = $datos['oral'];
                    }
                    if (isset($datos['ojos'])) {
                        $this->ojos = $datos['ojos'];
                    }
                    if (isset($datos['aparato_reproductor'])) {
                        $this->aparato_reproductor = $datos['aparato_reproductor'];
                    }
                    if (isset($datos['rectal'])) {
                        $this->rectal = $datos['rectal'];
                    }
                    if (isset($datos['oidos'])) {
                        $this->oidos = $datos['oidos'];
                    }
                    if (isset($datos['nodulos'])) {
                        $this->nodulos = $datos['nodulos'];
                    }
                    if (isset($datos['piel'])) {
                        $this->piel = $datos['piel'];
                    }
                    if (isset($datos['locomocion'])) {
                        $this->locomocion = $datos['locomocion'];
                    }
                    if (isset($datos['pacientes_id'])) {
                        $this->pacientes_id = $datos['pacientes_id'];
                    }

                    $resp = $this->insertarhistorias();
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


    private function insertarhistorias()
    {
        $query = "INSERT INTO " . $this->table . " (comida,estado_reproductivo,temperatura,frecuencia_cardiaca,motivo_consulta,
        frecuencia_respiratoria,peso,anamnecicos,constantes_fisiologicas,actitud,condicion_corporal,estado_deshidratacion,mucosa,oral,
        ojos,aparato_reproductor,rectal,oidos,nodulos,piel,locomocion,pacientes_id)
        values
        ('" . $this->comida . "','" . $this->estado_reproductivo . "','" . $this->temperatura . "','" . $this->frecuencia_cardiaca . "','"
            . $this->motivo_consulta . "','" . $this->frecuencia_respiratoria . "','" . $this->peso . "','" .
            $this->anamnecicos . "','"  . $this->constantes_fisiologicas . "','"  . $this->actitud . "','"  . $this->condicion_corporal . "','"  . $this->estado_deshidratacion . "','"  .
            $this->mucosa . "','"  . $this->oral . "','"  . $this->ojos . "','"  . $this->aparato_reproductor . "','"  . $this->rectal . "','"  . $this->oidos . "','"  . $this->nodulos . "','"  .
            $this->piel . "','"  . $this->locomocion . "','"  . $this->pacientes_id . "')";
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
                    if (isset($datos['comida'])) {
                        $this->comida = $datos['comida'];
                    }
                    if (isset($datos['estado_reproductivo'])) {
                        $this->estado_reproductivo = $datos['estado_reproductivo'];
                    }
                    if (isset($datos['temperatura'])) {
                        $this->temperatura = $datos['temperatura'];
                    }
                    if (isset($datos['frecuencia_cardiaca'])) {
                        $this->frecuencia_cardiaca = $datos['frecuencia_cardiaca'];
                    }
                    if (isset($datos['motivo_consulta'])) {
                        $this->motivo_consulta = $datos['motivo_consulta'];
                    }
                    if (isset($datos['frecuencia_respiratoria'])) {
                        $this->frecuencia_respiratoria = $datos['frecuencia_respiratoria'];
                    }
                    if (isset($datos['anamnecicos'])) {
                        $this->anamnecicos = $datos['anamnecicos'];
                    }
                    if (isset($datos['peso'])) {
                        $this->peso = $datos['peso'];
                    }
                    if (isset($datos['constantes_fisiologicas'])) {
                        $this->constantes_fisiologicas = $datos['constantes_fisiologicas'];
                    }
                    if (isset($datos['actitud'])) {
                        $this->actitud = $datos['actitud'];
                    }
                    if (isset($datos['condicion_corporal'])) {
                        $this->condicion_corporal = $datos['condicion_corporal'];
                    }
                    if (isset($datos['estado_deshidratacion'])) {
                        $this->estado_deshidratacion = $datos['estado_deshidratacion'];
                    }
                    if (isset($datos['mucosa'])) {
                        $this->mucosa = $datos['mucosa'];
                    }
                    if (isset($datos['oral'])) {
                        $this->oral = $datos['oral'];
                    }
                    if (isset($datos['ojos'])) {
                        $this->ojos = $datos['ojos'];
                    }
                    if (isset($datos['aparato_reproductor'])) {
                        $this->aparato_reproductor = $datos['aparato_reproductor'];
                    }
                    if (isset($datos['rectal'])) {
                        $this->rectal = $datos['rectal'];
                    }
                    if (isset($datos['oidos'])) {
                        $this->oidos = $datos['oidos'];
                    }
                    if (isset($datos['nodulos'])) {
                        $this->nodulos = $datos['nodulos'];
                    }
                    if (isset($datos['piel'])) {
                        $this->piel = $datos['piel'];
                    }
                    if (isset($datos['locomocion'])) {
                        $this->locomocion = $datos['locomocion'];
                    }
                    if (isset($datos['pacientes_id'])) {
                        $this->pacientes_id = $datos['pacientes_id'];
                    }

                    $resp = $this->modificarhistoria();
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


    private function modificarhistoria()
    {
        $query = "UPDATE " . $this->table . " SET comida ='" . $this->comida . "',estado_reproductivo = '" . $this->estado_reproductivo . "', temperatura = '" . $this->temperatura . "', motivo_consulta = '" .
            $this->motivo_consulta . "', frecuencia_respiratoria = '" . $this->frecuencia_respiratoria . "', peso = '" . $this->peso . "', anamnecicos = '" . $this->anamnecicos .
            "', constantes_fisiologicas = '" . $this->constantes_fisiologicas . "', actitud = '" . $this->actitud . "', condicion_corporal = '" . $this->condicion_corporal . "', estado_deshidratacion = '" . $this->estado_deshidratacion .
            "', mucosa = '" . $this->mucosa . "', oral = '" . $this->oral . "', ojos = '" . $this->ojos . "', aparato_reproductor = '" . $this->aparato_reproductor . "', rectal = '" . $this->rectal .
            "', oidos = '" . $this->oidos . "', nodulos = '" . $this->nodulos . "', piel = '" . $this->piel . "', locomocion = '" . $this->locomocion . "', pacientes_id = '" . $this->pacientes_id .
            "' WHERE id = '" . $this->id . "'";

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
                    $resp = $this->eliminarhistoria();
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


    private function eliminarhistoria()
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
