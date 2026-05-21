<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos - Tienda Online</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/administrarProductos.css">
</head>
<body>
    <section class="product-section">
        <div class="product-management">
            <h1>Administración de Productos</h1>
            <div class="product-actions">
                <button class="add-product-btn"><a href="<?=BASE_URL?>producto/crear/">Añadir Producto</a></button>
            </div>
            <div class="product-table-container">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($productos as $producto): ?>
                            <tr>
                                <td><?= htmlspecialchars($producto['nombre']) ?></td>
                                <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                                <td><?= htmlspecialchars($producto['precio']) ?></td>
                                <td><?= htmlspecialchars($producto['stock']) ?></td>
                                <td>
                                    <a class="delete-product-link" href="<?=BASE_URL?>producto/borrar/?id=<?=$producto['id']?>">Eliminar</a><br><br>
                                    <a class="edit-product-link" href="<?=BASE_URL?>producto/editar/?id=<?=$producto['id']?>">Modificar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>