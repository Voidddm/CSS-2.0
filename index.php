<!DOCTYPE html>
<html lang="es">
<head>
  <title>Sistema Soporte de Tickets</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Sistema de Soporte de Tickets :)</h1>
    <nav>
      <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="formulario.php">Contactanos</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="container">
      <section id="login-form">
        <h2>Iniciar Sesión</h2>
        <form action="validar.php" method="post">
          <label for="username">Usuario:</label>
          <input type="text" id="username" name="username" required>
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required>
          <button type="submit">Iniciar Sesión</button>
        </form>
        <p style="text-align: center; margin-top: 10px;">¿No tienes cuenta? <a href="registro.php" style="color: blue;">Regístrate</a></p>
        <?php
        session_start();

        // Check if the request method is POST
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // If the request method is not POST, display an error message or redirect
            header("HTTP/1.1 405 Method Not Allowed");
            echo "405 Method Not Allowed: This page must be accessed via a POST request.";
            exit();
        }

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
                header("Location: home.php");
                exit();
            } else {
                echo "Usuario y/o contraseña incorrectos";
            }
        } else {
            echo "Usuario y/o contraseña incorrectos";
        }

        $stmt->close();
        $conn->close();
        ?>
      </section>
    </div>
  </main>
</body>
</html>