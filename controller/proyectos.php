


<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="../css/proyectos.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div>
                <div class="logo">Panel de Control</div>
                <ul class="menu">
                <li><a href = "panel.php" style="color: inherit; text-decoration: none;"><i class="fas fa-folder"></i> información de usuario</a></li>
                <li class="active"><i class="fas fa-th-large"></i> Proyecto</li>
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
            
        </div>
    </div>
</body>
</html>