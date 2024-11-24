<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `task_list` WHERE id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    img#cimg{
        height: 17vh;
        width: 25vw;
        object-fit: scale-down;
    }
</style>
<div class="container-fluid">
    <form action="" id="task-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <div class="form-group">
            <label for="task" class="control-label">Título de la Tarea</label>
            <input type="text" name="task" id="task" class="form-control form-control-border" placeholder="Ingresa Título de la Tarea" value="<?php echo isset($task) ? $task : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="estimated_start_date" class="control-label">Fecha Estimada de Inicio</label>
            <input type="date" name="estimated_start_date" id="estimated_start_date" class="form-control form-control-border" value="<?php echo isset($estimated_start_date) ? $estimated_start_date : '' ?>">
        </div>

        <div class="form-group">
            <label for="estimated_end_date" class="control-label">Fecha Estimada de Fin</label>
            <input type="date" name="estimated_end_date" id="estimated_end_date" class="form-control form-control-border" value="<?php echo isset($estimated_end_date) ? $estimated_end_date : '' ?>">
        </div>

        <div class="form-group">
            <label for="responsible" class="control-label">Responsable de la Tarea</label>
            <input type="text" name="responsible" id="responsible" class="form-control form-control-border" placeholder="Ingresa Responsable de la Tarea" value="<?php echo isset($responsible) ? $responsible : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="status" class="control-label">Estado</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="Pendiente" <?php echo (isset($status) && $status == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                <option value="En Proceso" <?php echo (isset($status) && $status == 'En Proceso') ? 'selected' : '' ?>>En Proceso</option>
                <option value="Completada" <?php echo (isset($status) && $status == 'Completada') ? 'selected' : '' ?>>Completada</option>
                <option value="Cancelada" <?php echo (isset($status) && $status == 'Cancelada') ? 'selected' : '' ?>>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="task_type" class="control-label">Tipo de Tarea</label>
            <input type="text" name="task_type" id="task_type" class="form-control form-control-border" placeholder="Ingresa Tipo de Tarea" value="<?php echo isset($task_type) ? $task_type : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="project_id" class="control-label">ID del Proyecto</label>
            <input type="text" name="project_id" id="project_id" class="form-control form-control-border" placeholder="ID del Proyecto" value="<?php echo isset($project_id) ? $project_id : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="progress" class="control-label">Progreso</label>
            <input type="number" name="progress" id="progress" class="form-control form-control-border" min="0" max="100" value="<?php echo isset($progress) ? $progress : '' ?>" required>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    // Inicializar Summernote
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ol', 'ul', 'paragraph', 'height']],
            ['table', ['table']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
        ]
    });

    // Guardar tarea
    $('#manage-task').submit(function(e) {
        e.preventDefault();
        start_load(); // Función para mostrar un cargador
        $.ajax({
            url: 'classes/Logic_task.php?action=save_task', // URL ajustada para la acción correcta
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(resp) {
                try {
                    let jsonResponse = JSON.parse(resp);
                    if (jsonResponse.status === 'success') {
                        alert_toast(jsonResponse.msg, "success");
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast(jsonResponse.msg || "Ocurrió un error inesperado", "error");
                        console.error(jsonResponse.err);
                    }
                } catch (err) {
                    console.error("Respuesta inválida del servidor:", resp);
                }
            },
            error: function(err) {
                console.error("Error AJAX:", err);
                alert_toast("Ocurrió un error al guardar la tarea.", "error");
            }
        });
    });

    // Cerrar tarea
    $('.close-task-btn').click(function() {
        let taskId = $(this).data('id');
        if (!taskId) {
            alert_toast("ID de tarea no válido", "error");
            return;
        }
        start_load();
        $.ajax({
            url: 'classes/Logic_task.php?action=close_task', // Invocar acción `close_task`
            method: 'POST',
            data: { id: taskId },
            success: function(resp) {
                try {
                    let jsonResponse = JSON.parse(resp);
                    if (jsonResponse.status === 'success') {
                        alert_toast(jsonResponse.msg, "success");
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast(jsonResponse.msg || "Ocurrió un error al cerrar la tarea", "error");
                        console.error(jsonResponse.err);
                    }
                } catch (err) {
                    console.error("Respuesta inválida del servidor:", resp);
                }
            },
            error: function(err) {
                console.error("Error AJAX:", err);
                alert_toast("Ocurrió un error al cerrar la tarea.", "error");
            }
        });
    });
});
</script>
