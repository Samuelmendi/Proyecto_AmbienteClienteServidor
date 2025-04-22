<?php
require __DIR__ . '/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha       = str_replace('T',' ',$_POST['fecha']);
    $paciente_id = intval($_POST['paciente_id']);
    $medico_id   = intval($_POST['medico_id']);

    $stmt = $pdo->prepare("
      INSERT INTO citas (fecha, paciente_id, medico_id)
      VALUES (:fecha, :paciente, :medico)
    ");
    $stmt->execute([
      ':fecha'    => $fecha,
      ':paciente' => $paciente_id,
      ':medico'   => $medico_id
    ]);

    header('Location: views/agendarCita.php?success=1');
    exit;
}
