<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/propietarios.class.php';

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
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept, id");
        }

        exit(0);
    }
}
cors();

$_respuestas = new respuestas;
$_propietarios = new propietarios;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaPropietarios = $_propietarios->listaPropietarios($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPropietarios);
        http_response_code(200);
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $datosPropietarios = $_propietarios->obtenerPropietarios($id);
        header("Content-Type: application/json");
        echo json_encode($datosPropietarios);
        http_response_code(200);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $postBody = file_get_contents("php://input");
    $datosArray = $_propietarios->post($postBody);
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    $postBody = file_get_contents("php://input");
    $datosArray = $_propietarios->put($postBody);
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Obtenemos el cuerpo de la petición (que contiene el ID)
    $postBody = file_get_contents("php://input");

    // Eliminamos la dependencia del token, sólo trabajamos con el ID
    $datosArray = $_propietarios->delete($postBody);

    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        // Si el error_id no es un código HTTP válido, mapéalo aquí
        $responseCode = ($datosArray["result"]["error_id"] == "foreign_key") ? 409 : $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }

    echo json_encode($datosArray);
} else {
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
