<?php
// formulario_productos_v2.php

$link = mysqli_connect("localhost", "root", "Isra2818", "marketzone"); 
if(!$link){ die("Error de conexión: " . mysqli_connect_error()); }

// Inicializar variables
$id = $nombre = $marca = $modelo = $precio = $cantidad = $detalles = $imagen = "";

// Si viene un ID por GET, cargar los datos
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $result = mysqli_query($link, "SELECT * FROM productos WHERE id=$id");
    if($row = mysqli_fetch_assoc($result)){
        $nombre = $row['nombre'];
        $marca = $row['marca'];
        $modelo = $row['modelo'];
        $precio = $row['precio'];
        $cantidad = $row['unidades'];
        $detalles = $row['detalles'];
        $imagen = $row['imagen'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Formulario de cervezas</title>
  <style>
    label { display: inline-block; width: 120px; margin-bottom: 6px; }
    input, select, textarea { margin-bottom: 8px; }
    .error { border: 2px solid red; background-color: #ffe5e5; }
    .valido { border: 2px solid green; background-color: #e8ffe8; }
    .mensaje-error { color: red; font-size: 0.9em; margin: 0 0 8px 125px; display: none; }
  </style>
  <script>
    function validarFormulario(event) {
      event.preventDefault();
      let valido = true;

      // Campos
      const nombre = document.getElementById("form-name");
      const marca = document.getElementById("form-marca");
      const modelo = document.getElementById("form-modelo");
      const precio = document.getElementById("form-precio");
      const cantidad = document.getElementById("form-cantidad");
      const detalles = document.getElementById("form-story");
      const imagen = document.getElementById("form-imagen");
      const modeloRegex = /^[A-Za-z0-9\s]+$/;

      // Limpia errores previos
      document.querySelectorAll(".mensaje-error").forEach(msg => msg.style.display = "none");
      document.querySelectorAll("input, select, textarea").forEach(c => c.classList.remove("error", "valido"));

      // Validaciones
      if(nombre.value.trim() === "" || nombre.value.trim().length > 100){
        mostrarError(nombre, "El nombre es obligatorio y debe tener 100 caracteres o menos.");
        valido = false;
      } else nombre.classList.add("valido");

      if(marca.value === ""){
        mostrarError(marca, "Selecciona una marca de cerveza.");
        valido = false;
      } else marca.classList.add("valido");

      if(modelo.value.trim() === "" || !modeloRegex.test(modelo.value.trim()) || modelo.value.trim().length > 25){
        mostrarError(modelo, "El modelo es obligatorio, alfanumérico y de 25 caracteres o menos.");
        valido = false;
      } else modelo.classList.add("valido");

      const precioVal = parseFloat(precio.value);
      if(isNaN(precioVal) || precioVal <= 99.99){
        mostrarError(precio, "El precio debe ser mayor a 99.99.");
        valido = false;
      } else precio.classList.add("valido");

      const cantidadVal = parseInt(cantidad.value);
      if(isNaN(cantidadVal) || cantidadVal < 0){
        mostrarError(cantidad, "Las unidades deben ser 0 o más.");
        valido = false;
      } else cantidad.classList.add("valido");

      if(detalles.value.trim().length > 250){
        mostrarError(detalles, "Los detalles no deben tener más de 250 caracteres.");
        valido = false;
      } else if(detalles.value.trim() !== "") detalles.classList.add("valido");

      if(imagen.value.trim() === "") imagen.value = "src/cat.png";
      imagen.classList.add("valido");

      if(valido){
        alert("🍺 Producto registrado correctamente");
        document.getElementById("formularioCerveza").submit();
      }
    }

    function mostrarError(campo, mensaje){
      campo.classList.add("error");
      const msg = campo.parentElement.querySelector(".mensaje-error");
      msg.textContent = mensaje;
      msg.style.display = "block";
    }
  </script>
</head>
<body>
<h1><?= $id ? "Editar producto" : "Agregar producto" ?></h1>

<form id="formularioCerveza" action="update_producto.php" method="post" onsubmit="validarFormulario(event)" novalidate>
    <input type="hidden" name="id" value="<?= $id ?>">

    <label for="form-name">Nombre:</label>
    <input type="text" name="name" id="form-name" maxlength="100" value="<?= htmlspecialchars($nombre) ?>" required>
    <p class="mensaje-error"></p><br>

    <label for="form-marca">Marca:</label>
    <select name="marca" id="form-marca" required>
        <option value="">-- Selecciona una marca --</option>
        <option value="Corona" <?= $marca=='Corona'?'selected':'' ?>>Corona</option>
        <option value="Modelo" <?= $marca=='Modelo'?'selected':'' ?>>Modelo</option>
        <option value="Heineken" <?= $marca=='Heineken'?'selected':'' ?>>Heineken</option>
        <option value="Victoria" <?= $marca=='Victoria'?'selected':'' ?>>Victoria</option>
        <option value="Indio" <?= $marca=='Indio'?'selected':'' ?>>Indio</option>
    </select>
    <p class="mensaje-error"></p><br>

    <label for="form-modelo">Modelo:</label>
    <input type="text" name="modelo" id="form-modelo" maxlength="25" value="<?= htmlspecialchars($modelo) ?>" required>
    <p class="mensaje-error"></p><br>

    <label for="form-precio">Precio:</label>
    <input type="number" name="precio" id="form-precio" min="0" step="0.01" value="<?= htmlspecialchars($precio) ?>" required>
    <p class="mensaje-error"></p><br>

    <label for="form-cantidad">Unidades:</label>
    <input type="number" name="cantidad" id="form-cantidad" min="0" step="1" value="<?= htmlspecialchars($cantidad) ?>" required>
    <p class="mensaje-error"></p><br>

    <label for="form-story">Detalles:</label><br>
    <textarea name="story" id="form-story" rows="4" cols="60" placeholder="Opcional, máximo 250 caracteres"><?= htmlspecialchars($detalles) ?></textarea>
    <p class="mensaje-error"></p><br>

    <label for="form-imagen">Imagen:</label>
    <input type="text" name="imagen" id="form-imagen" placeholder="src/cat.png" value="<?= htmlspecialchars($imagen) ?>">
    <p class="mensaje-error"></p><br>

    <input type="submit" value="<?= $id ? "Actualizar producto" : "Agregar producto" ?>">
    <input type="reset">
</form>
</body>
</html>
