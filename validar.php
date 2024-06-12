<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "db-2024.mysql.database.azure.com";
    $db_username = "jim";
    $db_password = "2839064Void";
    $dbname = "db-ticket";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT pass FROM clientes WHERE cliente_id = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            $_SESSION['username'] = $username;
            header("Location: home.html");
            exit();
        } else {
            echo "Usuario y/o contraseña incorrectos";
        }
    } else {
        echo "Usuario y/o contraseña incorrectos";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso denegado";
}
?>

