<?php
include 'header.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
include 'functions.php';
$marcas = load_marcas();
$user = $_SESSION['user'];
?>

<div class="container">
    <div class="row mt-3">
        <div class="welcome-container">
            <div id="welcome-div">
                <h1>Bienvenido, <?php echo htmlspecialchars($user['name']) . ' ' . htmlspecialchars($user['lastname']); ?>!</h1>
                <p>Has iniciado sesión con el correo: <?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <img src="assets/images/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="avatar">
        </div>
    </div>
    <div class="col-md-4 offset-md-4">
        <a href="view_marca.php" class="btn btn-dark mb-3">Gestionar Marcas</a>
        <a href="crud_productos.php" class="btn btn-primary mb-3">Gestionar Productos</a>
        <a href="crud.php" class="btn btn-secondary btn-gestionar-usuarios mb-3">Gestionar Usuarios</a>
        <a href="logout.php" class="btn btn-danger mb-3">Cerrar Sesión</a>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="description">
                        <strong>Bienvenido a nuestro Sistema de Gestión de Inventario de Electrodomésticos</strong><br>
                        Este sistema está diseñado para ayudar a los administradores a gestionar de manera eficiente un inventario de productos electrónicos. Aquí podrás:
                        <ul>
                            <li><strong>Gestionar Usuarios:</strong> Registrar, actualizar y eliminar usuarios que tienen acceso al sistema, con opciones para asignar avatares personalizados.</li>
                            <li><strong>Gestionar Marcas:</strong> Añadir, editar y eliminar marcas de electrodomésticos, manteniendo un control detallado de todas las marcas disponibles.</li>
                            <li><strong>Gestionar Productos:</strong> Administrar el inventario de productos, añadiendo nuevos artículos, actualizando información existente y eliminando productos cuando sea necesario. Cada producto incluye detalles como color, modelo, componentes, precio y la marca asociada, además de una imagen del producto.</li>
                        </ul>
                        Nuestro sistema también ofrece funcionalidades avanzadas como la exportación de datos a PDF y Excel, y la capacidad de imprimir informes directamente desde la plataforma.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>
