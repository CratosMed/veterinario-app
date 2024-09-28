<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/pacientes.class.php';

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
$_pacientes = new pacientes;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaPacientes = $_pacientes->listaPacientes($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPacientes);
        http_response_code(200);
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $datosPaciente = $_pacientes->obtenerPaciente($id);
        header("Content-Type: application/json");
        echo json_encode($datosPaciente);
        http_response_code(200);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Verificar si se han subido archivos
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $postBody = isset($_POST['datos']) ? $_POST['datos'] : null; // Asegúrate de que tus datos se envían en 'datos'
        $datosArray = $_pacientes->post($postBody, $_FILES); // Enviar los datos y archivos a la clase
    } else {
        // Leer el cuerpo de la solicitud, en caso de no haber archivos
        $postBody = file_get_contents("php://input");
        $datosArray = $_pacientes->post($postBody, null);
    }

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
    // Verificar si se han subido archivos
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $postBody = isset($_POST['datos']) ? $_POST['datos'] : null; // Asegúrate de que tus datos se envían en 'datos'
        $datosArray = $_pacientes->put($postBody, $_FILES); // Enviar los datos y archivos a la clase
    } else {
        $postBody = file_get_contents("php://input");
        $datosArray = $_pacientes->put($postBody, null);
    }

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
    $postBody = file_get_contents("php://input");
    $datosArray = $_pacientes->delete($postBody);

    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
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
