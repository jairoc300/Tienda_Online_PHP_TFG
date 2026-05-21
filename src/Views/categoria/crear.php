
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/crearCategoria.css">
</head>
<body>

<?php use Utils\Utils;?>

<section class="create-category-section">
    <div class="create-category-container">
        <div class="form-header">
            <i class="ri-folder-add-line"></i>
            <h1>Crear Nueva Categoría</h1>
            <p>Añade una nueva categoría a tu tienda</p>
        </div>

        <?php if(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'complete'): ?>
            <div class="notification success">
                <i class="ri-check-circle-line"></i>
                <strong>¡Éxito!</strong> Categoría creada correctamente
            </div>
        <?php elseif(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'failed'):?>
            <div class="notification error">
                <i class="ri-error-warning-line"></i>
                <strong>Error</strong> No se ha podido crear la categoría
            </div>
        <?php endif;?>
        <?php Utils::removeSession('categoria');?>

        <form class="category-form" action="<?=BASE_URL?>categoria/crear/" method="POST">
            <div class="form-group">
                <label for="nombre">
                    <i class="ri-file-text-line"></i> Nombre de la Categoría
                </label>
                <input 
                    type="text" 
                    name="nombre" 
                    id="nombre" 
                    placeholder="Ej: Electrónica, Ropa, Libros..."
                    required
                    minlength="2"
                    maxlength="100"
                >
                <small>Ingresa un nombre descriptivo para la categoría</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-create">
                    <i class="ri-add-circle-line"></i> Crear Categoría
                </button>
                <a href="<?=BASE_URL?>categoria/gestionarCategorias/" class="btn-cancel">
                    <i class="ri-close-line"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
