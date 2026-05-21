<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto - Tienda Online</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/observarDetalles.css">
</head>
<body>
    
    <section class="product-details">
        <div class="product-card">
            <div class="product-image">
                <img src="<?=BASE_URL?>img/<?=$producto['imagen']?>" alt="Imagen de <?=$producto['nombre']?>">
            </div>
            <div class="product-info">
                <h2><?= $producto['nombre'] ?></h2>
                <p><?= $producto['descripcion'] ?></p>
                <div class="product-pricing">
                    <p class="price-tag">Precio: <strong><?=$producto['precio']?>€</strong></p>
                    <?php if (!isset($_SESSION['login']) || (isset($_SESSION['login']) && $_SESSION['login']->rol == 'user')): ?>
                        <?php if ($producto['stock'] > 0): ?>
                            <a class="cart-add-btn" href="<?=BASE_URL?>carrito/agregarProducto/?id=<?=$producto['id']?>">
                                Añadir al Carrito
                                <i class="ri-shopping-cart-line"></i>
                            </a>
                        <?php else: ?>
                            <button class="cart-add-btn disabled" disabled>
                                Agotado
                                <i class="ri-shopping-cart-line"></i>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</body>