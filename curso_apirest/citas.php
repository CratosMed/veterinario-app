<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/citas.class.php';

function cors()
{
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        }
        exit(0);
    }
}
cors();

$_respuestas = new respuestas;
$_citas = new citas;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Listar citas o obtener cita por ID
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaCitas = $_citas->listaCitas($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaCitas);
        http_response_code(200);
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $datosCita = $_citas->obtenerCita($id);
        header("Content-Type: application/json");
        echo json_encode($datosCita);
        http_response_code(200);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Crear nueva cita
    error_log("Método POST recibido.");
    $postBody = file_get_contents("php://input");
    $datosArray = $_citas->crearCita($postBody);

    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    // Actualizar cita usando método PUT
    error_log("Método PUT recibido.");
    $postBody = file_get_contents("php://input");
    $datosArray = $_citas->updateCita($postBody);

    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Eliminar cita
    $postBody = file_get_contents("php://input");
    $datosArray = $_citas->deleteCita($postBody);

    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else {
    // Método no permitido
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
