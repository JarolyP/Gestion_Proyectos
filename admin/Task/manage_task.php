<?php
require_once('../../config.php');
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `task_list` where project_id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k))
                $$k = $v;
        }
    }
}
?>
<style>
    img#cimg {
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
                <option value="Pendiente" <?php echo (isset($status) && $status == 'Nuevo') ? 'selected' : '' ?>>Nuevo</option>
                <option value="En Proceso" <?php echo (isset($status) && $status == 'En Proceso') ? 'selected' : '' ?>>En Proceso</option>
                <option value="Completada" <?php echo (isset($status) && $status == 'Completada') ? 'selected' : '' ?>>Completada</option>
                <option value="Cancelada" <?php echo (isset($status) && $status == 'Cancelada') ? 'selected' : '' ?>>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="responsible" class="control-label">Empleados de la Tarea</label>
            <select name="responsible" id="responsible" class="form-control form-control-border" required>
                <option value="">Selecciona un Empleado</option>
                <?php
                // Consultar los empleados disponibles en la base de datos
                $employees_query = $conn->query("SELECT id, CONCAT(firstname, ' ', lastname) AS full_name FROM employee_list WHERE status = 1 ORDER BY lastname ASC");

                // Mostrar los empleados disponibles en el campo <select>
                while ($employee = $employees_query->fetch_assoc()):
                ?>
                    <option value="<?php echo $employee['id']; ?>"><?php echo $employee['full_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>


        <div class="form-group">
            <label for="task_type" class="control-label">Proyecto al que pertenece</label>
            <select name="task_type" id="task_type" class="form-control form-control-border" required>
                <option value="">Selecciona un Proyecto</option>
                <?php
                // Consultar los proyectos disponibles en la base de datos
                $projects_query = $conn->query("SELECT id, title FROM project_list WHERE delete_flag = 0 ORDER BY title ASC");

                // Mostrar los proyectos disponibles en el campo <select>
                while ($project = $projects_query->fetch_assoc()):
                ?>
                    <option value="<?php echo $project['id']; ?>"><?php echo $project['title']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>


        <script>
            // Script para seleccionar el proyecto
            document.querySelectorAll('.select-project-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    // Obtener el ID y el título del proyecto seleccionado
                    var projectId = this.getAttribute('data-id');
                    var projectTitle = this.getAttribute('data-title');

                    // Establecer el valor del input con el ID del proyecto seleccionado
                    document.getElementById('task_type').value = projectTitle; // Puedes cambiar esto si prefieres guardar el ID
                });
            });
            $(function() {
                $('#uni_modal #task-form').submit(function(e) {
                    e.preventDefault(); // Prevenir envío estándar del formulario
                    var _this = $(this);
                    $('.pop-msg').remove(); // Eliminar mensajes previos de error o éxito

                    // Crear contenedor para mensajes dinámicos
                    var el = $('<div>');
                    el.addClass("pop-msg alert");
                    el.hide();

                    start_loader(); // Mostrar loader mientras se procesa

                    var formData = new FormData(this); // Recoger los datos del formulario

                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: _base_url_ + "classes/Master.php?f=save_task", // Ruta hacia el backend
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        method: 'POST',
                        dataType: 'json',
                        error: function(err) {
                            // Manejar errores de AJAX
                            console.log("Error de AJAX:", err);
                            alert_toast("Ocurrió un error. Revisa la consola para más detalles.", 'error');
                            end_loader();
                        },
                        success: function(resp) {
                            // Procesar respuesta del servidor
                            console.log("Respuesta del servidor:", resp); // Depuración

                            if (resp.status === 'success') {
                                // Mensaje de éxito y recargar página
                                alert_toast(resp.msg, 'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                // Mostrar errores devueltos por el backend
                                el.addClass("alert-danger");
                                if (resp.error) {
                                    el.text("Error: " + resp.error);
                                } else if (resp.msg) {
                                    el.text(resp.msg);
                                } else {
                                    el.text("Se produjo un error desconocido.");
                                }
                                _this.prepend(el);
                            }
                            el.show('slow'); // Mostrar el mensaje de error
                            $('html,body,.modal').animate({
                                scrollTop: 0
                            }, 'fast');
                            end_loader(); // Ocultar loader
                        }
                    });
                });
            });
        </script>