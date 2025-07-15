<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Factura WEB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">FACTURADOR WEB</h2>

    <form action="procesamiento.php" method="post" class="border p-4 bg-white rounded shadow-sm">
      <h4>Datos del Cliente</h4>
      <div class="row justify-content-start">
        <div class="col-4">
            <label for="nombre" class="form-label">Nombre del cliente:</label>
            <input type="text" class="form-control" id="nombre" name="nombre_cliente" required>
        </div>

        <div class="col-4">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" class="form-control" id="email" name="correo" required>
        </div>
        <div class="col-4">
          <label for="fecha" class="form-label">Fecha:</label>
          <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
      </div>

      <div class="row justify-content-start">

          <div class="col-12">
            <label for="comentarios" class="form-label">Comentarios:</label>
            <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
          </div>
      </div>

      <hr class="my-4">
      <h4>Productos</h4>

        <div class="border rounded p-3 mb-3 bg-light">

      <?php for ($i = 0; $i < 3; $i++): ?>
          <h6 class="text-primary">Producto <?= $i + 1 ?></h6>
        <div class="row justify-content-start">
            <div class="col-md-3">
                <label class="form-label">Nombre del producto:</label>
                <input type="text" class="form-control" name="producto[]">
            </div>
        
            <div class="col-md-2">
                <label class="form-label">Precio:</label>
                <input type="number" class="form-control" name="precio[]" step="0.01" min="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">Cantidad:</label>
                <input type="number" class="form-control" name="cantidad[]" min="1" value="1">
            </div>
            <div class="col-md-4">
                <label class="form-label">Categoría:</label>
                <select class="form-select" name="categoria[]">
                    <option value="General">General</option>
                    <option value="Alimentos">Alimentos</option>
                    <option value="Electrónica">Electrónica</option>
                    <option value="Servicios">Servicios</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-check-label" for="iva<?= $i ?>">IVA (15%)</label>
                <input class="form-check-input" type="checkbox" name="iva[]" value="<?= $i ?>" id="iva<?= $i ?>">
            </div>
      </div>
            <br>
      <?php endfor; ?>
        </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-success btn-lg">Procesar Factura</button>
      </div>
    </form>
  </div>
</body>
</html>
