<?php
require_once('../../config.php');
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `project_list` where id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k))
                $$k = $v;
        }
    }
}
if(isset($_POST['delete_project'])) {
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

        <button type="button" id="delete_project" class="btn btn-danger" data-id="PROJECT_ID">Eliminar Proyecto</button>

<script>
    $(function() {
        // Al hacer clic en el botón de eliminación
        $('#delete_project').click(function() {
            var projectId = $(this).data('id'); // Obtener el ID del proyecto desde el atributo `data-id`
            if (!confirm("¿Estás seguro de que deseas eliminar este proyecto de forma permanente?")) {
                return; // Si el usuario cancela, no hace nada
            }

            start_loader(); // Función para mostrar cargador (debes implementarla en tu sistema)

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=delete_project", // Conecta con el archivo Master.php
                method: 'POST',
                data: { id: projectId }, // Enviar el ID del proyecto
                dataType: 'json',
                success: function(resp) {
                    if (resp.status === 'success') {
                        alert_toast(resp.msg, 'success'); // Mensaje de éxito
                        setTimeout(function() {
                            location.reload(); // Recargar la página
                        }, 2000);
                    } else {
                        alert_toast(resp.msg || "No se pudo eliminar el proyecto.", 'error'); // Mostrar mensaje de error
                        console.error(resp.err); // Mostrar error en consola para depuración
                    }
                    end_loader(); // Ocultar cargador
                },
                error: function(err) {
                    console.error(err);
                    alert_toast("Ocurrió un error al intentar eliminar el proyecto.", 'error');
                    end_loader();
                }
            });
        });
    });
    $(function () {
    // Abrir el modal de edición y rellenar datos existentes
    $('.btn-edit-project').click(function () {
        var projectId = $(this).data('id');
        var projectName = $(this).data('name');
        var projectDescription = $(this).data('description');

        // Asignar datos al formulario del modal
        $('#edit-project-id').val(projectId);
        $('#edit-project-name').val(projectName);
        $('#edit-project-description').val(projectDescription);

        // Mostrar el modal
        $('#editProjectModal').modal('show');
    });

    // Manejar el envío del formulario de edición
    $('#edit-project-form').submit(function (e) {
        e.preventDefault();
        start_loader(); // Mostrar cargador (función de tu sistema)

        $.ajax({
            url: _base_url_ + "classes/Master.php?f=edit_project", // Ruta al método PHP
            method: 'POST',
            data: $(this).serialize(), // Enviar los datos del formulario
            dataType: 'json',
            success: function (resp) {
                if (resp.status === 'success') {
                    alert_toast(resp.msg, 'success'); // Mensaje de éxito
                    setTimeout(function () {
                        location.reload(); // Recargar página
                    }, 2000);
                } else {
                    alert_toast(resp.msg || "Ocurrió un error.", 'error'); // Mostrar error
                }
                end_loader(); // Ocultar cargador
            },
            error: function (err) {
                console.error(err);
                alert_toast("Error al editar el proyecto.", 'error');
                end_loader();
            }
        });
    });
});
</script>
