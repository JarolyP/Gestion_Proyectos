<?php
require_once('../../config.php');

// Obtener los detalles del proyecto
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `project_list` where id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k))
                $$k = $v;
        }
    }

    // Obtener todas las tareas asociadas al proyecto
    $tasksQry = $conn->query("SELECT * FROM `task_list` WHERE project_id = '{$_GET['id']}'");
    $tasks = [];
    if ($tasksQry->num_rows > 0) {
        while ($task = $tasksQry->fetch_assoc()) {
            $tasks[] = $task;
        }
    }
}

// Eliminar proyecto
if (isset($_POST['delete_project'])) {
    $qry = $conn->query("DELETE FROM `project_list` where id = '{$_GET['id']}'");
    if($qry) {
        echo "<script>alert('Proyecto eliminado exitosamente');</script>";
        echo "<script>window.location.href='project_list.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el proyecto');</script>";
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
    <!-- Formulario del Proyecto -->
    <form action="" id="project-form" method="post">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <div class="form-group">
            <label for="name" class="control-label">Nombre del Proyecto</label>
            <input type="text" name="name" id="name" class="form-control form-control-border" placeholder="Ingresa Nombre del Proyecto" value="<?php echo isset($name) ? $name : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? ($description) : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="start_date" class="control-label">Fecha Estimada de Inicio</label>
            <input type="date" name="estimated_start_date" id="estimated_start_date" class="form-control form-control-border" value="<?php echo isset($estimated_start_date) ? $estimated_start_date : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="end_date" class="control-label">Fecha Estimada de Fin</label>
            <input type="date" name="estimated_end_date" id="estimated_end_date" class="form-control form-control-border" value="<?php echo isset($estimated_end_date) ? $estimated_end_date : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="responsable" class="control-label">Responsable</label>
            <input type="text" name="responsable" id="responsable" class="form-control form-control-border" placeholder="Ingresa el Responsable" value="<?php echo isset($responsable) ? $responsable : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="status" class="control-label">Estado del Proyecto</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="Pendiente" <?php echo (isset($status) && $status == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                <option value="En Proceso" <?php echo (isset($status) && $status == 'En Proceso') ? 'selected' : '' ?>>En Proceso</option>
                <option value="Cancelado" <?php echo (isset($status) && $status == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                <option value="Terminado" <?php echo (isset($status) && $status == 'Terminado') ? 'selected' : '' ?>>Terminado</option>
            </select>
        </div>

        <button type="button" class="btn btn-primary btn-edit-project" data-id="PROJECT_ID" data-name="PROJECT_NAME" data-description="PROJECT_DESCRIPTION">Editar Proyecto</button>
    </form>

    <button type="button" id="delete_project" class="btn btn-danger" data-id="PROJECT_ID">Eliminar Proyecto</button>

    <!-- Tabla de Tareas -->
    <h3>Tareas Asociadas al Proyecto</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de la Tarea</th>
                <th>Descripción</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task) { ?>
                <tr>
                    <td><?php echo $task['id']; ?></td>
                    <td><?php echo $task['name']; ?></td>
                    <td><?php echo $task['description']; ?></td>
                    <td><?php echo $task['start_date']; ?></td>
                    <td><?php echo $task['end_date']; ?></td>
                    <td><?php echo $task['status']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Modal de Edición -->
    <div id="editProjectModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-project-form">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Proyecto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-project-id">
                        <div class="mb-3">
                            <label for="edit-project-name" class="form-label">Nombre del Proyecto</label>
                            <input type="text" class="form-control" id="edit-project-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-project-description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit-project-description" name="description" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Código JavaScript para editar y eliminar proyectos
        $(function () {
            // Código para editar el proyecto
            $('.btn-edit-project').click(function () {
                var projectId = $(this).data('id');
                var projectName = $(this).data('name');
                var projectDescription = $(this).data('description');

                $('#edit-project-id').val(projectId);
                $('#edit-project-name').val(projectName);
                $('#edit-project-description').val(projectDescription);

                $('#editProjectModal').modal('show');
            });

            $('#edit-project-form').submit(function (e) {
                e.preventDefault();
                start_loader();

                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=edit_project",
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.status === 'success') {
                            alert_toast(resp.msg, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            alert_toast(resp.msg || "Ocurrió un error.", 'error');
                        }
                        end_loader();
                    },
                    error: function (err) {
                        console.error(err);
                        alert_toast("Error al editar el proyecto.", 'error');
                        end_loader();
                    }
                });
            });

            // Código para eliminar el proyecto
            $('#delete_project').click(function () {
                var projectId = $(this).data('id');
                if (confirm("¿Estás seguro de eliminar este proyecto de forma permanente?")) {
                    $.post('', { delete_project: true }, function (data) {
                        alert("Proyecto eliminado.");
                        window.location.href = "project_list.php";
                    });
                }
            });
        });
    </script>
</div>
