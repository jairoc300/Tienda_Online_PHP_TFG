<?php
use Controllers\CategoriaController;
use Controllers\ProductoController;
use Models\Producto;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoría</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/observarCategoria.css">
    <style>
        .filter-section {
            background-color: #f5f5f5;
            padding: 90px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: flex-end;
        }

        .filter-form input,
        .filter-form button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-form input {
            border-color: #ccc;
        }

        .filter-form button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }

        .clear-filters {
            background-color: #6c757d;
        }

        .clear-filters:hover {
            background-color: #5a6268;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination .disabled {
            color: #ccc;
            cursor: not-allowed;
        }

        .info-resultado {
            text-align: center;
            margin: 20px 0;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Sección de filtros -->
    <div class="filter-section">
        <h2>Filtrar Productos</h2>
        <form method="GET" class="filter-form">
            <input type="hidden" name="id" value="<?=htmlspecialchars($categoriaId ?? '', ENT_QUOTES, 'UTF-8')?>">
            
            <div>
                <label for="busqueda">Buscar por nombre:</label>
                <input type="text" id="busqueda" name="busqueda" placeholder="Nombre del producto" value="<?=htmlspecialchars($busqueda ?? '', ENT_QUOTES, 'UTF-8')?>">
            </div>

            <div>
                <label for="precioMin">Precio mínimo:</label>
                <input type="number" id="precioMin" name="precioMin" placeholder="0" min="0" step="0.01" value="<?=isset($precioMin) && $precioMin !== null ? htmlspecialchars($precioMin, ENT_QUOTES, 'UTF-8') : ''?>">
            </div>

            <div>
                <label for="precioMax">Precio máximo:</label>
                <input type="number" id="precioMax" name="precioMax" placeholder="9999" min="0" step="0.01" value="<?=isset($precioMax) && $precioMax !== null ? htmlspecialchars($precioMax, ENT_QUOTES, 'UTF-8') : ''?>">
            </div>

            <button type="submit">Filtrar</button>
            
            <?php if (!empty($busqueda) || (isset($precioMin) && $precioMin !== null) || (isset($precioMax) && $precioMax !== null)): ?>
                <a href="<?=BASE_URL?>categoria/ver/?id=<?=htmlspecialchars($categoriaId ?? '', ENT_QUOTES, 'UTF-8')?>" style="padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #6c757d; color: white; text-decoration: none; text-align: center;">Limpiar filtros</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (empty($productos)): ?>
        <div class="info-resultado">
            <p>No existen productos que coincidan con tu búsqueda.</p>
        </div>
    <?php else: ?>
        <div class="info-resultado">
            Mostrando resultados de la página <?=$pagina?> de <?=$totalPaginas?>
        </div>

        <div class="item-listing">
            <?php foreach ($productos as $producto): ?>
                <div class="item">
                    <div class="item-image">
                        <a href="<?=BASE_URL?>producto/verDetalles/?id=<?=$producto['id']?>">
                            <img src="<?=BASE_URL?>img/<?=$producto['imagen']?>" alt="Imagen del producto">
                        </a>
                    </div>
                    <div class="item-details">
                        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                        <div class="item-price">
                            <p>Precio: <strong><?= number_format($producto['precio'], 2, ',', '.') ?>€</strong></p>
                            <?php if (!isset($_SESSION['login']) || (isset($_SESSION['login']) && $_SESSION['login']->rol == 'user')): ?>
                                <?php if ($producto['stock'] > 0): ?>
                                    <a class="add-to-cart-btn" href="<?=BASE_URL?>carrito/agregarProducto/?id=<?=$producto['id']?>">
                                        Añadir al Carrito
                                        <i class="ri-shopping-cart-line"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="add-to-cart-btn disabled" disabled>
                                        Agotado
                                        <i class="ri-shopping-cart-line"></i>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($_SESSION['login']) && $_SESSION['login']->rol == 'admin'): ?>
                            <div class="admin-options">
                                <a href="<?=BASE_URL?>producto/borrar/?id=<?=$producto['id']?>">Eliminar</a>
                                <a href="<?=BASE_URL?>producto/editar/?id=<?=$producto['id']?>">Editar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <?php if ($totalPaginas > 1): 
            $catId = htmlspecialchars($categoriaId ?? '', ENT_QUOTES, 'UTF-8');
        ?>
            <div class="pagination">
                <?php if ($pagina > 1): ?>
                    <a href="<?=BASE_URL?>categoria/ver/?id=<?=$catId?>&pagina=1<?=$busqueda ? '&busqueda='.urlencode($busqueda) : ''?><?=(isset($precioMin) && $precioMin !== null) ? '&precioMin='.$precioMin : ''?><?=(isset($precioMax) && $precioMax !== null) ? '&precioMax='.$precioMax : ''?>">Primera</a>
                    <a href="<?=BASE_URL?>categoria/ver/?id=<?=$catId?>&pagina=<?=$pagina-1?><?=$busqueda ? '&busqueda='.urlencode($busqueda) : ''?><?=(isset($precioMin) && $precioMin !== null) ? '&precioMin='.$precioMin : ''?><?=(isset($precioMax) && $precioMax !== null) ? '&precioMax='.$precioMax : ''?>">Anterior</a>
                <?php else: ?>
                    <span class="disabled">Primera</span>
                    <span class="disabled">Anterior</span>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <?php if ($i == $pagina): ?>
                        <span class="active"><?=$i?></span>
                    <?php else: ?>
                        <a href="<?=BASE_URL?>categoria/ver/?id=<?=$catId?>&pagina=<?=$i?><?=$busqueda ? '&busqueda='.urlencode($busqueda) : ''?><?=(isset($precioMin) && $precioMin !== null) ? '&precioMin='.$precioMin : ''?><?=(isset($precioMax) && $precioMax !== null) ? '&precioMax='.$precioMax : ''?>"><?=$i?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($pagina < $totalPaginas): ?>
                    <a href="<?=BASE_URL?>categoria/ver/?id=<?=$catId?>&pagina=<?=$pagina+1?><?=$busqueda ? '&busqueda='.urlencode($busqueda) : ''?><?=(isset($precioMin) && $precioMin !== null) ? '&precioMin='.$precioMin : ''?><?=(isset($precioMax) && $precioMax !== null) ? '&precioMax='.$precioMax : ''?>">Siguiente</a>
                    <a href="<?=BASE_URL?>categoria/ver/?id=<?=$catId?>&pagina=<?=$totalPaginas?><?=$busqueda ? '&busqueda='.urlencode($busqueda) : ''?><?=(isset($precioMin) && $precioMin !== null) ? '&precioMin='.$precioMin : ''?><?=(isset($precioMax) && $precioMax !== null) ? '&precioMax='.$precioMax : ''?>">Última</a>
                <?php else: ?>
                    <span class="disabled">Siguiente</span>
                    <span class="disabled">Última</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
