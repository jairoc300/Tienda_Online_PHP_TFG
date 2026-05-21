<section class="pago-section">
    <div class="pago-container">
        <div class="pago-header">
            <h1>🔒 Pago Seguro con PayPal</h1>
            <p>Completa tu pedido de forma rápida y segura</p>
        </div>

        <?php if (isset($_SESSION['error_pago'])): ?>
            <div class="alerta alerta-error">
                <i class="ri-error-warning-line"></i>
                <p><?= htmlspecialchars($_SESSION['error_pago']) ?></p>
            </div>
            <?php unset($_SESSION['error_pago']); ?>
        <?php endif; ?>

        <div class="pago-contenedor-principal">
            <!-- RESUMEN DEL PEDIDO -->
            <div class="pago-resumen">
                <h2>Resumen del Pedido</h2>
                <div class="resumen-detalles">
                    <div class="detalle-fila">
                        <span>Pedido ID:</span>
                        <strong>#<?= htmlspecialchars($pedido['id']) ?></strong>
                    </div>
                    <div class="detalle-fila">
                        <span>Cliente:</span>
                        <strong><?= htmlspecialchars($_SESSION['login']->nombre . ' ' . $_SESSION['login']->apellidos) ?></strong>
                    </div>
                    <div class="detalle-fila">
                        <span>Email:</span>
                        <strong><?= htmlspecialchars($_SESSION['login']->email) ?></strong>
                    </div>
                    <div class="detalle-fila">
                        <span>Dirección:</span>
                        <strong><?= htmlspecialchars($pedido['direccion'] . ', ' . $pedido['localidad'] . ', ' . $pedido['provincia']) ?></strong>
                    </div>
                    <hr>
                    <div class="detalle-fila monto-total">
                        <span>Monto Total:</span>
                        <strong class="monto">€<?= number_format($pedido['coste'], 2) ?></strong>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO DE PAGO -->
            <div class="pago-formulario">
                <div class="paypal-mockup">
                    <div class="paypal-header">
                        <div class="paypal-logo">
                            <i class="ri-bank-card-2-line"></i> PayPal
                        </div>
                        <div class="paypal-secure">
                            <i class="ri-lock-line"></i> Conexión Segura
                        </div>
                    </div>

                    <form action="<?= BASE_URL ?>pago/efectuarPago" method="POST" id="formularioPago" class="formulario-pago">
                        <input type="hidden" name="pedido_id" value="<?= htmlspecialchars($pedido['id']) ?>">
                        <input type="hidden" name="token_pago" value="<?= htmlspecialchars($dato_pago['token_pago']) ?>">

                        <div class="grupo-formulario">
                            <label for="numero_tarjeta">Número de Tarjeta</label>
                            <input 
                                type="text" 
                                id="numero_tarjeta" 
                                name="numero_tarjeta" 
                                placeholder="1234 5678 9012 3456" 
                                maxlength="19"
                                required
                                pattern="\d{4}\s?\d{4}\s?\d{4}\s?\d{4}"
                            >
                            <small>16 dígitos (formato simulado)</small>
                        </div>

                        <div class="grupo-formulario">
                            <label for="nombre_tarjeta">Nombre en la Tarjeta</label>
                            <input 
                                type="text" 
                                id="nombre_tarjeta" 
                                name="nombre_tarjeta" 
                                placeholder="JOHN DOE"
                                value="<?= htmlspecialchars($_SESSION['login']->nombre . ' ' . $_SESSION['login']->apellidos) ?>"
                                required
                            >
                        </div>

                        <div class="grupo-dobla">
                            <div class="grupo-formulario">
                                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                                <input 
                                    type="text" 
                                    id="fecha_vencimiento" 
                                    name="fecha_vencimiento" 
                                    placeholder="MM/YY"
                                    maxlength="5"
                                    required
                                    pattern="\d{2}/\d{2}"
                                >
                            </div>

                            <div class="grupo-formulario">
                                <label for="cvv">CVV</label>
                                <input 
                                    type="text" 
                                    id="cvv" 
                                    name="cvv" 
                                    placeholder="123"
                                    maxlength="4"
                                    required
                                    pattern="\d{3,4}"
                                >
                            </div>
                        </div>

                        <div class="info-seguridad">
                            <i class="ri-shield-check-line"></i>
                            <p>Tu información de pago está protegida con encriptación SSL de 256 bits</p>
                        </div>

                        <button type="submit" class="btn-pagar">
                            <i class="ri-checkbox-circle-line"></i> Completar Pago - €<?= number_format($pedido['coste'], 2) ?>
                        </button>

                        <a href="<?= BASE_URL ?>pedido/misPedidos" class="btn-cancelar">
                            <i class="ri-close-line"></i> Cancelar
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- MÉTODOS DE PAGO DISPONIBLES -->
        <div class="metodos-pago">
            <h3>Otros Métodos de Pago Disponibles</h3>
            <div class="metodos-grid">
                <div class="metodo">
                    <i class="ri-bank-card-fill"></i>
                    <p>Tarjeta de Crédito/Débito</p>
                </div>
                <div class="metodo">
                    <i class="ri-bank-fill"></i>
                    <p>Transferencia Bancaria</p>
                </div>
                <div class="metodo">
                    <i class="ri-wallet-2-fill"></i>
                    <p>Billetera Digital</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.pago-section {
    padding: 40px 20px;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.pago-container {
    max-width: 1200px;
    margin: 0 auto;
}

.pago-header {
    text-align: center;
    margin-bottom: 40px;
    color: #333;
}

.pago-header h1 {
    font-size: 2.5em;
    margin-bottom: 10px;
    color: #667eea;
}

.pago-header p {
    font-size: 1.1em;
    color: #666;
}

.alerta {
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    display: flex;
    gap: 15px;
    align-items: center;
}

.alerta-error {
    background-color: #ffebee;
    border-left: 4px solid #f44336;
    color: #c62828;
}

.alerta i {
    font-size: 1.5em;
    flex-shrink: 0;
}

.pago-contenedor-principal {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 40px;
}

/* RESUMEN DEL PEDIDO */
.pago-resumen {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    height: fit-content;
}

.pago-resumen h2 {
    color: #333;
    margin-bottom: 20px;
    font-size: 1.3em;
    padding-bottom: 15px;
    border-bottom: 2px solid #667eea;
}

.resumen-detalles {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.detalle-fila {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    color: #555;
}

.detalle-fila span {
    font-weight: 500;
    color: #888;
}

.detalle-fila strong {
    color: #333;
}

.detalle-fila hr {
    border: none;
    border-top: 1px solid #e0e0e0;
    margin: 10px 0;
}

.monto-total {
    font-size: 1.2em;
    padding: 15px 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    padding: 15px;
    border-radius: 6px;
}

.monto {
    color: #667eea;
    font-size: 1.3em;
}

/* FORMULARIO DE PAGO */
.pago-formulario {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.paypal-mockup {
    border: 2px solid #003087;
    border-radius: 8px;
    overflow: hidden;
}

.paypal-header {
    background: linear-gradient(135deg, #003087 0%, #009cde 100%);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.paypal-logo {
    font-size: 1.3em;
    font-weight: bold;
    display: flex;
    gap: 8px;
    align-items: center;
}

.paypal-secure {
    display: flex;
    gap: 6px;
    align-items: center;
    font-size: 0.9em;
}

.formulario-pago {
    padding: 30px;
}

.grupo-formulario {
    margin-bottom: 20px;
}

.grupo-formulario label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
    font-size: 0.95em;
}

.grupo-formulario input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 1em;
    transition: border-color 0.3s ease;
}

.grupo-formulario input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.grupo-formulario input::placeholder {
    color: #999;
}

.grupo-formulario small {
    display: block;
    margin-top: 5px;
    color: #999;
    font-size: 0.85em;
}

.grupo-dobla {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.info-seguridad {
    background: #e8f5e9;
    border-left: 4px solid #4caf50;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    display: flex;
    gap: 12px;
    align-items: center;
    color: #2e7d32;
}

.info-seguridad i {
    font-size: 1.3em;
    flex-shrink: 0;
}

.info-seguridad p {
    margin: 0;
    font-size: 0.9em;
}

.btn-pagar {
    width: 100%;
    padding: 14px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1.05em;
    font-weight: bold;
    cursor: pointer;
    transition: transform 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-pagar:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-pagar:active {
    transform: translateY(0);
}

.btn-cancelar {
    display: block;
    text-align: center;
    margin-top: 12px;
    padding: 10px;
    color: #667eea;
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-cancelar:hover {
    background: #f5f5f5;
    border-color: #667eea;
}

/* MÉTODOS DE PAGO */
.metodos-pago {
    text-align: center;
    margin-top: 40px;
}

.metodos-pago h3 {
    color: #333;
    margin-bottom: 20px;
    font-size: 1.2em;
}

.metodos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    padding: 20px;
}

.metodo {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.metodo:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.metodo i {
    font-size: 2.5em;
    color: #667eea;
    display: block;
    margin-bottom: 10px;
}

.metodo p {
    color: #666;
    margin: 0;
    font-size: 0.95em;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .pago-contenedor-principal {
        grid-template-columns: 1fr;
    }

    .pago-header h1 {
        font-size: 1.8em;
    }

    .grupo-dobla {
        grid-template-columns: 1fr;
    }

    .metodos-grid {
        grid-template-columns: 1fr;
    }

    .paypal-header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
}
</style>

<script>
// Validación de formato de tarjeta en tiempo real
document.getElementById('numero_tarjeta')?.addEventListener('input', function(e) {
    let valor = e.target.value.replace(/\s/g, '');
    if (valor.length > 0) {
        valor = valor.match(/.{1,4}/g)?.join(' ') || valor;
    }
    e.target.value = valor;
});

// Validación de fecha de vencimiento (MM/YY)
document.getElementById('fecha_vencimiento')?.addEventListener('input', function(e) {
    let valor = e.target.value.replace(/\D/g, '');
    if (valor.length >= 2) {
        valor = valor.substring(0, 2) + '/' + valor.substring(2, 4);
    }
    e.target.value = valor;
});

// Validación de CVV (solo números)
document.getElementById('cvv')?.addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
});

// Prevenir envío accidental
document.getElementById('formularioPago')?.addEventListener('submit', function(e) {
    let numeroTarjeta = document.getElementById('numero_tarjeta').value;
    let soloDigitos = numeroTarjeta.replace(/\s/g, '');
    
    if (soloDigitos.length !== 16) {
        e.preventDefault();
        alert('El número de tarjeta debe tener 16 dígitos');
        return false;
    }
});
</script>
