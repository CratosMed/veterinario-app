<?php



class conexion
{

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;


    function __construct()
    {
        $listadatos = $this->datosConexion();
        foreach ($listadatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        if ($this->conexion->connect_errno) {
            echo "algo va mal con la conexion";
            die();
        }
    }

    private function datosConexion()
    {
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/" . "config");
        return json_decode($jsondata, true);
    }


    private function convertirUTF8($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });
        return $array;
    }


    public function obtenerDatos($sqlstr)
    {
        $results = $this->conexion->query($sqlstr);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        return $this->convertirUTF8($resultArray);
    }

    public function nonQuery($sqlstr, $params = [])
    {
        $stmt = $this->conexion->prepare($sqlstr);
        if ($params) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }

        if (!$stmt->execute()) {
            // Verificar si el error es por la restricción de clave foránea
            if ($this->conexion->errno == 1451) {
                return [
                    'status' => 'error',
                    'error_id' => 'foreign_key',
                    'message' => 'No se puede eliminar el cliente porque tiene pacientes asociados.'
                ];
            }
            // Manejo de otros errores
            return [
                'status' => 'error',
                'error_id' => $this->conexion->errno,
                'message' => 'Error en la consulta: ' . $this->conexion->error
            ];
        }

        return $stmt->affected_rows;
    }





    //INSERT 
    public function nonQueryId($sqlstr)
    {
        $results = $this->conexion->query($sqlstr);
        $filas = $this->conexion->affected_rows;
        if ($filas >= 1) {
            return $this->conexion->insert_id;
        } else {
            return 0;
        }
    }

    //encriptar

    protected function encriptar($string)
    {
        return md5($string);
    }
}
