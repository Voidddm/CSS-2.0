<?php
// Recibir los datos del formulario
$cliente_id = $_POST['username'];
$password = $_POST['password'];

// Llamar al script de Python para verificar el inicio de sesión
$resultado = exec("python verificar_inicio_sesion.py " . escapeshellarg($cliente_id) . " " . escapeshellarg($password));

if ($resultado == "True") {
    echo "Inicio de sesión exitoso";
} else {
    echo "Inicio de sesión fallido";
}
?>
