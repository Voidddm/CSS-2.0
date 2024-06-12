<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos de conexión a la base de datos
    $servername = "db-2024.mysql.database.azure.com";
    $db_username = "jim";
    $db_password = "2839064Void";
    $dbname = "db-ticket";

    // Crear conexión
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Recibir y sanitizar los datos del formulario
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Consulta SQL para verificar el usuario y la contraseña usando sentencias preparadas
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE cliente_id = ? AND pass = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si hay al menos un resultado, el usuario y la contraseña son correctos
        // Redirigir a home.html
        header("Location: home.html");
        exit(); // Asegura que el script se detenga aquí y no siga ejecutándose
    } else {
        // Si no hay resultados, el usuario y/o la contraseña son incorrectos
        echo "Usuario y/o contraseña incorrectos";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso denegado";
}
?>
