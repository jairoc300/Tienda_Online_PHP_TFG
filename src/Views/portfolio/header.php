<?php
use Controllers\CategoriaController;  

$categoriaObj = new CategoriaController();
$categorias = $categoriaObj->obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online - La mejor tienda en línea</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
</head>
<body>

<header>
    <nav>
        <div class="top-nav">
            <div class="nav-wrapper">
                <a href="<?= BASE_URL ?>" class="brand-logo">
                    <i class="ri-shopping-cart-2-fill"></i> Tienda Online
                </a>

                <ul class="navigation-items" id="category-menu">
                    <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="ri-list-check-2"></i> Categorías
                        </a>
                        <div class="dropdown-menu">
                            <?php foreach ($categorias as $categoria): ?>
                                <a href="<?= BASE_URL ?>categoria/ver/?id=<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                </ul>

                <div class="user-options">
                    <?php if (!isset($_SESSION['login']) || $_SESSION['login'] == 'failed' || !is_object($_SESSION['login'])): ?>
                        <a href="<?= BASE_URL ?>usuario/login/">
                            <i class="ri-login-box-line"></i> Iniciar Sesión
                        </a>
                        <a href="<?= BASE_URL ?>usuario/registro/">
                            <i class="ri-user-add-line"></i> Registrarse
                        </a>
                    <?php elseif (is_object($_SESSION['login'])): ?>
                        <span style="color: #ccc;">
                            <i class="ri-user-line"></i> <?= $_SESSION['login']->nombre ?> <?= $_SESSION['login']->apellidos ?>
                        </span>
                        <?php if ($_SESSION['login']->rol == 'user'): ?>
                            <a href="<?= BASE_URL ?>pedido/misPedidos/">
                                <i class="ri-file-list-line"></i> Mis Pedidos
                            </a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>pedido/todosLosPedidos/">
                                <i class="ri-file-list-line"></i> Gestión Pedidos
                            </a>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>usuario/logout/">
                            <i class="ri-logout-box-line"></i> Cerrar Sesión
                        </a>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION['login']) || (isset($_SESSION['login']) && is_object($_SESSION['login']) && $_SESSION['login']->rol == 'user')): ?>
                        <a href="<?= BASE_URL ?>carrito/obtenerCarrito/" style="position: relative;">
                            <i class="ri-shopping-cart-2-fill"></i>
                            <span style="position: absolute; top: -8px; right: -8px; background: var(--secondary-color); color: black; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold;">
                                <?= isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0 ?>
                            </span>
                        </a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['login']) && is_object($_SESSION['login']) && $_SESSION['login']->rol == 'admin'): ?>
                        <span style="border-left: 1px solid rgba(255, 255, 255, 0.2); padding-left: 15px; margin-left: 15px;"></span>
                        <div class="dropdown admin-dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle">
                                <i class="ri-admin-line"></i> Admin
                            </a>
                            <div class="dropdown-menu">
                                <a href="<?= BASE_URL ?>admin/estadisticas/">
                                    <i class="ri-bar-chart-line"></i> Estadísticas
                                </a>
                                <a href="<?= BASE_URL ?>usuario/verTodos/">
                                    <i class="ri-admin-line"></i> Usuarios
                                </a>
                                <a href="<?= BASE_URL ?>categoria/gestionarCategorias/">
                                    <i class="ri-folder-line"></i> Categorías
                                </a>
                                <a href="<?= BASE_URL ?>producto/gestionarProductos/">
                                    <i class="ri-product-hunt-line"></i> Productos
                                </a>
                                <a href="<?= BASE_URL ?>pedido/todosLosPedidos/">
                                    <i class="ri-stack-line"></i> Pedidos
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="body-wrapper">
    <main>

<script>
    // Manejo de los dropdowns
    document.addEventListener('DOMContentLoaded', function() {
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');

            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Cerrar otros dropdowns
                    dropdowns.forEach(otherDropdown => {
                        if (otherDropdown !== dropdown) {
                            otherDropdown.classList.remove('active');
                        }
                    });
                    
                    dropdown.classList.toggle('active');
                });

                // Cerrar el dropdown cuando se selecciona una opción
                if (dropdownMenu) {
                    const links = dropdownMenu.querySelectorAll('a');
                    links.forEach(link => {
                        link.addEventListener('click', function() {
                            dropdown.classList.remove('active');
                        });
                    });
                }
            }
        });

        // Cerrar los dropdowns cuando se hace clic fuera
        document.addEventListener('click', function(e) {
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });
    });
</script>
