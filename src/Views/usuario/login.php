<?php use Utils\Utils; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Tienda Online</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/login.css">
    <style>
        .validation-error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
        .validation-error.show {
            display: block;
        }
        .form-field {
            margin-bottom: 20px;
        }
        .form-field input {
            border: 1px solid #ddd;
            transition: border-color 0.3s;
        }
        .form-field input.error {
            border-color: #dc3545;
            background-color: #fff5f5;
            color: #000;
        }
        .form-field input:focus {
            border-color: #007bff;
            outline: none;
        }
    </style>
</head>
<body>

    <div class="fondo_login">
        <section class="authentication-section">
            <h1>Acceso de Usuarios</h1>
            <?php if (isset($_SESSION['login']) && $_SESSION['login'] == 'complete'): ?>
                <div class="notification success">Acceso correcto, bienvenido al sistema.</div>
            <?php elseif (isset($_SESSION['login']) && $_SESSION['login'] == 'failed'): ?>
                <div class="notification error">Error de acceso. Revisa tu correo y contraseña.</div>
                <?php Utils::removeSession('login'); ?>
                <?php if (!empty($errores)): ?>
                    <div class="list-errors">
                        <?php foreach ($errores as $error): ?>
                            <p><?= htmlspecialchars($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (!isset($_SESSION['login']) || $_SESSION['login'] == 'failed'): ?>
            <form class="login-form" action="<?= BASE_URL ?>usuario/login/" method="POST" onsubmit="return validarFormularioLogin()">
                <div class="form-field">
                    <label for="user-email">Correo Electrónico</label>
                    <input type="email" name="data[email]" id="user-email" required placeholder="correo@ejemplo.com">
                    <div class="validation-error" id="email-error"></div>
                </div>

                <div class="form-field">
                    <label for="user-password">Contraseña</label>
                    <input type="password" name="data[password]" id="user-password" required placeholder="Mínimo 6 caracteres" minlength="6">
                    <div class="validation-error" id="password-error"></div>
                </div>

                <div class="account-options">
                    <p>¿Nuevo usuario? <a href="<?= BASE_URL ?>usuario/registro">Crea una cuenta</a></p>
                </div>

                <button type="submit" class="btn-login">Acceder</button>
            </form>
            <?php endif; ?>
        </section>
    </div>

    <script>
        function validarFormularioLogin() {
            const email = document.getElementById('user-email').value.trim();
            const password = document.getElementById('user-password').value.trim();
            let esValido = true;

            // Validar email
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email-error').textContent = 'Por favor ingresa un correo válido.';
                document.getElementById('email-error').classList.add('show');
                document.getElementById('user-email').classList.add('error');
                esValido = false;
            } else {
                document.getElementById('email-error').classList.remove('show');
                document.getElementById('user-email').classList.remove('error');
            }

            // Validar contraseña
            if (password.length < 6) {
                document.getElementById('password-error').textContent = 'La contraseña debe tener al menos 6 caracteres.';
                document.getElementById('password-error').classList.add('show');
                document.getElementById('user-password').classList.add('error');
                esValido = false;
            } else {
                document.getElementById('password-error').classList.remove('show');
                document.getElementById('user-password').classList.remove('error');
            }

            return esValido;
        }

        // Validar en tiempo real
        document.getElementById('user-email')?.addEventListener('blur', function() {
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(this.value.trim())) {
                document.getElementById('email-error').textContent = 'Por favor ingresa un correo válido.';
                document.getElementById('email-error').classList.add('show');
                this.classList.add('error');
            } else {
                document.getElementById('email-error').classList.remove('show');
                this.classList.remove('error');
            }
        });

        document.getElementById('user-password')?.addEventListener('blur', function() {
            if (this.value.length < 6) {
                document.getElementById('password-error').textContent = 'La contraseña debe tener al menos 6 caracteres.';
                document.getElementById('password-error').classList.add('show');
                this.classList.add('error');
            } else {
                document.getElementById('password-error').classList.remove('show');
                this.classList.remove('error');
            }
        });
    </script>

</body>
</html>