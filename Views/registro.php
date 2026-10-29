

<!-- Views/registro.php -->
<div id="modal-register" class="modal">
    <button class="close-button">x</button>

    <h3>Registrate</h3>

    <form id="form-modal-register" action="index.php?action=registro" method="POST">

        <label for="reg-nombre">Nombre</label>
        <input type="text" id="reg-nombre" name="nombre" required>

        <label for="reg-apellido">Apellido</label>
        <input type="text" id="reg-apellido" name="apellido" required>

        <label for="reg-cedula">Cédula (sin puntos ni guiones)</label>
        <input type="text" id="reg-cedula" name="cedula" required>

        <label for="reg-email">Email</label>
        <input type="email" id="reg-email" name="email" required>

        <label for="reg-contrasena">Contraseña</label>
        <input type="password" id="reg-contrasena" name="contrasena" minlength="8" required>
            
        <button type="submit">Registrar</button>

    </form>
</div>

