<section class="estadisticas-section">
    <div class="estadisticas-container">
        <h1>Estadísticas de la Tienda</h1>
        
        <div class="estadisticas-grid">
            <div class="stat-card">
                <h3>Usuarios Registrados</h3>
                <p class="stat-number"><?= $usuarios ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Pedidos</h3>
                <p class="stat-number"><?= $pedidos ?></p>
            </div>
            <div class="stat-card">
                <h3>Ingresos Totales</h3>
                <p class="stat-number"><?= number_format($ingresos, 2) ?> €</p>
            </div>
        </div>

        <div class="stats-content">
            <h2>Ventas por Producto (Top 10)</h2>
            <?php if (!empty($ventas)): ?>
                <table class="estadisticas-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Unidades Vendidas</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach (array_slice($ventas, 0, 10) as $venta): ?>
                        <tr>
                            <td><?= htmlspecialchars($venta["nombre"]) ?></td>
                            <td><strong><?= $venta["total_vendido"] ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">No hay datos de ventas disponibles.</p>
            <?php endif; ?>
        </div>

        <div class="stats-content">
            <h2>Estado de Pedidos</h2>
            <?php if (!empty($estados)): ?>
                <div class="status-grid">
                <?php foreach ($estados as $estado): ?>
                    <div class="status-card">
                        <span class="status-label"><?= htmlspecialchars($estado["estado"]) ?></span>
                        <span class="status-count"><?= $estado["total"] ?></span>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-data">No hay datos de pedidos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.estadisticas-section {
    background-image: url("<?=BASE_URL?>public/img/fondo_detalles.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    min-height: 100vh;
    padding: 100px 20px 60px;
}

.estadisticas-container {
    max-width: 1200px;
    margin: 0 auto;
}

.estadisticas-container h1 {
    text-align: center;
    color: #ff9500;
    margin: 20px 0 30px 0;
    font-size: 2.2em;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    animation: fadeInDown 0.5s ease;
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.estadisticas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.stat-card h3 {
    margin: 0 0 15px 0;
    font-size: 1.1em;
    font-weight: normal;
    opacity: 0.9;
}

.stat-number {
    margin: 0;
    font-size: 2.5em;
    font-weight: bold;
}

.stats-content {
    background: #f9f9f9;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.stats-content h2 {
    color: #333;
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 1.6em;
}

.estadisticas-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    margin-top: 10px;
}

.estadisticas-table th {
    background-color: #667eea;
    color: white;
    padding: 12px;
    text-align: left;
    font-weight: bold;
}

.estadisticas-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #e0e0e0;
}

.estadisticas-table tr:hover {
    background-color: #f5f5f5;
}

.status-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 15px;
}

.status-card {
    background: white;
    border: 2px solid #667eea;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.status-label {
    display: block;
    font-weight: bold;
    color: #333;
    margin-bottom: 8px;
    text-transform: uppercase;
    font-size: 0.85em;
}

.status-count {
    display: block;
    font-size: 2em;
    color: #667eea;
    font-weight: bold;
}

.no-data {
    text-align: center;
    color: #999;
    padding: 20px;
    font-style: italic;
}

@media (max-width: 768px) {
    .estadisticas-container h1 {
        font-size: 1.8em;
    }

    .estadisticas-grid {
        grid-template-columns: 1fr;
    }

    .status-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>