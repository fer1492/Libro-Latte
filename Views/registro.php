<!-- Views/registro.php -->
<div id="modal-register" class="modal">
    <button class="close-button" type="button">x</button>

    <h3>Registrate</h3>

    <form id="form-modal-register" action="Index.php?action=registro" method="POST">
        <input type="hidden" name="origen" value="<?= htmlspecialchars($_GET['action'] ?? 'inicio', ENT_QUOTES, 'UTF-8') ?>">

        <label for="reg-nombre">Nombre</label>
        <input type="text" id="reg-nombre" name="nombre" required placeholder="Tu nombre">

        <label for="reg-apellido">Apellido</label>
        <input type="text" id="reg-apellido" name="apellido" required placeholder="Tu apellido">

        <label for="reg-cedula">Cédula (sin puntos ni guiones)</label>
        <input type="text" id="reg-cedula" name="cedula" pattern="[0-9]{6,12}" required placeholder="Ej: 12345678">

        <label for="reg-email">Email</label>
        <input type="email" id="reg-email" name="email" required placeholder="tu@correo.com">

        <label for="reg-contrasena">Contraseña (mínimo 8 caracteres)</label>
        <input type="password" id="reg-contrasena" name="contrasena" minlength="8" required placeholder="Mínimo 8 caracteres">
            
        <button type="submit">Registrarme como Socio</button>
    </form>
</div>
