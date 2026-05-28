<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse · RedSocial</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="page-center">
    <div class="card">
        <p class="card-title">Crear cuenta</p>
        <p class="card-sub">Completá tus datos para unirte</p>

        <?php if (!empty($errores)): ?>
        <div class="alert alert-error">
            <ul><?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="../controlador/registro_ctrl.php" enctype="multipart/form-data" id="formReg" novalidate>

            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre"
                       value="<?= $datos['nombre'] ?? '' ?>"
                       placeholder="Tu nombre" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= $datos['email'] ?? '' ?>"
                       placeholder="correo@ejemplo.com" required>
            </div>

            <div class="form-group">
                <label for="pass">Contraseña</label>
                <input type="password" id="pass" name="pass"
                       placeholder="Mínimo 8 caracteres" required minlength="8">
            </div>

            <div class="form-group">
                <label for="pass_conf">Confirmar contraseña</label>
                <input type="password" id="pass_conf" name="pass_conf"
                       placeholder="Repetí la contraseña" required>
            </div>

            <div class="form-group">
                <label for="imagen">Foto de perfil (opcional)</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>

            <div id="errores-client" class="alert alert-error" style="display:none;"></div>

            <button type="submit" class="btn btn-primary" style="margin-top:.5rem">Crear cuenta</button>
        </form>

        <p style="text-align:center;margin-top:1.25rem;font-size:.875rem;color:var(--text2)">
            ¿Ya tenés cuenta? <a href="login.php">Iniciá sesión</a>
        </p>
    </div>
</div>

<script>
// Validación en el cliente
document.getElementById('formReg').addEventListener('submit', function(e) {
    const errDiv = document.getElementById('errores-client');
    const msgs = [];

    const nombre = document.getElementById('nombre').value.trim();
    const email  = document.getElementById('email').value.trim();
    const pass   = document.getElementById('pass').value;
    const conf   = document.getElementById('pass_conf').value;

    if (!nombre) msgs.push('El nombre es obligatorio.');
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) msgs.push('El email no es válido.');
    if (pass.length < 8) msgs.push('La contraseña debe tener al menos 8 caracteres.');
    if (pass !== conf) msgs.push('Las contraseñas no coinciden.');

    if (msgs.length) {
        e.preventDefault();
        errDiv.innerHTML = '<ul>' + msgs.map(m => `<li>${m}</li>`).join('') + '</ul>';
        errDiv.style.display = 'block';
        errDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
});
</script>
</body>
</html>