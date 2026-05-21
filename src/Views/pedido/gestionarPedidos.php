<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/administrarPedidos.css">
</head>

<body>
    <?php if ($_SESSION['login']->rol == 'admin' && isset($_SESSION['login'])) : ?>
        <section class="orders-section">
            <div class="orders-div">
                <h1>Gestión de Pedidos</h1>

                <?php if (!empty($errores)) : ?>
                    <div class="error-messages">
                        <?php foreach ($errores as $error) : ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($pedidos) && count($pedidos) > 0) : ?>
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Coste</th>
                                <?php if (!isset($_GET['id'])) : ?>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                <?php endif; ?>
                                <th>ID Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido) : ?>
                                <?php if ((isset($_GET['id'])) && ($_GET['id'] == $pedido['id'])) : ?>
                                    <tr>
                                        <form action="<?= BASE_URL ?>pedido/actualizar" method="post">
                                            <td><input type="text" name="data[id]" value="<?= htmlspecialchars($pedido['id']) ?>" readonly></td>
                                            <td><input type="text" name="data[coste]" value="<?= htmlspecialchars($pedido['coste']) ?>"></td>

                                            <td><input type="text" name="data[usuario_id]" value="<?= htmlspecialchars($pedido['usuario_id']) ?>" readonly></td>
                                            <td><button type="submit" class="update-btn">Guardar</button></td>
                                        </form>
                                    </tr>
                                <?php else : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pedido['id']) ?></td>
                                        <td><?= htmlspecialchars($pedido['coste']) ?>€</td>
                                        <td><?= htmlspecialchars($pedido['fecha']) ?></td>
                                        <td><?= htmlspecialchars($pedido['hora']) ?></td>
                                        <td><?= htmlspecialchars($pedido['estado']) ?></td>
                                        <td><?= htmlspecialchars($pedido['usuario_id']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>pedido/confirmarPedido/?id=<?= $pedido['id']?>" class="confirm-link">
                                                <i class="ri-check-line"></i>
                                            </a> <a href="<?= BASE_URL ?>pedido/editar/?id=<?= $pedido['id'] ?>" class="edit-link"><i class="ri-edit-line"></i></a>
                                            <a href="<?= BASE_URL ?>pedido/eliminar/?id=<?= $pedido['id'] ?>" class="delete-link"><i class="ri-delete-bin-2-line"></i></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p class="no-orders">No tienes pedidos</p>
                <?php endif; ?>
            </div>
        </section>
    <?php else : ?>
        <h2 class="access-denied">No tienes permiso para entrar en esta página</h2>
    <?php endif; ?>
</body>