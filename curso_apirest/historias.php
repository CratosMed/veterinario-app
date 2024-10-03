<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/historias.class.php';

function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400'); // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
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
$_historias = new historias;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["page"])) {
        // Obtener lista de historias paginadas
        $pagina = $_GET["page"];
        $listahistorias = $_historias->listarHistorias($pagina);
        header("Content-Type: application/json");
        echo json_encode($listahistorias);
        http_response_code(200);
    } else if (isset($_GET['id'])) {
        // Obtener historia específica por id
        $id = $_GET['id'];
        $datoshistoria = $_historias->obtenerHistoria($id);
        header("Content-Type: application/json");
        echo json_encode($datoshistoria);
        http_response_code(200);
    } else if (isset($_GET['paciente_id'])) {
        // Obtener historia específica por id
        $id = $_GET['paciente_id'];
        $datoshistoria = $_historias->obtenerHistorias($id);
        header("Content-Type: application/json");
        echo json_encode($datoshistoria);
        http_response_code(200);
    } else {
        // Error si no se proporcionan parámetros adecuados
        $datosArray = $_respuestas->error_400();
        header("Content-Type: application/json");
        echo json_encode($datosArray);
        http_response_code(400);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Recibir datos enviados
    $postBody = file_get_contents("php://input");
    // Enviar los datos al manejador
    $datosArray = $_historias->crearHistoria($postBody);
    // Devolver una respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(201); // Created
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    // Recibir datos enviados
    $postBody = file_get_contents("php://input");
    // Enviar datos al manejador
    $datosArray = $_historias->actualizarHistoria($postBody);
    // Devolver una respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Recibir datos enviados
    $postBody = file_get_contents("php://input");
    // Extraer el ID para eliminar
    $data = json_decode($postBody, true);
    if (isset($data['id'])) {
        // Enviar datos al manejador para eliminación
        $datosArray = $_historias->eliminarHistoria($data['id']);
        // Devolver una respuesta
        header('Content-Type: application/json');
        if (isset($datosArray["result"]["error_id"])) {
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        } else {
            http_response_code(200);
        }
        echo json_encode($datosArray);
    } else {
        // Error si no se proporciona el ID
        $datosArray = $_respuestas->error_400("Falta el ID para eliminar la historia.");
        header('Content-Type: application/json');
        echo json_encode($datosArray);
        http_response_code(400);
    }
} else {
    // Método no permitido
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}