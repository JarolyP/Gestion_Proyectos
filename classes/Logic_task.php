<?php
require_once('../../config.php');

// Guardar o actualizar tarea
if (isset($_POST['f']) && $_POST['f'] == 'save') {
    $task_id = $_POST['task_id'] ?? null;
    $project_id = $_POST['project_id'];
    $estimated_start_date = $_POST['estimated_start_date'];
    $estimated_end_date = $_POST['estimated_end_date'];
    $real_start_date = $_POST['real_start_date'];
    $real_end_date = $_POST['real_end_date'];
    $status = $_POST['status'];
    $responsible = $_POST['responsible'];
    $progress = $_POST['progress'];
    $image = $_FILES['image']['name'];

    // Guardar la imagen si se proporcionó
    if ($image) {
        $upload_dir = "uploads/";
        $image_path = $upload_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    // Insertar o actualizar la tarea en la base de datos
    if ($task_id) {
        $sql = "UPDATE task_list SET
                project_id = '$project_id',
                estimated_start_date = '$estimated_start_date',
                estimated_end_date = '$estimated_end_date',
                real_start_date = '$real_start_date',
                real_end_date = '$real_end_date',
                status = '$status',
                responsible = '$responsible',
                progress = '$progress',
                image = '$image_path'
                WHERE task_id = '$task_id'";
    } else {
        $sql = "INSERT INTO task_list (project_id, estimated_start_date, estimated_end_date, real_start_date, real_end_date, status, responsible, progress, image)
                VALUES ('$project_id', '$estimated_start_date', '$estimated_end_date', '$real_start_date', '$real_end_date', '$status', '$responsible', '$progress', '$image_path')";
    }
    $conn->query($sql);
    echo json_encode(['status' => 'success']);
    exit;
}

// Eliminar tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $task_id = $_POST['delete_id'];

    // Preparar y ejecutar la consulta para eliminar la tarea
    $stmt = $conn->prepare("DELETE FROM `task_list` WHERE task_id = ?");
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'msg' => 'Tarea eliminada con éxito.']);
    } else {
        echo json_encode(['status' => 'failed', 'msg' => 'No se pudo eliminar la tarea.', 'err' => $stmt->error]);
    }
    exit;
}
?>
