<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido en Camino</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #ff9500;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 28px;
        }
        .logo {
            font-size: 24px;
            color: #ff9500;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .greeting {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .status-message {
            background-color: #fff3cd;
            border-left: 4px solid #ff9500;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
            color: #333;
        }
        .order-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
        .order-info p {
            margin: 8px 0;
            color: #555;
            font-size: 14px;
        }
        .order-info strong {
            color: #333;
        }
        .products-section {
            margin-bottom: 25px;
        }
        .products-section h2 {
            color: #333;
            font-size: 20px;
            border-bottom: 2px solid #ff9500;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .product-item {
            border: 1px solid #e0e0e0;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            background-color: #fafafa;
        }
        .product-details {
            flex-grow: 1;
        }
        .product-name {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin: 0 0 8px 0;
        }
        .product-description {
            color: #666;
            font-size: 13px;
            margin: 5px 0;
            line-height: 1.4;
        }
        .product-price {
            color: #ff9500;
            font-weight: bold;
            font-size: 16px;
            margin-top: 8px;
        }
        .product-qty {
            color: #999;
            font-size: 13px;
            margin-top: 5px;
        }
        .summary {
            background-color: #f0f7ff;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 25px;
            text-align: right;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }
        .summary-total {
            border-top: 2px solid #667eea;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 18px;
            color: #333;
            font-weight: bold;
        }
        .footer {
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
        .footer p {
            margin: 5px 0;
        }
        .cta-button {
            background-color: #ff9500;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 15px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🛍️ Tienda de Jairo</div>
            <h1>Pedido en Camino</h1>
        </div>

        <div class="greeting">
            <p>Hola <strong><?php echo htmlspecialchars($nombre); ?></strong>,</p>
            <p>¡Buenas noticias! Tu pedido está en camino y será entregado pronto.</p>
        </div>

        <div class="status-message">
            <strong>📦 Estado del Pedido</strong><br>
            Tu pedido está actualmente <strong>en reparto</strong>. Esperamos poder entregártelo en breve.
        </div>

        <div class="order-info">
            <p><strong>ID del Pedido:</strong> <span style="color: #ff9500; font-weight: bold;">#<?php echo htmlspecialchars($idPedido); ?></span></p>
            <p><strong>Fecha del Pedido:</strong> <?php echo htmlspecialchars($fecha . ' ' . $hora); ?></p>
            <p><strong>Total:</strong> <span style="color: #ff9500; font-weight: bold; font-size: 18px;"><?php echo number_format($pedido['coste'], 2); ?>€</span></p>
        </div>

        <div class="products-section">
            <h2>Productos en tu Pedido</h2>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="product-item">
                        <div class="product-details">
                            <p class="product-name"><?php echo htmlspecialchars($producto['nombre']); ?></p>
                            <p class="product-description"><?php echo htmlspecialchars(substr($producto['descripcion'] ?? '', 0, 100)); ?>...</p>
                            <p class="product-price">€<?php echo number_format($producto['precio'], 2); ?> por unidad</p>
                            <p class="product-qty">Cantidad: <strong><?php echo $producto['unidades']; ?> unidad(es)</strong></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #999;">No hay productos en este pedido.</p>
            <?php endif; ?>
        </div>

        <div style="text-align: center;">
            <a href="<?= BASE_URL ?>pedido/misPedidos/" class="cta-button">Ver Detalles del Pedido</a>
        </div>

        <div class="footer">
            <p>Si tienes alguna pregunta sobre tu pedido, no dudes en <a href="mailto:jairoalejandro71@gmail.com" style="color: #ff9500; text-decoration: none;">contactarnos</a>.</p>
            <p style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                <strong>© 2026 Tienda de Jairo</strong><br>
                Todos los derechos reservados.<br>
                <small>Este es un correo automático, por favor no respondas directamente a este mensaje.</small>
            </p>
        </div>
    </div>
</body>
</html>
