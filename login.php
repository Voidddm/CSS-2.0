<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $cliente_id = $_POST['username'];
    $password = $_POST['password'];

    // Llamar al script de Python para verificar el inicio de sesión
    $resultado = exec("python verificar_inicio_sesion.py " . escapeshellarg($cliente_id) . " " . escapeshellarg($password));

    if ($resultado == "True") {
        header("Location: home.html"); // Redirigir a la página home.html
        exit(); // Terminar el script para evitar que se ejecute más código
    } else {
        echo "Inicio de sesión fallido";
    }
} else {
    // Si el método no es POST, mostrar un error
    echo "Método no permitido";
    http_response_code(405); // Establecer el código de respuesta HTTP a 405
}
?>
