<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Categorías</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/administrarCategorias.css">
</head>

<body>

    <section class="category-section">
        <div class="category-management">
            <h1>Administración de Categorías</h1>
            <div class="category-actions">
                <button class="action-button"><a href="<?= BASE_URL ?>categoria/crear/">Crear Categoría</a></button>
            </div>
            <div class="category-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Categoría</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria) : ?>
                            <?php if (isset($_GET['id']) && $_GET['id'] == $categoria['id']) : ?>
                                <tr>
                                    <form action="<?= BASE_URL ?>categoria/actualizar" method="post">
                                        <td><input readonly type="text" name="data[id]" value="<?= $categoria['id'] ?>" /></td>
                                        <td><input type="text" name="data[nombre]" value="<?= $categoria['nombre'] ?>" /></td>
                                        <td>
                                            <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                                            <button type="submit" class="save-btn">Guardar Cambios</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td><?= $categoria['id'] ?></td>
                                    <td><?= $categoria['nombre'] ?></td>
                                    <td>
                                        <a class="delete-link" href="<?= BASE_URL ?>categoria/borrar/?id=<?= $categoria['id'] ?>">Eliminar</a>
                                        <a class="edit-link" href="<?= BASE_URL ?>categoria/editar/?id=<?= $categoria['id'] ?>">Modificar</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</body>