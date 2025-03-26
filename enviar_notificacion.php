<?php
// Recibir los datos JSON enviados desde la interfaz
$data = json_decode(file_get_contents('php://input'), true);

$asunto = $data['asunto'];
$mensaje = $data['mensaje'];
$token = $data['token']; // Obtener el token desde la solicitud

// Datos a enviar al servidor Node.js
$postData = [
    'asunto' => $asunto,
    'mensaje' => $mensaje,
    'token' => $token
];

// Configurar cURL para enviar la petición al servidor Node.js
$url = "http://localhost:3000/send-notification"; // Asegúrate de que el servidor está corriendo
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

$result = curl_exec($ch);

if ($result === FALSE) {
    die('Error en la solicitud: ' . curl_error($ch));
} else {
    echo json_encode(["status" => "success", "message" => "Notificación enviada"]);
}

curl_close($ch);
?>

