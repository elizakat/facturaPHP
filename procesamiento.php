<?php

function calcularLinea(float $precio, int $cantidad, bool $aplicaIva): array
{
    $subtotal = $precio * $cantidad;
    $iva      = $aplicaIva ? $subtotal * 0.15 : 0;
    return [$subtotal, $iva, $subtotal + $iva];
}

$cliente = [
    'nombre'      => $_POST['nombre_cliente'] ?? '',
    'correo'      => $_POST['correo']         ?? '',
    'fecha'       => $_POST['fecha']          ?? '',
    'comentarios' => $_POST['comentarios']    ?? ''
];

$productos  = $_POST['producto']  ?? [];
$precios    = $_POST['precio']    ?? [];
$cantidades = $_POST['cantidad']  ?? [];
$categorias = $_POST['categoria'] ?? [];
$tieneIVA   = $_POST['iva']       ?? [];  

$subtotalGeneral = $ivaGeneral = $totalGeneral = 0;

$lineasFactura = [];   

for ($i = 0; $i < count($productos); $i++) {

    if (trim($productos[$i]) === '') continue;

    $precio    = floatval($precios[$i]    ?? 0);
    $cantidad  = intval($cantidades[$i]   ?? 0);
    $conIva    = in_array($i, $tieneIVA);          

    [$sub, $iva, $tot] = calcularLinea($precio, $cantidad, $conIva);

    $detalleFactura[] = [
        'idx'        => $i + 1,
        'nombre'     => $productos[$i],
        'categoria'  => $categorias[$i] ?? '—',
        'precio'     => $precio,
        'cantidad'   => $cantidad,
        'subtotal'   => $sub,
        'iva'        => $iva,
        'total'      => $tot,
        'iva_aplica' => $conIva
    ];

    $subtotalGeneral += $sub;
    $ivaGeneral      += $iva;
    $totalGeneral    += $tot;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Factura Generada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">

  <h2 class="mb-3">Factura web ?></h2>
  <p>
    <strong>Razón social:</strong> <?= htmlspecialchars($cliente['nombre']) ?><br>
    <strong>Correo:</strong> <?= htmlspecialchars($cliente['correo']) ?><br>
    <strong>Fecha:</strong> <?= htmlspecialchars($cliente['fecha']) ?><br>
    <strong>Comentarios:</strong> <?= nl2br(htmlspecialchars($cliente['comentarios'])) ?>
  </p>

  <table class="table table-bordered align-middle">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Producto</th>
        <th>Categoría</th>
        <th class="text-end">Precio</th>
        <th class="text-end">Cantidad</th>
        <th class="text-end">Subtotal</th>
        <th class="text-end">IVA (15 %)</th>
        <th class="text-end">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($detalleFactura as $item): ?>
        <tr>
          <td><?= $item['idx'] ?></td>
          <td><?= htmlspecialchars($item['nombre']) ?></td>
          <td><?= htmlspecialchars($item['categoria']) ?></td>
          <td class="text-end">$<?= number_format($item['precio'], 2) ?></td>
          <td class="text-end"><?= $item['cantidad'] ?></td>
          <td class="text-end">$<?= number_format($item['subtotal'], 2) ?></td>
          <td class="text-end">
              <?= $item['iva_aplica'] ? '$'.number_format($item['iva'], 2) : '0' ?>
          </td>
          <td class="text-end">$<?= number_format($item['total'], 2) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot class="table-secondary fw-bold">
      <tr>
        <td colspan="5" class="text-end">Totales:</td>
        <td class="text-end">$<?= number_format($subtotalGeneral, 2) ?></td>
        <td class="text-end">$<?= number_format($ivaGeneral, 2) ?></td>
        <td class="text-end">$<?= number_format($totalGeneral, 2) ?></td>
      </tr>
    </tfoot>
  </table>
</div>
</body>
</html>
