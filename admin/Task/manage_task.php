<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `task_list` where project_id = '{$_GET['id']}'");
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
        <input type="hidden" name="project_id" value="<?php echo isset($project_id) ? $project_id : '' ?>">

        <div class="form-group">
            <label for="task" class="control-label">Tarea</label>
            <input type="text" name="task" id="task" class="form-control form-control-border" placeholder="Ingresa Tarea" value="<?php echo isset($task) ? $task : '' ?>" required>
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
            <label for="actual_start_date" class="control-label">Fecha Real de Inicio</label>
            <input type="date" name="actual_start_date" id="actual_start_date" class="form-control form-control-border" value="<?php echo isset($actual_start_date) ? $actual_start_date : '' ?>">
        </div>

        <div class="form-group">
            <label for="actual_end_date" class="control-label">Fecha Real de Fin</label>
            <input type="date" name="actual_end_date" id="actual_end_date" class="form-control form-control-border" value="<?php echo isset($actual_end_date) ? $actual_end_date : '' ?>">
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
            <label for="responsible" class="control-label">Responsable de la Tarea</label>
            <input type="text" name="responsible" id="responsible" class="form-control form-control-border" placeholder="Ingresa Responsable" value="<?php echo isset($responsible) ? $responsible : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="progress" class="control-label">Progreso (%)</label>
            <input type="number" name="progress" id="progress" class="form-control form-control-border" min="0" max="100" value="<?php echo isset($progress) ? $progress : '0' ?>" required>
        </div>

        <div class="form-group">
            <label for="task_type" class="control-label">Tipo de Tarea</label>
            <input type="text" name="task_type" id="task_type" class="form-control form-control-border" placeholder="Ingresa Tipo de Tarea" value="<?php echo isset($task_type) ? $task_type : '' ?>" required>
        </div>
    </form>
</div>

<script>
    $(function() {
        $('#uni_modal #task-form').submit(function(e) {
            e.preventDefault(); // Prevenir el comportamiento predeterminado del formulario
            var _this = $(this);
            $('.pop-msg').remove(); // Eliminar mensajes previos de error o éxito

            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();

            start_loader(); // Mostrar loader durante el proceso

            // Usar FormData para enviar datos del formulario con soporte de archivos
            var formData = new FormData(this);

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_task", // Ruta del backend
                data: formData,
                cache: false, // No almacenar en caché la solicitud
                contentType: false, // No configurar manualmente el encabezado
                processData: false, // Evitar transformar los datos
                method: 'POST', // Método HTTP
                dataType: 'json', // Respuesta esperada del servidor
                error: function(err) {
                    console.log("Error de AJAX:", err); // Mostrar error en la consola
                    alert_toast("Ocurrió un error. Revisa la consola para más detalles.", 'error');
                    end_loader(); // Ocultar loader
                },
                success: function(resp) {
                    // Evaluar el estado de la respuesta
                    if (resp.status === 'success') {
                        alert_toast("Tarea guardada con éxito.", 'success');
                        setTimeout(function() {
                            location.reload(); // Recargar la página
                        }, 1500); // Retraso de 1.5 segundos
                    } else if (resp.msg) {
                        // Mensaje de error personalizado del servidor
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        _this.prepend(el);
                    } else {
                        // Mensaje de error genérico
                        el.addClass("alert-danger");
                        el.text("Se produjo un error debido a un motivo desconocido.");
                        _this.prepend(el);
                    }
                    el.show('slow'); // Mostrar el mensaje de error
                    $('html,body,.modal').animate({ scrollTop: 0 }, 'fast'); // Desplazar al inicio del modal
                    end_loader(); // Ocultar loader
                }
            });
        });
    });
</script>
