<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class historias extends conexion
{
    private $table = "historias";
    private $id = "";
    private $fecha = "";
    private $veterinario = "";
    private $comida = "";
    private $estado_reproductivo = "";
    private $ultimo_celo = "";
    private $ultimo_parto = "";
    private $sistema_reproductor = "";
    private $senas_particulares = "";
    private $transfusiones = "";
    private $temperatura = "";
    private $presion_arterial = "";
    private $reflejo_tusigeno = "";
    private $reflejo_deglutorio = "";
    private $frecuencia_cardiaca = "";
    private $sistema_cardiovascular = "";
    private $frecuencia_respiratoria = "";
    private $sistema_respiratorio = "";
    private $sistema_digestivo = "";
    private $sistema_genitourinario = "";
    private $peso = "";
    private $motivo_consulta = "";
    private $diagnostico = "";
    private $tratamiento = "";
    private $observaciones = "";
    private $anamnesicos = "";
    private $constantes_fisiologicas = "";
    private $actitud = "";
    private $condicion_corporal = "";
    private $estado_deshidratacion = "";
    private $mucosa = "";
    private $oral = "";
    private $vulvar_prepucial = "";
    private $ojos = "";
    private $aparato_reproductor = "";
    private $rectal = "";
    private $oidos = "";
    private $nodulos = "";
    private $piel = "";
    private $locomocion = "";
    private $sistema_musculoesqueletico = "";
    private $sistema_nervioso = "";
    private $pacientes_id = "";
    private $orina = "";
    private $heces = "";

    public function listarHistorias($pagina = 1)
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

        return parent::obtenerDatos($query);
    }

    public function obtenerHistoria($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }

    public function obtenerHistorias($pacientes_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE pacientes_id = '$pacientes_id'";
        return parent::obtenerDatos($query);
    }

    public function crearHistoria($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['pacientes_id'])) {
            return $_respuestas->error_400("Falta el ID del paciente.");
        } else {
            $this->pacientes_id = $datos['pacientes_id'];

            // Asignación de todos los campos
            $this->fecha = date("Y-m-d");
            $this->veterinario = $datos['veterinario'] ?? '';
            $this->comida = $datos['comida'] ?? '';
            $this->estado_reproductivo = $datos['estado_reproductivo'] ?? '';
            $this->ultimo_celo = $datos['ultimo_celo'] ?? '';
            $this->ultimo_parto = $datos['ultimo_parto'] ?? '';
            $this->sistema_reproductor = $datos['sistema_reproductor'] ?? '';
            $this->senas_particulares = $datos['senas_particulares'] ?? '';
            $this->transfusiones = $datos['transfusiones'] ?? '';
            $this->temperatura = $datos['temperatura'] ?? '';
            $this->presion_arterial = $datos['presion_arterial'] ?? '';
            $this->reflejo_tusigeno = $datos['reflejo_tusigeno'] ?? '';
            $this->reflejo_deglutorio = $datos['reflejo_deglutorio'] ?? '';
            $this->frecuencia_cardiaca = $datos['frecuencia_cardiaca'] ?? '';
            $this->sistema_cardiovascular = $datos['sistema_cardiovascular'] ?? '';
            $this->frecuencia_respiratoria = $datos['frecuencia_respiratoria'] ?? '';
            $this->sistema_respiratorio = $datos['sistema_respiratorio'] ?? '';
            $this->sistema_digestivo = $datos['sistema_digestivo'] ?? '';
            $this->sistema_genitourinario = $datos['sistema_genitourinario'] ?? '';
            $this->peso = $datos['peso'] ?? '';
            $this->motivo_consulta = $datos['motivo_consulta'] ?? '';
            $this->diagnostico = $datos['diagnostico'] ?? '';
            $this->tratamiento = $datos['tratamiento'] ?? '';
            $this->observaciones = $datos['observaciones'] ?? '';
            $this->anamnesicos = $datos['anamnesicos'] ?? '';
            $this->constantes_fisiologicas = $datos['constantes_fisiologicas'] ?? '';
            $this->actitud = $datos['actitud'] ?? '';
            $this->condicion_corporal = $datos['condicion_corporal'] ?? '';
            $this->estado_deshidratacion = $datos['estado_deshidratacion'] ?? '';
            $this->mucosa = $datos['mucosa'] ?? '';
            $this->oral = $datos['oral'] ?? '';
            $this->vulvar_prepucial = $datos['vulvar_prepucial'] ?? '';
            $this->ojos = $datos['ojos'] ?? '';
            $this->aparato_reproductor = $datos['aparato_reproductor'] ?? '';
            $this->rectal = $datos['rectal'] ?? '';
            $this->oidos = $datos['oidos'] ?? '';
            $this->nodulos = $datos['nodulos'] ?? '';
            $this->piel = $datos['piel'] ?? '';
            $this->locomocion = $datos['locomocion'] ?? '';
            $this->sistema_musculoesqueletico = $datos['sistema_musculoesqueletico'] ?? '';
            $this->sistema_nervioso = $datos['sistema_nervioso'] ?? '';
            $this->orina = $datos['orina'] ?? '';
            $this->heces = $datos['heces'] ?? '';

            $resp = $this->insertarHistoria();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array("id" => $resp);
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarHistoria()
    {
        $query = "INSERT INTO " . $this->table . " (fecha, veterinario, comida, estado_reproductivo, ultimo_celo, ultimo_parto, sistema_reproductor, senas_particulares, transfusiones, temperatura, presion_arterial, reflejo_tusigeno, reflejo_deglutorio, frecuencia_cardiaca, sistema_cardiovascular, frecuencia_respiratoria, sistema_respiratorio, sistema_digestivo, sistema_genitourinario, peso, motivo_consulta, diagnostico, tratamiento, observaciones, anamnesicos, constantes_fisiologicas, actitud, condicion_corporal, estado_deshidratacion, mucosa, oral, vulvar_prepucial, ojos, aparato_reproductor, rectal, oidos, nodulos, piel, locomocion, sistema_musculoesqueletico, sistema_nervioso, pacientes_id, orina, heces) 
        VALUES 
        ('" . $this->fecha . "', '" . $this->veterinario . "', '" . $this->comida . "', '" . $this->estado_reproductivo . "', '" . $this->ultimo_celo . "', '" . $this->ultimo_parto . "', '" . $this->sistema_reproductor . "', '" . $this->senas_particulares . "', '" . $this->transfusiones . "', '" . $this->temperatura . "', '" . $this->presion_arterial . "', '" . $this->reflejo_tusigeno . "', '" . $this->reflejo_deglutorio . "', '" . $this->frecuencia_cardiaca . "', '" . $this->sistema_cardiovascular . "', '" . $this->frecuencia_respiratoria . "', '" . $this->sistema_respiratorio . "', '" . $this->sistema_digestivo . "', '" . $this->sistema_genitourinario . "', '" . $this->peso . "', '" . $this->motivo_consulta . "', '" . $this->diagnostico . "', '" . $this->tratamiento . "', '" . $this->observaciones . "', '" . $this->anamnesicos . "', '" . $this->constantes_fisiologicas . "', '" . $this->actitud . "', '" . $this->condicion_corporal . "', '" . $this->estado_deshidratacion . "', '" . $this->mucosa . "', '" . $this->oral . "', '" . $this->vulvar_prepucial . "', '" . $this->ojos . "', '" . $this->aparato_reproductor . "', '" . $this->rectal . "', '" . $this->oidos . "', '" . $this->nodulos . "', '" . $this->piel . "', '" . $this->locomocion . "', '" . $this->sistema_musculoesqueletico . "', '" . $this->sistema_nervioso . "', '" . $this->pacientes_id . "', '" . $this->orina . "', '" . $this->heces . "')";

        return parent::nonQueryId($query);
    }

    public function actualizarHistoria($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];

            // Asignación de todos los campos basados en los datos recibidos
            $this->fecha = $datos['fecha'] ?? '';
            $this->veterinario = $datos['veterinario'] ?? '';
            $this->comida = $datos['comida'] ?? '';
            $this->estado_reproductivo = $datos['estado_reproductivo'] ?? '';
            $this->ultimo_celo = $datos['ultimo_celo'] ?? '';
            $this->ultimo_parto = $datos['ultimo_parto'] ?? '';
            $this->sistema_reproductor = $datos['sistema_reproductor'] ?? '';
            $this->senas_particulares = $datos['senas_particulares'] ?? '';
            $this->transfusiones = $datos['transfusiones'] ?? '';
            $this->temperatura = $datos['temperatura'] ?? '';
            $this->presion_arterial = $datos['presion_arterial'] ?? '';
            $this->reflejo_tusigeno = $datos['reflejo_tusigeno'] ?? '';
            $this->reflejo_deglutorio = $datos['reflejo_deglutorio'] ?? '';
            $this->frecuencia_cardiaca = $datos['frecuencia_cardiaca'] ?? '';
            $this->sistema_cardiovascular = $datos['sistema_cardiovascular'] ?? '';
            $this->frecuencia_respiratoria = $datos['frecuencia_respiratoria'] ?? '';
            $this->sistema_respiratorio = $datos['sistema_respiratorio'] ?? '';
            $this->sistema_digestivo = $datos['sistema_digestivo'] ?? '';
            $this->sistema_genitourinario = $datos['sistema_genitourinario'] ?? '';
            $this->peso = $datos['peso'] ?? '';
            $this->motivo_consulta = $datos['motivo_consulta'] ?? '';
            $this->diagnostico = $datos['diagnostico'] ?? '';
            $this->tratamiento = $datos['tratamiento'] ?? '';
            $this->observaciones = $datos['observaciones'] ?? '';
            $this->anamnesicos = $datos['anamnesicos'] ?? '';
            $this->constantes_fisiologicas = $datos['constantes_fisiologicas'] ?? '';
            $this->actitud = $datos['actitud'] ?? '';
            $this->condicion_corporal = $datos['condicion_corporal'] ?? '';
            $this->estado_deshidratacion = $datos['estado_deshidratacion'] ?? '';
            $this->mucosa = $datos['mucosa'] ?? '';
            $this->oral = $datos['oral'] ?? '';
            $this->vulvar_prepucial = $datos['vulvar_prepucial'] ?? '';
            $this->ojos = $datos['ojos'] ?? '';
            $this->aparato_reproductor = $datos['aparato_reproductor'] ?? '';
            $this->rectal = $datos['rectal'] ?? '';
            $this->oidos = $datos['oidos'] ?? '';
            $this->nodulos = $datos['nodulos'] ?? '';
            $this->piel = $datos['piel'] ?? '';
            $this->locomocion = $datos['locomocion'] ?? '';
            $this->sistema_musculoesqueletico = $datos['sistema_musculoesqueletico'] ?? '';
            $this->sistema_nervioso = $datos['sistema_nervioso'] ?? '';
            $this->orina = $datos['orina'] ?? '';
            $this->heces = $datos['heces'] ?? '';

            $resp = $this->modificarHistoria();
            if ($resp) {
                return $_respuestas->response;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarHistoria()
    {
        $query = "UPDATE " . $this->table . " SET 
        fecha = '" . $this->fecha . "', 
        veterinario = '" . $this->veterinario . "', 
        comida = '" . $this->comida . "', 
        estado_reproductivo = '" . $this->estado_reproductivo . "', 
        ultimo_celo = '" . $this->ultimo_celo . "', 
        ultimo_parto = '" . $this->ultimo_parto . "', 
        sistema_reproductor = '" . $this->sistema_reproductor . "', 
        senas_particulares = '" . $this->senas_particulares . "', 
        transfusiones = '" . $this->transfusiones . "', 
        temperatura = '" . $this->temperatura . "', 
        presion_arterial = '" . $this->presion_arterial . "', 
        reflejo_tusigeno = '" . $this->reflejo_tusigeno . "', 
        reflejo_deglutorio = '" . $this->reflejo_deglutorio . "', 
        frecuencia_cardiaca = '" . $this->frecuencia_cardiaca . "', 
        sistema_cardiovascular = '" . $this->sistema_cardiovascular . "', 
        frecuencia_respiratoria = '" . $this->frecuencia_respiratoria . "', 
        sistema_respiratorio = '" . $this->sistema_respiratorio . "', 
        sistema_digestivo = '" . $this->sistema_digestivo . "', 
        sistema_genitourinario = '" . $this->sistema_genitourinario . "', 
        peso = '" . $this->peso . "', 
        motivo_consulta = '" . $this->motivo_consulta . "', 
        diagnostico = '" . $this->diagnostico . "', 
        tratamiento = '" . $this->tratamiento . "', 
        observaciones = '" . $this->observaciones . "', 
        anamnesicos = '" . $this->anamnesicos . "', 
        constantes_fisiologicas = '" . $this->constantes_fisiologicas . "', 
        actitud = '" . $this->actitud . "', 
        condicion_corporal = '" . $this->condicion_corporal . "', 
        estado_deshidratacion = '" . $this->estado_deshidratacion . "', 
        mucosa = '" . $this->mucosa . "', 
        oral = '" . $this->oral . "', 
        vulvar_prepucial = '" . $this->vulvar_prepucial . "', 
        ojos = '" . $this->ojos . "', 
        aparato_reproductor = '" . $this->aparato_reproductor . "', 
        rectal = '" . $this->rectal . "', 
        oidos = '" . $this->oidos . "', 
        nodulos = '" . $this->nodulos . "', 
        piel = '" . $this->piel . "', 
        locomocion = '" . $this->locomocion . "', 
        sistema_musculoesqueletico = '" . $this->sistema_musculoesqueletico . "', 
        sistema_nervioso = '" . $this->sistema_nervioso . "', 
        orina = '" . $this->orina . "', 
        heces = '" . $this->heces . "' 
        WHERE id = '" . $this->id . "'";

        return parent::nonQuery($query);
    }

    public function eliminarHistoria($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400();
        } else {
            $this->id = $datos['id'];
            $resp = $this->eliminarHistoria_();
            if ($resp) {
                return $_respuestas->response;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function eliminarHistoria_()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = '" . $this->id . "'";
        return parent::nonQuery($query);
    }
}
