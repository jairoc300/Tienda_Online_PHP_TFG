<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - Tienda Online</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/editarProductos.css">
</head>
<body>
    <section class="edit-section">
        <div class="edit-product-form">
            <h1>Crear Producto</h1>
            
            <?php if (!empty($errores)): ?>
                <div class="form-errors">
                    <strong><i class="ri-error-warning-line"></i> Errores encontrados:</strong>
                    <?php foreach ($errores as $error): ?>
                        <p>• <?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?=BASE_URL?>producto/crear" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre"><i class="ri-text"></i> Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" required minlength="3" maxlength="100" placeholder="Ej: Monitor LG 24 pulgadas">
                </div>

                <div class="form-group">
                    <label for="descripcion"><i class="ri-file-text-line"></i> Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required minlength="5" maxlength="500" placeholder="Describe las características del producto..."></textarea>
                </div>

                <div class="form-group">
                    <label for="precio"><i class="ri-money-dollar-circle-line"></i> Precio:</label>
                    <input type="number" id="precio" name="precio" required min="0.01" step="0.01" max="999999.99" placeholder="0.00">
                </div>

                <div class="form-group">
                    <label for="stock"><i class="ri-inbox-line"></i> Stock:</label>
                    <input type="number" id="stock" name="stock" required min="0" step="1" max="999999" placeholder="0">
                </div>

                <div class="form-group">
                    <label for="categoria_id"><i class="ri-folder-line"></i> Categoría:</label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="">-- Selecciona una categoría --</option>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?=$categoria['id']?>"><?=htmlspecialchars($categoria['nombre'])?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="imagen"><i class="ri-image-add-line"></i> Imagen del Producto:</label>
                    <input type="file" id="imagen" name="imagen" required accept="image/*">
                    <small>Formatos aceptados: JPG, PNG, GIF, WebP (máx. 5MB)</small>
                </div>

                <div class="form-actions">
                    <input type="submit" value="✓ Crear Producto" class="update-button">
                    <a href="<?=BASE_URL?>" class="update-button cancel">✕ Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</body>
</html>