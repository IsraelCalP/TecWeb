<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registro de cervezas</title>
  <style type="text/css">
    ol, ul { list-style-type: none; padding: 0; }
    label { display: inline-block; width: 120px; margin-bottom: 6px; }
    input, select, textarea { margin-bottom: 8px; }
    .error {
      border: 2px solid red;
      background-color: #ffe5e5;
    }
    .valido {
      border: 2px solid green;
      background-color: #e8ffe8;
    }
    .mensaje-error {
      color: red;
      font-size: 0.9em;
      margin: 0 0 8px 125px;
      display: none;
    }
  </style>

  <script>
    function validarFormulario(event) {
      event.preventDefault();

      // Limpia mensajes previos
      document.querySelectorAll(".mensaje-error").forEach(msg => msg.style.display = "none");
      document.querySelectorAll("input, select, textarea").forEach(campo => campo.classList.remove("error", "valido"));

      // Obtener campos
      const nombre = document.getElementById("form-name");
      const marca = document.getElementById("form-marca");
      const modelo = document.getElementById("form-modelo");
      const precio = document.getElementById("form-precio");
      const detalles = document.getElementById("form-story");
      const cantidad = document.getElementById("form-cantidad");
      const imagen = document.getElementById("form-imagen");

      let valido = true;
      const modeloRegex = /^[A-Za-z0-9\s]+$/;

      // a) Nombre
      if (nombre.value.trim() === "" || nombre.value.trim().length > 100) {
        mostrarError(nombre, "El nombre es obligatorio y debe tener 100 caracteres o menos.");
        valido = false;
      } else nombre.classList.add("valido");

      // b) Marca
      if (marca.value === "") {
        mostrarError(marca, "Selecciona una marca de cerveza.");
        valido = false;
      } else marca.classList.add("valido");

      // c) Modelo
      if (modelo.value.trim() === "" || !modeloRegex.test(modelo.value.trim()) || modelo.value.trim().length > 25) {
        mostrarError(modelo, "El modelo es obligatorio, alfanumérico y de 25 caracteres o menos.");
        valido = false;
      } else modelo.classList.add("valido");

      // d) Precio
      const precioVal = parseFloat(precio.value);
      if (isNaN(precioVal) || precioVal <= 99.99) {
        mostrarError(precio, "El precio debe ser mayor a 99.99.");
        valido = false;
      } else precio.classList.add("valido");

      // e) Detalles (opcional)
      if (detalles.value.trim().length > 250) {
        mostrarError(detalles, "Los detalles no deben tener más de 250 caracteres.");
        valido = false;
      } else if (detalles.value.trim() !== "") detalles.classList.add("valido");

      // f) Unidades
      const cantidadVal = parseInt(cantidad.value);
      if (isNaN(cantidadVal) || cantidadVal < 0) {
        mostrarError(cantidad, "Las unidades deben ser 0 o más.");
        valido = false;
      } else cantidad.classList.add("valido");

      // g) Imagen
      if (imagen.value.trim() === "") {
        imagen.value = "src/cat.png"; // Imagen por defecto
      }
      imagen.classList.add("valido");

      if (valido) {
        alert("🍺 Producto registrado correctamente");
        document.getElementById("formularioCerveza").submit();
      }
    }

    function mostrarError(campo, mensaje) {
      campo.classList.add("error");
      const msg = campo.parentElement.querySelector(".mensaje-error");
      msg.textContent = mensaje;
      msg.style.display = "block";
    }
  </script>
</head>

<body>
  <h1>Registro de cervezas</h1>

  <form id="formularioCerveza" 
        action="http://localhost/TecWeb/TecWeb/practicas/p08/set_producto_v2.php" 
        method="post" 
        onsubmit="validarFormulario(event)"
        novalidate>

    <fieldset>
      <legend>Agrega una cerveza</legend>

      <ul>
        <li>
          <label for="form-name">Nombre:</label>
          <input type="text" name="name" id="form-name" maxlength="100" required>
          <p class="mensaje-error"></p>
        </li>

        <li>
          <label for="form-marca">Marca:</label>
          <select name="marca" id="form-marca" required>
            <option value="">-- Selecciona una marca --</option>
            <option value="Corona">Corona</option>
            <option value="Modelo">Modelo</option>
            <option value="Heineken">Heineken</option>
            <option value="Victoria">Victoria</option>
            <option value="Indio">Indio</option>
          </select>
          <p class="mensaje-error"></p>
        </li>

        <li>
          <label for="form-modelo">Modelo:</label>
          <input type="text" name="modelo" id="form-modelo" maxlength="25" required>
          <p class="mensaje-error"></p>
        </li>

        <li>
          <label for="form-precio">Precio:</label>
          <input type="number" name="precio" id="form-precio" min="0" step="0.01" placeholder="0.00" required>
          <p class="mensaje-error"></p>
        </li>

        <li>
          <label for="form-story">Detalles:</label><br>
          <textarea name="story" rows="4" cols="60" id="form-story" placeholder="Opcional, máximo 250 caracteres"></textarea>
          <p class="mensaje-error"></p>
        </li>

        <li>
          <label for="form-cantidad">Unidades:</label>
          <input type="number" name="cantidad" id="form-cantidad" min="0" step="1" value="1" required>
          <p class="mensaje-error"></p>
        </li>

        <li>
          <label for="form-imagen">Imagen:</label>
          <input type="text" name="imagen" id="form-imagen" placeholder="src/cat.png">
          <p class="mensaje-error"></p>
        </li>
      </ul> 
    </fieldset>               

    <p>
      <input type="submit" value="Agregar producto">
      <input type="reset">
    </p>

  </form>
</body>
</html>
