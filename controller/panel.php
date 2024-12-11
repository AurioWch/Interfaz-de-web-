<?php 
session_start();

//Verificar la sesión iniciada el usuario
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Cambia 'login.php' al nombre de tu archivo de login
    exit();
}

//conexion con la base de datos 
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
include '../connection/conexion.php'; // Incluye el archivo de conexión
$cnx = connection(); // iniciamos la conexion

if (!$cnx) {
    die("Error al conectar con la base de datos.");
}

try{
    // Preparar la consulta para obtener la información del usuario y su perfil
    $stmt = $cnx->prepare("
    SELECT u.nombre_usuario, p.first_name
     FROM usuario u
    INNER JOIN usuario_perfil p ON u.id_usuario = p.id_usuario
    WHERE u.nombre_usuario = :nombre_usuario
");
    // Bind del parámetro de sesión (nombre del usuario)
 $stmt ->bindParam(':nombre_usuario', $_SESSION['usuario']);
 $stmt ->execute();

   // Verificar si se encontró el usuario
if($stmt ->rowCount() >0){
    // obtener los datos del usuario
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // almacenar la informacion  adicional  del usuario 
    $nombre_usuario = $usuario['nombre_usuario'];
    $first_name = $usuario['first_name'];
}else{
     // Si no se encuentra el usuario, redirigir al login
            header("Location: login.php");
            exit();
    }
}catch(PDOException $e){
    echo "Error en la consulta: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="../css/panel.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div>
                <div class="logo">Panel de Control</div>
                <ul class="menu">
                    <li class="active"><i class="fas fa-th-large"></i> información de usuario</li>
                    <li><a href = "proyectos.php" style="color: inherit; text-decoration: none;"><i class="fas fa-folder"></i> Proyectos</a></li>
                    <li><a href = "tareas.php" style="color: inherit; text-decoration: none;"><i class="fas fa-folder"></i> Mis tareas</a></li>
                    <li><i class="fas fa-calendar-alt"></i> CALENDAR</li>
                    <li><i class="fas fa-clock"></i> TIME MANAGE</li>
                    <li><i class="fas fa-chart-bar"></i> REPORTS</li>
                    <li><i class="fas fa-cog"></i> SETTINGS</li>
                </ul>
            </div>
            <div>
    <form action="logout.php" method="POST">
        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">
            <i class="fas fa-sign-out-alt"></i> LOGOUT
        </button>
    </form>
</div>
        </div>
        <div class="main-content">
            <!-- Contenido principal aquí -->
            <h1>Bienvenido, <?= htmlspecialchars($nombre_usuario) ?>!</h1>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($first_name) ?></p>

            
        </div>
    </div>
</body>
</html>