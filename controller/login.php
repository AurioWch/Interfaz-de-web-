<?php
session_start(); // Iniciar sesión

include '../connection/conexion.php'; // Incluir el archivo de conexión

$error = ""; // Variable para almacenar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password']; // Asegúrate de que este sea el nombre correcto

    $cnx = connection(); // Establecer conexión

    if ($cnx) {
        // Preparar la consulta
        $stmt = $cnx->prepare("SELECT * FROM usuario WHERE nombre_usuario = :nombre_usuario");
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->execute();

        // Verificar si el usuario existe
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verificar la contraseña
            if ($usuario['password'] === $password) { // Aquí debes usar un método de hashing
                $_SESSION['usuario'] = $usuario['nombre_usuario']; // Guardar el usuario en la sesión
                $_SESSION['email'] = $usuario['email']; // Guardar el email en la sesión
                $_SESSION['id_usuario'] = $usuario['id_usuario']; // Guardar el ID del usuario en la sesión
                header("Location: panel.php"); // Redirigir a panel.php
                exit(); // Asegurarse de que no se ejecute más código
            } else {
                $error = "Usuario o contraseña incorrectos."; // Mensaje de error
            } 
        } else {
            $error = "Usuario o contraseña incorrectos."; // Mensaje de error
        }
    } else {
        $error = "Error en la conexión a la base de datos."; // Mensaje de error
    }
}
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/styles_login.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>¡Bienvenido!</h1>
        <p>Inicia sesión para continuar</p>

        <form id="loginForm" method="POST" action="">
            <input type="text" id="username" name="nombre_usuario" placeholder="Usuario" required autocomplete="username">
            <input type="password" id="password" name="password" placeholder="Contraseña" required autocomplete="current-password">
            <button type="submit" id="submitButton">Iniciar Sesión</button>
        </form>
        
        <div class="register">
            <p>No eres miembro? <a href="#">Regístrate ahora</a></p>
        </div>
    </div>

    <!-- Modal para mostrar errores -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="errorMessage"><?= htmlspecialchars($error) ?></p>
        </div>
    </div>

    <script>
        // Mostrar el modal si hay un error
        <?php if (!empty($error)): ?>
            document.getElementById('errorModal').style.display = 'block';
        <?php endif; ?>

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('errorModal').style.display = 'none';
        }

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            var modal = document.getElementById('errorModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>