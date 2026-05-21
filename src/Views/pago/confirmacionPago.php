<section class="confirmacion-pago-section">
    <div class="confirmacion-container">
        <?php if (defined('MODO_DESARROLLO') && MODO_DESARROLLO): ?>
            <div class="banner-desarrollo">
                <i class="ri-flask-2-line"></i>
                <p><strong>MODO DESARROLLO</strong> - Pago aprobado automáticamente sin formulario</p>
            </div>
        <?php endif; ?>

        <div class="confirmacion-card">
            <div class="confirmacion-icono">
                <i class="ri-checkbox-circle-fill"></i>
            </div>

            <h1>¡Pago Procesado Exitosamente!</h1>
            <p class="confirmacion-subtitulo">Tu pedido ha sido pagado y confirmado</p>

            <div class="detalles-confirmacion">
                <div class="detalle-item">
                    <span class="label">Referencia de Pago:</span>
                    <span class="valor"><?= htmlspecialchars($referencia_pago) ?></span>
                </div>
                <div class="detalle-item">
                    <span class="label">Pedido ID:</span>
                    <span class="valor">#<?= htmlspecialchars($pedido['id']) ?></span>
                </div>
                <div class="detalle-item">
                    <span class="label">Monto Pagado:</span>
                    <span class="valor monto">€<?= number_format($pedido['coste'], 2) ?></span>
                </div>
                <div class="detalle-item">
                    <span class="label">Estado:</span>
                    <span class="valor estado confirmado">
                        <i class="ri-check-line"></i> Confirmado
                    </span>
                </div>
                <div class="detalle-item">
                    <span class="label">Fecha de Pago:</span>
                    <span class="valor"><?= date('d/m/Y H:i:s') ?></span>
                </div>
            </div>

            <div class="confirmacion-mensaje">
                <i class="ri-mail-line"></i>
                <p>Se ha enviado un comprobante de pago a <strong><?= htmlspecialchars($_SESSION['login']->email) ?></strong></p>
            </div>

            <div class="acciones">
                <a href="<?= BASE_URL ?>pedido/misPedidos" class="btn-primario">
                    <i class="ri-file-list-line"></i> Ver Mis Pedidos
                </a>
                <a href="<?= BASE_URL ?>" class="btn-secundario">
                    <i class="ri-home-line"></i> Volver al Inicio
                </a>
            </div>

            <div class="informacion-envio">
                <h3><i class="ri-map-pin-2-line"></i> Información de Entrega</h3>
                <form class="formulario-direccion" id="formularioDireccion" method="POST" action="<?= BASE_URL ?>pago/actualizarDireccion">
                    <input type="hidden" name="pedido_id" value="<?= htmlspecialchars($pedido['id']) ?>">
                    
                    <div class="campo-direccion">
                        <label for="destinatario">Destinatario</label>
                        <input type="text" id="destinatario" name="destinatario" value="<?= htmlspecialchars($_SESSION['login']->nombre . ' ' . $_SESSION['login']->apellidos) ?>" readonly>
                    </div>

                    <div class="campo-direccion">
                        <label for="provincia">Provincia</label>
                        <input type="text" id="provincia" name="provincia" value="<?= htmlspecialchars($pedido['provincia']) ?>" required minlength="2" maxlength="100">
                    </div>

                    <div class="campo-direccion">
                        <label for="localidad">Localidad</label>
                        <input type="text" id="localidad" name="localidad" value="<?= htmlspecialchars($pedido['localidad']) ?>" required minlength="2" maxlength="100">
                    </div>

                    <div class="campo-direccion">
                        <label for="direccion">Dirección Completa</label>
                        <input type="text" id="direccion" name="direccion" value="<?= htmlspecialchars($pedido['direccion']) ?>" required minlength="5" maxlength="200" placeholder="Ej: Calle Principal 123, Apt 4B">
                    </div>

                    <div class="tiempo-entrega">
                        <i class="ri-time-line"></i>
                        <span><strong>Tiempo Estimado:</strong> 5-8 días laborables</span>
                    </div>

                    <button type="submit" class="btn-actualizar-direccion">
                        <i class="ri-save-line"></i> Actualizar Dirección
                    </button>
                </form>
            </div>
        </div>

        <div class="pasos-seguimiento">
            <h2>Estado de tu Pedido</h2>
            <div class="linea-tiempo">
                <div class="paso paso-activo">
                    <div class="punto"></div>
                    <div class="contenido">
                        <h4>Pago Completado</h4>
                        <p><?= date('d/m/Y H:i') ?></p>
                    </div>
                </div>
                <div class="conector"></div>
                <div class="paso">
                    <div class="punto"></div>
                    <div class="contenido">
                        <h4>Pedido Preparándose</h4>
                        <p>Próximamente</p>
                    </div>
                </div>
                <div class="conector"></div>
                <div class="paso">
                    <div class="punto"></div>
                    <div class="contenido">
                        <h4>En Tránsito</h4>
                        <p>Próximamente</p>
                    </div>
                </div>
                <div class="conector"></div>
                <div class="paso">
                    <div class="punto"></div>
                    <div class="contenido">
                        <h4>Entregado</h4>
                        <p>Próximamente</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.banner-desarrollo {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    align-items: center;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
}

.banner-desarrollo i {
    font-size: 1.3em;
    flex-shrink: 0;
}

.banner-desarrollo p {
    margin: 0;
}

