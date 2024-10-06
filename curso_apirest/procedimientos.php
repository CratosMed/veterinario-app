<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/procedimientos.class.php';

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
$_procedimientos = new procedimientos;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaprocedimientos = $_procedimientos->listaprocedimientos($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaprocedimientos);
        http_response_code(200);
    } elseif (isset($_GET['id'])) {
        $id = $_GET['id'];
        $datosprocedimiento = $_procedimientos->obtenerprocedimiento($id);
        header("Content-Type: application/json");
        echo json_encode($datosprocedimiento);
        http_response_code(200);
    } elseif (isset($_GET['paciente_id'])) {
        $id = $_GET['paciente_id'];
        $datosprocedimiento = $_procedimientos->obtenerprocedimientos($id);
        header("Content-Type: application/json");
        echo json_encode($datosprocedimiento);
        http_response_code(200);
    } else {
        // Si no se proporciona 'page' o 'id', devuelve un error 400
        header("Content-Type: application/json");
        $datosArray = $_respuestas->error_400();
        echo json_encode($datosArray);
        http_response_code(400);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // Enviamos los datos al manejador
    $datosArray = $_procedimientos->post($postBody);
    // Devolvemos una respuesta
    header('Content-Type: application/json');
    http_response_code(isset($datosArray["result"]["error_id"]) ? $datosArray["result"]["error_id"] : 200);
    echo json_encode($datosArray);
} elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
    // Recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // Enviamos datos al manejador
    $datosArray = $_procedimientos->put($postBody);
    // Devolvemos una respuesta
    header('Content-Type: application/json');
    http_response_code(isset($datosArray["result"]["error_id"]) ? $datosArray["result"]["error_id"] : 200);
    echo json_encode($datosArray);
} elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // Enviamos datos al manejador
    $datosArray = $_procedimientos->delete($postBody);
    // Devolvemos una respuesta
    header('Content-Type: application/json');
    http_response_code(isset($datosArray["result"]["error_id"]) ? $datosArray["result"]["error_id"] : 200);
    echo json_encode($datosArray);
} else {
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
