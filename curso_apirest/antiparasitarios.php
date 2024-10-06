<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/antiparasitarios.class.php';

function cors()
{
    // Permitir acceso desde cualquier origen
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache por 1 día
    }

    // Manejo de las solicitudes OPTIONS
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        }
        exit(0);
    }
}
cors();

$_respuestas = new respuestas;
$_antiparasitarios = new antiparasitarios;

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if (isset($_GET["page"])) {
        // Obtención de lista de antiparasitarios con paginación
        $pagina = $_GET["page"];
        $listaantiparasitarios = $_antiparasitarios->listaantiparasitarios($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaantiparasitarios);
        http_response_code(200);
    } else if (isset($_GET['id'])) {
        // Obtención de un antiparasitario por su ID
        $id = $_GET['id'];
        $datosantiparasitario = $_antiparasitarios->obtenerantiparasitario($id);
        header("Content-Type: application/json");
        echo json_encode($datosantiparasitario);
        http_response_code(200);
    } else if (isset($_GET['paciente_id'])) {
        // Obtención de un antiparasitario por su ID
        $id = $_GET['paciente_id'];
        $datosantiparasitario = $_antiparasitarios->obtenerantiparasitarios($id);
        header("Content-Type: application/json");
        echo json_encode($datosantiparasitario);
        http_response_code(200);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Recibir datos en POST
    $postBody = file_get_contents("php://input");
    // Enviar los datos al manejador de la clase
    $datosArray = $_antiparasitarios->post($postBody);
    // Devolver respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    // Recibir datos en PUT
    $postBody = file_get_contents("php://input");
    // Enviar los datos al manejador de la clase
    $datosArray = $_antiparasitarios->put($postBody);
    // Devolver respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Recibir datos enviados en DELETE
    $postBody = file_get_contents("php://input");
    // Enviar los datos al manejador de la clase
    $datosArray = $_antiparasitarios->delete($postBody);
    // Devolver respuesta
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
