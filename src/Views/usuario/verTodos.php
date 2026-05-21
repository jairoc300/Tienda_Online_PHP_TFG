<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios - Tienda Online</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/administrarUsuarios.css">
</head>
<body>

    <section class="users-section">
        <div class="users-main">
            <h1>Listado de Usuarios</h1>
            <div class="user-actions">
                <button class="new-user-btn"><a href="<?=BASE_URL?>usuario/registro/">Agregar Usuario</a></button>
            </div>
            <?php if (isset($_SESSION['login']) && $_SESSION['login']->rol == 'admin') : ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <?php if ((isset($_GET['id'])) && ($_GET['id'] == $usuario['id'])): ?>
                                <tr>
                                    <form action="<?=BASE_URL?>usuario/actualizar" method="post">
                                        <td><input type="text" readonly name="data[id]" value="<?=$usuario['id']?>"></td>
                                        <td><input type="text" name="data[nombre]" value="<?=$usuario['nombre']?>"></td>
                                        <td><input type="text" name="data[apellidos]" value="<?=$usuario['apellidos']?>"></td>
                                        <td><input type="text" name="data[email]" value="<?=$usuario['email']?>"></td>
                                        <td>
                                            <select name="data[rol]">
                                                <option value="admin" <?=($usuario['rol'] == 'admin') ? 'selected' : ''?>>Administrador</option>
                                                <option value="user" <?=($usuario['rol'] == 'user') ? 'selected' : ''?>>Usuario</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id" value="<?=$usuario['id']?>">
                                            <button type="submit" class="save-changes-btn">Guardar</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['id']) ?></td>
                                    <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                    <td><?= htmlspecialchars($usuario['apellidos']) ?></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td><?= htmlspecialchars($usuario['rol']) ?></td>
                                    <td>
                                        <a href="<?=BASE_URL?>usuario/editar/?id=<?=$usuario['id']?>" class="edit-link"><i class="ri-edit-line"></i></a>
                                        <a href="<?=BASE_URL?>usuario/eliminar/?id=<?=$usuario['id']?>" class="delete-link"><i class="ri-delete-bin-2-line"></i></a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="permission-denied">No tienes permisos para ver esta página</p>
            <?php endif; ?>
        </div>
    </section>

</body>