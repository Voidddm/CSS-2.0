<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar datos de entrada
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Datos de conexión a la base de datos
        $servername = "db-2024.mysql.database.azure.com";
        $db_username = "jim";
        $db_password = "2839064Void";
        $dbname = "db-ticket";

        // Rutas a los archivos de certificados SSL
        $ssl_ca = '/path/to/BaltimoreCyberTrustRoot.crt.pem'; // Reemplazar con la ruta correcta

        // Crear conexión con parámetros SSL
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Configurar opciones SSL
        $conn->ssl_set(NULL, NULL, $ssl_ca, NULL, NULL);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare("SELECT password FROM clientes WHERE cliente_id = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verificar la contraseña
            if (password_verify($password, $hashed_password)) {
                // Redirigir a la página home.html
                header("Location: home.html");
                exit();
            } else {
                echo "Inicio de sesión fallido: Contraseña incorrecta";
            }
        } else {
            echo "Inicio de sesión fallido: Usuario no encontrado";
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();
    } else {
        echo "Faltan datos del formulario";
    }
} else {
    // Si el método no es POST, mostrar un error
    echo "Método no permitido";
    http_response_code(405);
}
?>
