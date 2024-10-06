<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/examenes.class.php';

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
$_examenes = new examenes;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaExamenes = $_examenes->listaExamenes($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaExamenes);
        http_response_code(200);
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $datosExamen = $_examenes->obtenerExamen($id);
        header("Content-Type: application/json");
        echo json_encode($datosExamen);
        http_response_code(200);
    } else if (isset($_GET['paciente_id'])) {
        $id = $_GET['paciente_id'];
        $datosExamen = $_examenes->obtenerExamenes($id);
        header("Content-Type: application/json");
        echo json_encode($datosExamen);
        http_response_code(200);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    error_log("Método POST recibido.");

    // Verificar si es una creación o edición según la existencia del campo 'id'
    if (isset($_POST['id'])) {
        error_log("Proceso de edición iniciado con ID: " . $_POST['id']);

        // Proceso de edición (equivalente al PUT)
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            error_log("Se subió una imagen.");
            $datosArray = $_examenes->updateExamen($_POST['id'], $_POST, $_FILES);
        } else {
            error_log("No se subió ninguna imagen.");
            $datosArray = $_examenes->updateExamen($_POST['id'], $_POST, null);
        }
    } else {
        error_log("Proceso de creación iniciado.");

        // Proceso de creación (nuevo examen)
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            error_log("Se subió una imagen durante la creación.");
            $datosArray = $_examenes->post($_POST, $_FILES);
        } else {
            error_log("No se subió ninguna imagen durante la creación.");
            $datosArray = $_examenes->post($_POST, null);
        }
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
    $datosArray = $_examenes->delete($postBody);

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