.confirmacion-pago-section {
    padding: 40px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.confirmacion-container {
    max-width: 900px;
    margin: 0 auto;
    width: 100%;
}

.confirmacion-card {
    background: white;
    padding: 50px 30px;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    text-align: center;
    margin-bottom: 30px;
}

.confirmacion-icono {
    font-size: 4em;
    color: #4caf50;
    margin-bottom: 20px;
}

.confirmacion-card h1 {
    color: #333;
    font-size: 2.2em;
    margin-bottom: 10px;
}

.confirmacion-subtitulo {
    color: #666;
    font-size: 1.1em;
    margin-bottom: 30px;
}

.detalles-confirmacion {
    background: #f5f7fa;
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 30px;
    text-align: left;
}

.detalle-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #e0e0e0;
}

.detalle-item:last-child {
    border-bottom: none;
}

.detalle-item .label {
    color: #666;
    font-weight: 500;
}

.detalle-item .valor {
    color: #333;
    font-weight: 600;
}

.detalle-item .monto {
    color: #667eea;
    font-size: 1.2em;
}

.detalle-item .estado {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9em;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.estado.confirmado {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.confirmacion-mensaje {
    background: #e3f2fd;
    border-left: 4px solid #2196f3;
    padding: 20px;
    border-radius: 6px;
    margin-bottom: 30px;
    display: flex;
    gap: 15px;
    align-items: center;
    color: #1565c0;
}

.confirmacion-mensaje i {
    font-size: 1.5em;
    flex-shrink: 0;
}

.confirmacion-mensaje p {
    margin: 0;
}

.acciones {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    justify-content: center;
}

.btn-primario,
.btn-secundario {
    padding: 12px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    display: inline-flex;
    gap: 8px;
    align-items: center;
    transition: all 0.3s ease;
}

.btn-primario {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primario:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-secundario {
    background: #f0f0f0;
    color: #333;
    border: 1px solid #ddd;
}

.btn-secundario:hover {
    background: #e8e8e8;
}

.informacion-envio {
    background: white;
    border-left: 4px solid #ff9800;
    padding: 30px;
    border-radius: 12px;
    text-align: left;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.informacion-envio h3 {
    color: #ff9800;
    margin-top: 0;
    margin-bottom: 25px;
    font-size: 1.2em;
    display: flex;
    align-items: center;
    gap: 10px;
}

.informacion-envio h3 i {
    font-size: 1.3em;
}

.formulario-direccion {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.campo-direccion {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.campo-direccion label {
    color: #333;
    font-weight: 600;
    font-size: 0.95em;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.campo-direccion input {
    padding: 12px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    font-size: 1em;
    color: #333;
    background-color: #fafafa;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

.campo-direccion input:focus {
    outline: none;
    border-color: #ff9800;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
}

.campo-direccion input:read-only {
    background-color: #f5f5f5;
    color: #666;
    cursor: not-allowed;
}

.tiempo-entrega {
    background: linear-gradient(135deg, #fff9e6 0%, #ffe8cc 100%);
    border: 1px solid #ffd699;
    padding: 12px 15px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #e65100;
    font-size: 0.95em;
    margin-top: 10px;
}

.tiempo-entrega i {
    font-size: 1.1em;
    flex-shrink: 0;
}

.btn-actualizar-direccion {
    padding: 12px 20px;
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 10px;
}

.btn-actualizar-direccion:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 152, 0, 0.3);
}

.btn-actualizar-direccion:active {
    transform: translateY(0);
}

.btn-actualizar-direccion i {
    font-size: 1.1em;
}

/* PASOS DE SEGUIMIENTO */
.pasos-seguimiento {
    background: white;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.pasos-seguimiento h2 {
    text-align: center;
    color: #333;
    margin-bottom: 40px;
    font-size: 1.5em;
}

.linea-tiempo {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 0;
}

.paso {
    display: flex;
    gap: 20px;
    position: relative;
    padding: 20px 0;
}

.paso .punto {
    width: 40px;
    height: 40px;
    background: #ddd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 2;
}

.paso.paso-activo .punto {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: bold;
}

.paso.paso-activo .punto::after {
    content: '✓';
    font-weight: bold;
}

.paso .contenido {
    flex: 1;
}

.paso .contenido h4 {
    margin: 0 0 5px 0;
    color: #333;
}

.paso .contenido p {
    margin: 0;
    color: #999;
    font-size: 0.9em;
}

.paso.paso-activo .contenido h4 {
    color: #667eea;
}

.conector {
    width: 2px;
    height: 40px;
    background: #ddd;
    margin-left: 19px;
    position: relative;
    z-index: 1;
}

.paso:last-child .conector {
    display: none;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .confirmacion-card {
        padding: 30px 20px;
    }

    .confirmacion-card h1 {
        font-size: 1.6em;
    }

    .detalles-confirmacion {
        padding: 15px;
    }

    .detalle-item {
        flex-direction: column;
        text-align: left;
        align-items: flex-start;
    }

    .acciones {
        flex-direction: column;
    }

    .btn-primario,
    .btn-secundario {
        width: 100%;
        justify-content: center;
    }

    .pasos-seguimiento {
        padding: 25px 20px;
    }

    .paso {
        padding: 15px 0;
    }

    .formulario-direccion {
        gap: 12px;
    }

    .campo-direccion input {
        padding: 10px 12px;
        font-size: 16px;
    }

    .informacion-envio {
        padding: 20px;
    }

    .btn-actualizar-direccion {
        font-size: 0.9em;
        padding: 10px 15px;
    }
}
</style>
