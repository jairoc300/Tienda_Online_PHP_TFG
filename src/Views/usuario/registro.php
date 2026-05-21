<?php use Utils\Utils; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Tienda Online</title>
    <link rel="icon" href="<?=BASE_URL?>public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/global.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cabecera.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/registro.css">
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
        .form-group input,
        .form-group select {
            border: 1px solid #ddd;
            transition: border-color 0.3s;
        }
        .form-group input.error,
        .form-group select.error {
            border-color: #dc3545;
            background-color: #fff5f5;
            color: #000;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #007bff;
            outline: none;
        }
    </style>
</head>
<body>

    <div class="fondo_crearCuenta">

        <section class="signup-section">
            <h1>Crear Cuenta</h1>
            <?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
                <div class="notification success">Tu registro fue exitoso.</div>
            <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
                <div class="notification failure">Error en el registro, intenta nuevamente.</div>
            <?php endif; ?>
            <?php Utils::removeSession('register'); ?>
            <?php if (!empty($errores)): ?>
                <div class="form-errors" style="background-color: #ffebee; border: 1px solid #ef5350; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                    <strong style="color: #c62828;">Errores de validación:</strong>
                    <ul style="margin: 10px 0 0 20px; color: #c62828;">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="registration-form" action="<?= BASE_URL ?>usuario/registro/" method="POST" onsubmit="return validarFormularioRegistro()">
                <div class="form-group">
                    <label for="input-name">Nombre</label>
                    <input type="text" name="data[nombre]" id="input-name" required minlength="2" maxlength="50" placeholder="Tu nombre" value="<?= isset($_POST['data']['nombre']) ? htmlspecialchars($_POST['data']['nombre']) : '' ?>">
                    <div class="validation-error" id="nombre-error"></div>
                </div>
            
                <div class="form-group">
                    <label for="input-lastname">Apellidos</label>
                    <input type="text" name="data[apellidos]" id="input-lastname" required minlength="2" maxlength="50" placeholder="Tus apellidos" value="<?= isset($_POST['data']['apellidos']) ? htmlspecialchars($_POST['data']['apellidos']) : '' ?>">
                    <div class="validation-error" id="apellidos-error"></div>
                </div>

                <?php if (isset($_SESSION['login']) && $_SESSION['login']->rol == 'admin'): ?>
                    <div class="form-group">
                        <label for="select-role">Rol</label>
                        <select name="data[rol]" id="select-role">
                            <option value="admin">Administrador</option>
                            <option value="user">Usuario</option>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="input-email">Correo Electrónico</label>
                    <input type="email" name="data[email]" id="input-email" required placeholder="correo@ejemplo.com" value="<?= isset($_POST['data']['email']) ? htmlspecialchars($_POST['data']['email']) : '' ?>">
                    <div class="validation-error" id="email-error"></div>
                </div>
                
                <div class="form-group">
                    <label for="input-password">Contraseña</label>
                    <input type="password" name="data[password]" id="input-password" required minlength="6" placeholder="Mínimo 6 caracteres, con letras y números">
                    <div class="validation-error" id="password-error"></div>
                </div>

                <?php if (!isset($_SESSION['login'])): ?>
                    <p class="login-link">¿Ya estás registrado? <a href="<?= BASE_URL ?>usuario/login">Inicia sesión aquí</a></p>
                <?php endif; ?>

                <button type="submit" class="submit-btn">Registrarse</button>
            </form>
        </section>

    </div>

    <script>
        function validarFormularioRegistro() {
            const nombre = document.getElementById('input-name').value.trim();
            const apellidos = document.getElementById('input-lastname').value.trim();
            const email = document.getElementById('input-email').value.trim();
            const password = document.getElementById('input-password').value.trim();
            
            let esValido = true;

            // Validar nombre
            const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚ ]{2,}$/;
            if (!nombreRegex.test(nombre)) {
                document.getElementById('nombre-error').textContent = 'El nombre debe contener solo letras y tener al menos 2 caracteres.';
                document.getElementById('nombre-error').classList.add('show');
                document.getElementById('input-name').classList.add('error');
                esValido = false;
            } else {
                document.getElementById('nombre-error').classList.remove('show');
                document.getElementById('input-name').classList.remove('error');
            }

            // Validar apellidos
            if (!nombreRegex.test(apellidos)) {
                document.getElementById('apellidos-error').textContent = 'Los apellidos deben contener solo letras y tener al menos 2 caracteres.';
                document.getElementById('apellidos-error').classList.add('show');
                document.getElementById('input-lastname').classList.add('error');
                esValido = false;
            } else {
                document.getElementById('apellidos-error').classList.remove('show');
                document.getElementById('input-lastname').classList.remove('error');
            }

            // Validar email
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email-error').textContent = 'Por favor ingresa un correo válido.';
                document.getElementById('email-error').classList.add('show');
                document.getElementById('input-email').classList.add('error');
                esValido = false;
            } else {
                document.getElementById('email-error').classList.remove('show');
                document.getElementById('input-email').classList.remove('error');
            }

            // Validar contraseña
            const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;
            if (!passwordRegex.test(password)) {
                document.getElementById('password-error').textContent = 'La contraseña debe tener al menos 6 caracteres, con letras y números.';
                document.getElementById('password-error').classList.add('show');
                document.getElementById('input-password').classList.add('error');
                esValido = false;
            } else {
                document.getElementById('password-error').classList.remove('show');
                document.getElementById('input-password').classList.remove('error');
            }

            return esValido;
        }

        // Validar en tiempo real
        document.getElementById('input-name')?.addEventListener('blur', function() {
            const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚ ]{2,}$/;
            if (!nombreRegex.test(this.value.trim())) {
                document.getElementById('nombre-error').textContent = 'El nombre debe contener solo letras y tener al menos 2 caracteres.';
                document.getElementById('nombre-error').classList.add('show');
                this.classList.add('error');
            } else {
                document.getElementById('nombre-error').classList.remove('show');
                this.classList.remove('error');
            }
        });

        document.getElementById('input-lastname')?.addEventListener('blur', function() {
            const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚ ]{2,}$/;
            if (!nombreRegex.test(this.value.trim())) {
                document.getElementById('apellidos-error').textContent = 'Los apellidos deben contener solo letras y tener al menos 2 caracteres.';
                document.getElementById('apellidos-error').classList.add('show');
                this.classList.add('error');
            } else {
                document.getElementById('apellidos-error').classList.remove('show');
                this.classList.remove('error');
            }
        });

        document.getElementById('input-email')?.addEventListener('blur', function() {
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

        document.getElementById('input-password')?.addEventListener('blur', function() {
            const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;
            if (!passwordRegex.test(this.value.trim())) {
                document.getElementById('password-error').textContent = 'La contraseña debe tener al menos 6 caracteres, con letras y números.';
                document.getElementById('password-error').classList.add('show');
                this.classList.add('error');
            } else {
                document.getElementById('password-error').classList.remove('show');
                this.classList.remove('error');
            }
        });
    </script>

</body>
