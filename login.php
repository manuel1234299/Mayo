<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión · RedSocial</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="page-center">
    <div class="card">
        <p class="card-title">Bienvenido</p>
        <p class="card-sub">Iniciá sesión para continuar</p>

        <?php if (isset($_SESSION['registro_ok'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['registro_ok']) ?></div>
        <?php unset($_SESSION['registro_ok']); ?>
        <?php endif; ?>

        <?php if (!empty($errores)): ?>
        <div class="alert alert-error">
            <ul><?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="../controlador/login_ctrl.php" id="formLogin" novalidate>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="correo@ejemplo.com" required>
            </div>

            <div class="form-group">
                <label for="pass">Contraseña</label>
                <input type="password" id="pass" name="pass"
                       placeholder="Tu contraseña" required>
            </div>

            <div id="errores-client" class="alert alert-error" style="display:none;"></div>

            <button type="submit" class="btn btn-primary" style="margin-top:.5rem">Iniciar sesión</button>
        </form>

        <p style="text-align:center;margin-top:1.25rem;font-size:.875rem;color:var(--text2)">
            ¿No tenés cuenta? <a href="registro.php">Registrate</a>
        </p>
    </div>
</div>

<script>
document.getElementById('formLogin').addEventListener('submit', function(e) {
    const errDiv = document.getElementById('errores-client');
    const msgs = [];

    const email = document.getElementById('email').value.trim();
    const pass  = document.getElementById('pass').value;

    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) msgs.push('Ingresá un email válido.');
    if (!pass) msgs.push('La contraseña es obligatoria.');

    if (msgs.length) {
        e.preventDefault();
        errDiv.innerHTML = '<ul>' + msgs.map(m => `<li>${m}</li>`).join('') + '</ul>';
        errDiv.style.display = 'block';
    }
});
</script>
</body>
</html>