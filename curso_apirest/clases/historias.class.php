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
    private $temperatura = "";
    private $presion_arterial = "";
    private $frecuencia_cardiaca = "";
    private $frecuencia_respiratoria = "";
    private $peso = "";
    private $motivo_consulta = "";
    private $diagnostico = "";
    private $tratamiento = "";
    private $observaciones = "";
    private $anamnecicos = "";
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
    public function obtenerHistorias($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE pacientes_id = '$id'";
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

            // Asignación de valores
            $this->fecha = date("Y-m-d"); // se puede ajustar si es necesario
            $this->veterinario = $datos['veterinario'] ?? '';
            $this->comida = $datos['comida'] ?? '';
            $this->estado_reproductivo = $datos['estado_reproductivo'] ?? '';
            $this->temperatura = $datos['temperatura'] ?? '';
            $this->presion_arterial = $datos['presion_arterial'] ?? '';
            $this->frecuencia_cardiaca = $datos['frecuencia_cardiaca'] ?? '';
            $this->frecuencia_respiratoria = $datos['frecuencia_respiratoria'] ?? '';
            $this->peso = $datos['peso'] ?? '';
            $this->motivo_consulta = $datos['motivo_consulta'] ?? '';
            $this->diagnostico = $datos['diagnostico'] ?? '';
            $this->tratamiento = $datos['tratamiento'] ?? '';
            $this->observaciones = $datos['observaciones'] ?? '';
            $this->anamnecicos = $datos['anamnecicos'] ?? '';
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
        $query = "INSERT INTO " . $this->table . " (fecha, veterinario, comida, estado_reproductivo, temperatura, presion_arterial, frecuencia_cardiaca, frecuencia_respiratoria,
        peso, motivo_consulta, diagnostico, tratamiento, observaciones, anamnecicos, constantes_fisiologicas, actitud, condicion_corporal, estado_deshidratacion, mucosa,
        oral, vulvar_prepucial, ojos, aparato_reproductor, rectal, oidos, nodulos, piel, locomocion,sistema_musculoesqueletico, sistema_nervioso pacientes_id) 
        VALUES 
        ('" . $this->fecha . "', '" . $this->veterinario . "', '" . $this->comida . "', '" . $this->estado_reproductivo . "', '" . $this->temperatura . "', 
        '" . $this->presion_arterial . "', '" . $this->frecuencia_cardiaca . "', '" . $this->frecuencia_respiratoria . "', 
        '" . $this->peso . "', '" . $this->motivo_consulta . "', '" . $this->diagnostico . "', '" . $this->tratamiento . "', 
        '" . $this->observaciones . "', '" . $this->anamnecicos . "', '" . $this->constantes_fisiologicas . "', '" . $this->actitud . "', 
        '" . $this->condicion_corporal . "', '" . $this->estado_deshidratacion . "', '" . $this->mucosa . "', 
        '" . $this->oral . "', '" . $this->vulvar_prepucial . "', '" . $this->ojos . "', '" . $this->aparato_reproductor . "', 
        '" . $this->rectal . "', '" . $this->oidos . "', '" . $this->nodulos . "', '" . $this->piel . "', '" . $this->locomocion . "', '" . $this->sistema_musculoesqueletico . "', '" . $this->sistema_nervioso . "', '" . $this->pacientes_id . "')";

        return parent::nonQueryId($query);
    }

    public function actualizarHistoria($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['id'])) {
            return $_respuestas->error_400("Falta el ID de la historia.");
        } else {
            $this->id = $datos['id'];

            // Asignación de valores
            $this->fecha = $datos['fecha'] ?? $this->fecha; // Se puede ajustar la fecha
            $this->veterinario = $datos['veterinario'] ?? $this->veterinario;
            $this->comida = $datos['comida'] ?? $this->comida;
            $this->estado_reproductivo = $datos['estado_reproductivo'] ?? $this->estado_reproductivo;
            $this->temperatura = $datos['temperatura'] ?? $this->temperatura;
            $this->presion_arterial = $datos['presion_arterial'] ?? $this->presion_arterial;
            $this->frecuencia_cardiaca = $datos['frecuencia_cardiaca'] ?? $this->frecuencia_cardiaca;
            $this->frecuencia_respiratoria = $datos['frecuencia_respiratoria'] ?? $this->frecuencia_respiratoria;
            $this->peso = $datos['peso'] ?? $this->peso;
            $this->motivo_consulta = $datos['motivo_consulta'] ?? $this->motivo_consulta;
            $this->diagnostico = $datos['diagnostico'] ?? $this->diagnostico;
            $this->tratamiento = $datos['tratamiento'] ?? $this->tratamiento;
            $this->observaciones = $datos['observaciones'] ?? $this->observaciones;
            $this->anamnecicos = $datos['anamnecicos'] ?? $this->anamnecicos;
            $this->constantes_fisiologicas = $datos['constantes_fisiologicas'] ?? $this->constantes_fisiologicas;
            $this->actitud = $datos['actitud'] ?? $this->actitud;
            $this->condicion_corporal = $datos['condicion_corporal'] ?? $this->condicion_corporal;
            $this->estado_deshidratacion = $datos['estado_deshidratacion'] ?? $this->estado_deshidratacion;
            $this->mucosa = $datos['mucosa'] ?? $this->mucosa;
            $this->oral = $datos['oral'] ?? $this->oral;
            $this->vulvar_prepucial = $datos['vulvar_prepucial'] ?? $this->vulvar_prepucial;
            $this->ojos = $datos['ojos'] ?? $this->ojos;
            $this->aparato_reproductor = $datos['aparato_reproductor'] ?? $this->aparato_reproductor;
            $this->rectal = $datos['rectal'] ?? $this->rectal;
            $this->oidos = $datos['oidos'] ?? $this->oidos;
            $this->nodulos = $datos['nodulos'] ?? $this->nodulos;
            $this->piel = $datos['piel'] ?? $this->piel;
            $this->locomocion = $datos['locomocion'] ?? $this->locomocion;
            $this->sistema_musculoesqueletico = $datos['sistema_musculoesqueletico'] ?? $this->sistema_musculoesqueletico;
            $this->sistema_nervioso = $datos['sistema_nervioso'] ?? $this->sistema_nervioso;
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
            temperatura = '" . $this->temperatura . "', 
            presion_arterial = '" . $this->presion_arterial . "', 
            frecuencia_cardiaca = '" . $this->frecuencia_cardiaca . "', 
            frecuencia_respiratoria = '" . $this->frecuencia_respiratoria . "', 
            peso = '" . $this->peso . "', 
            motivo_consulta = '" . $this->motivo_consulta . "', 
            diagnostico = '" . $this->diagnostico . "', 
            tratamiento = '" . $this->tratamiento . "', 
            observaciones = '" . $this->observaciones . "', 
            anamnecicos = '" . $this->anamnecicos . "', 
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
            locomocion = '" . $this->locomocion . "' 
            sistema_musculoesqueletico = '" . $this->sistema_musculoesqueletico . "'
            sistema_nervioso = '" . $this->sistema_nervioso . "' 
            WHERE id = '" . $this->id . "'";

        return parent::nonQuery($query);
    }

    public function eliminarHistoria($id)
    {
        $_respuestas = new respuestas;
        $this->id = $id;

        $query = "DELETE FROM " . $this->table . " WHERE id = '$this->id'";
        $resp = parent::nonQuery($query);

        if ($resp) {
            return $_respuestas->response;
        } else {
            return $_respuestas->error_500();
        }
    }
}
