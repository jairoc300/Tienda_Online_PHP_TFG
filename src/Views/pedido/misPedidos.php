<section class="orden-pedidos-section">
    <div class="orden-container">
        <h1>Mis Pedidos</h1>
        
        <?php if (isset($_SESSION['login']) && count($pedidos) > 0): ?>
            <div class="pedidos-lista">
                <?php foreach ($pedidos as $pedido): ?>
                    <div class="pedido-card">
                        <div class="pedido-header" onclick="togglePedido(this)">
                            <div class="pedido-info">
                                <h3>Pedido #<?= htmlspecialchars($pedido['id']) ?></h3>
                                <p class="pedido-fecha">
                                    <i class="ri-calendar-line"></i> 
                                    <?= date('d/m/Y H:i', strtotime($pedido['fecha'] . ' ' . $pedido['hora'])) ?>
                                </p>
                            </div>
                            <div class="pedido-estado">
                                <span class="estado-badge estado-<?= strtolower($pedido['estado']) ?>">
                                    <?= htmlspecialchars($pedido['estado']) ?>
                                </span>
                                <span class="pedido-total">€<?= number_format($pedido['coste'], 2) ?></span>
                            </div>
                            <button class="toggle-btn" type="button">
                                <i class="ri-arrow-down-s-line"></i>
                            </button>
                        </div>
                        
                        <div class="pedido-productos" style="display: none;">
                            <h4>Productos del Pedido:</h4>
                            <?php 
                                $productos_pedido = isset($productos_por_pedido[$pedido['id']]) ? $productos_por_pedido[$pedido['id']] : [];
                                if (!empty($productos_pedido)): 
                            ?>
                                <div class="productos-grid">
                                    <?php foreach ($productos_pedido as $producto): ?>
                                        <div class="producto-item-pedido">
                                            <div class="producto-nombre">
                                                <strong><?= htmlspecialchars($producto['nombre']) ?></strong>
                                            </div>
                                            <p class="producto-desc"><?= htmlspecialchars(substr($producto['descripcion'] ?? '', 0, 80)) ?>...</p>
                                            <div class="producto-detalles">
                                                <span class="precio">€<?= number_format($producto['precio'], 2) ?></span>
                                                <span class="cantidad">x<?= $producto['unidades'] ?></span>
                                                <span class="subtotal">€<?= number_format($producto['precio'] * $producto['unidades'], 2) ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="no-productos">No hay productos en este pedido.</p>
                            <?php endif; ?>
                            
                            <?php if ($_SESSION['login']->rol == 'admin'): ?>
                                <div class="pedido-acciones">
                                    <a href="<?=BASE_URL?>pedido/confirmar/?id=<?=$pedido['id']?>" class="btn-confirmar">
                                        <i class="ri-check-line"></i> Confirmar Pedido
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="sin-pedidos">
                <i class="ri-inbox-line"></i>
                <p>Actualmente no tienes pedidos registrados.</p>
                <a href="<?=BASE_URL?>" class="btn-volver">Volver a la Tienda</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.orden-pedidos-section {
    padding: 30px 20px;
}

.orden-container {
    max-width: 900px;
    margin: 0 auto;
}

.orden-container h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-size: 2em;
}

.pedidos-lista {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.pedido-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.pedido-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    cursor: pointer;
    transition: background 0.3s ease;
}

.pedido-header:hover {
    background: linear-gradient(135deg, #5568d3 0%, #653a91 100%);
}

.pedido-info h3 {
    margin: 0;
    font-size: 1.3em;
    color: white;
}

.pedido-fecha {
    margin: 5px 0 0 0;
    font-size: 0.9em;
    opacity: 0.9;
}

.pedido-estado {
    display: flex;
    gap: 15px;
    align-items: center;
    flex-shrink: 0;
}

.estado-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85em;
    font-weight: bold;
    text-transform: uppercase;
}

.estado-confirmado {
    background-color: #4caf50;
    color: white;
}

.estado-pendiente {
    background-color: #ff9800;
    color: white;
}

.estado-entregado {
    background-color: #2196f3;
    color: white;
}

.pedido-total {
    font-size: 1.2em;
    font-weight: bold;
    min-width: 100px;
    text-align: right;
}

.toggle-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2em;
    transition: transform 0.3s ease;
    margin-left: 10px;
}

.toggle-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.toggle-btn.active {
    transform: rotate(180deg);
}

.pedido-productos {
    padding: 20px;
    border-top: 1px solid #e0e0e0;
    background-color: #fafafa;
}

.pedido-productos h4 {
    color: #333;
    margin-top: 0;
    margin-bottom: 15px;
}

.productos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.producto-item-pedido {
    background: white;
    padding: 15px;
    border-radius: 6px;
    border-left: 4px solid #667eea;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
}

.producto-nombre {
    color: #333;
    margin-bottom: 8px;
    font-size: 1em;
}

.producto-desc {
    color: #666;
    font-size: 0.85em;
    margin: 5px 0;
    line-height: 1.3;
}

.producto-detalles {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #e0e0e0;
    font-size: 0.9em;
    font-weight: bold;
    color: #333;
}

.precio {
    color: #667eea;
}

.cantidad {
    color: #999;
}

.subtotal {
    color: #ff9500;
}

.no-productos {
    text-align: center;
    color: #999;
    padding: 20px;
    font-style: italic;
}

.pedido-acciones {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
    text-align: center;
}

.btn-confirmar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    transition: transform 0.2s ease;
}

.btn-confirmar:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.sin-pedidos {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.sin-pedidos i {
    font-size: 4em;
    color: #ccc;
    display: block;
    margin-bottom: 15px;
}

.sin-pedidos p {
    color: #999;
    font-size: 1.1em;
    margin: 0 0 20px 0;
}

.btn-volver {
    background: #667eea;
    color: white;
    padding: 12px 30px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    transition: background 0.3s ease;
}

.btn-volver:hover {
    background: #5568d3;
}

@media (max-width: 768px) {
    .pedido-header {
        flex-wrap: wrap;
        gap: 10px;
    }

    .pedido-info h3 {
        font-size: 1.1em;
    }

    .pedido-estado {
        width: 100%;
        justify-content: space-between;
    }

    .productos-grid {
        grid-template-columns: 1fr;
    }

    .toggle-btn {
        width: 35px;
        height: 35px;
        font-size: 1em;
    }
}
</style>

<script>
function togglePedido(header) {
    const btn = header.querySelector('.toggle-btn');
    const card = header.closest('.pedido-card');
    const productos = card.querySelector('.pedido-productos');
    
    btn.classList.toggle('active');
    
    if (productos.style.display === 'none') {
        productos.style.display = 'block';
    } else {
        productos.style.display = 'none';
    }
}
</script>