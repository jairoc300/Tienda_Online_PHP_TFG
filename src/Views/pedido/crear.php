<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/realizarPedido.css">
    <style>
        .order-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .order-header i {
            font-size: 2.5em;
            color: #ff9800;
        }

        .order-details h1 {
            margin: 0;
            font-size: 1.8em;
        }

        .form-errors {
            background-color: #ffebee;
            border: 2px solid #ff6b6b;
            border-left: 4px solid #ff6b6b;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .form-errors i {
            font-size: 1.3em;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .error-lista {
            flex: 1;
        }

        .form-errors p {
            margin: 5px 0;
            line-height: 1.5;
        }

        .order-details h3 {
            color: #666;
            font-size: 1em;
            margin-bottom: 25px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .form-field {
            margin-bottom: 20px;
        }

        .form-field label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 0.5px;
        }

        .form-field label i {
            color: #ff9800;
            font-size: 1.1em;
        }

        .form-field input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1em;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-field input::placeholder {
            color: #999;
        }

        .form-field input:focus {
            outline: none;
            border-color: #ff9800;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(255, 152, 0, 0.1);
        }

        .info-entrega {
            background: linear-gradient(135deg, #fff8e1 0%, #ffe0b2 100%);
            border-left: 4px solid #ff9800;
            padding: 12px 15px;
            border-radius: 6px;
            margin: 25px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e65100;
            font-size: 0.95em;
        }

        .info-entrega i {
            font-size: 1.3em;
            flex-shrink: 0;
        }

        .confirm-button {
            width: 100%;
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.05em;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .confirm-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 152, 0, 0.4);
        }

        .confirm-button:active {
            transform: translateY(0);
        }

        .confirm-button i {
            font-size: 1.2em;
        }

        @media (max-width: 600px) {
            .order-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .order-details h1 {
                font-size: 1.5em;
            }

            .confirm-button {
                padding: 12px 15px;
                font-size: 1em;
            }

            .form-field input {
                padding: 12px 12px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <section class="order-main">
        <div class="order-details">
            <div class="order-header">
                <i class="ri-map-pin-3-line"></i>
                <h1>Dirección de Entrega</h1>
            </div>
            <h3 class="center-text">Completa tus datos para confirmar tu pedido</h3>
            
            <?php if(!empty($errores)) : ?>
                <div class="form-errors">
                    <i class="ri-error-warning-line"></i>
                    <div class="error-lista">
                        <?php foreach ($errores as $error): ?>
                            <p><?= htmlspecialchars($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <form action="<?=BASE_URL?>pedido/crear" method="POST" class="order-form" onsubmit="return validarFormularioPedido()">
                <div class="form-field">
                    <label for="input-provincia">
                        <i class="ri-map-line"></i> Provincia
                    </label>
                    <input 
                        type="text" 
                        id="input-provincia" 
                        name="provincia" 
                        required 
                        minlength="2" 
                        maxlength="100" 
                        placeholder="Ej: Madrid" 
                        value="<?= isset($_POST['provincia']) ? htmlspecialchars($_POST['provincia']) : '' ?>"
                    >
                </div>

                <div class="form-field">
                    <label for="input-localidad">
                        <i class="ri-building-line"></i> Localidad
                    </label>
                    <input 
                        type="text" 
                        id="input-localidad" 
                        name="localidad" 
                        required 
                        minlength="2" 
                        maxlength="100" 
                        placeholder="Ej: Madrid Capital" 
                        value="<?= isset($_POST['localidad']) ? htmlspecialchars($_POST['localidad']) : '' ?>"
                    >
                </div>

                <div class="form-field">
                    <label for="input-direccion">
                        <i class="ri-roadmap-line"></i> Dirección Completa
                    </label>
                    <input 
                        type="text" 
                        id="input-direccion" 
                        name="direccion" 
                        required 
                        minlength="5" 
                        maxlength="200" 
                        placeholder="Ej: Calle Principal 123, Apt 4B" 
                        value="<?= isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : '' ?>"
                    >
                </div>

                <div class="info-entrega">
                    <i class="ri-truck-line"></i>
                    <span>Tu pedido será entregado en <strong>5-8 días laborables</strong></span>
                </div>

                <button type="submit" class="confirm-button">
                    <i class="ri-check-line"></i> Ir al Pago
                </button>
            </form>
        </div>
    </section>

    <script>
        function validarFormularioPedido() {
            const provincia = document.getElementById('input-provincia').value.trim();
            const localidad = document.getElementById('input-localidad').value.trim();
            const direccion = document.getElementById('input-direccion').value.trim();

            if (provincia.length < 2) {
                alert('La provincia debe tener al menos 2 caracteres.');
                return false;
            }

            if (localidad.length < 2) {
                alert('La localidad debe tener al menos 2 caracteres.');
                return false;
            }

            if (direccion.length < 5) {
                alert('La dirección debe tener al menos 5 caracteres.');
                return false;
            }

            return true;
        }
    </script>

</body>
</html>