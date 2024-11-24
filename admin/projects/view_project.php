<?php
<<<<<<< HEAD
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `project_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
function duration($dur = 0){
    $hours = floor($dur / (60 * 60));
    $min = floor($dur / (60)) - ($hours*60);
    $dur = sprintf("%'.02d",$hours).":".sprintf("%'.02d",$min);
    return $dur;
}
?>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Información de Proyecto</h5>
            <div class="card-tools">
                <?php if(isset($status) && $status == 1): ?>
                <button class="btn btn-sm btn-default bg-gradient-navy btn-flat" id="close_project">Cerrar Proyecto</button>
                <?php endif; ?>
                <?php if(isset($status) && $status != 2): ?>
                <button class="btn btn-sm btn-primary btn-flat" id="edit_project"><i class="fa fa-edit"></i> Editar Información</button>
                <button class="btn btn-sm btn-danger btn-flat" id="delete_project"><i class="fa fa-trash"></i> Eliminar Información</button>
                <?php endif; ?>
                <a href="./?page=projects" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Proyecto</label>
                            <div class="pl-4"><?= isset($name) ? $name : 'N/A' ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Estado</label>
                            <div class="pl-4">
                                <?php 
                                    switch ($status){
                                        case 0:
                                            echo '<span class="rounded-pill badge badge-success bg-gradient-teal px-3">Nuevo</span>';
                                            break;
                                        case 1:
                                            echo '<span class="rounded-pill badge badge-primary bg-gradient-primary px-3">En-curso</span>';
                                            break;
                                        case 2:
                                            echo '<span class="rounded-pill badge badge-dark bg-gradient-dark px-3 text-light">Cerrado</span>';
                                            break;
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label text-muted">Descripción</label>
                        <div>
                            <?= html_entity_decode($description) ?>
                        </div>
                    </div>
                </div>
                <div class="clear-fix my-3"></div>
                <h3 class="border-bottom"><b>Reportes</b></h3>
                <table class="table table-bordered table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="20%">
                        <col width="15%">
                        <col width="10%">
                        <col width="20%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-primary text-light">
                            <th class="text-center">#</th>
                            <th class="text-center">Fecha de Creación</th>
                            <th class="text-center">Emplead@</th>
                            <th class="text-center">Tipo de Trabajo</th>
                            <th class="text-center">Duración (HH:mm)</th>
                            <th class="text-center">Reporte</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                            $qry = $conn->query("SELECT r.*, w.name as work_type, e.code as ecode, CONCAT(e.firstname,' ',e.middlename,' ', e.lastname) as fullname FROM `report_list` r inner join `work_type_list` w on r.work_type_id = w.id inner join employee_list e on r.employee_id = e.id where r.project_id = '{$id}' order by unix_timestamp(r.date_created) desc ");
                            while($row = $qry->fetch_assoc()):
                        ?>
                            <tr>
                                <td class="px-2 py-1 text-center"><?= $i++; ?></td>
                                <td class="px-2 py-1"><?= date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                                <td class="px-2 py-1"><?= $row['fullname'] ?></td>
                                <td class="px-2 py-1"><?= $row['work_type'] ?></td>
                                <td class="px-2 py-1 text-right"><?= duration($row['duration']) ?></td>
                                <td class="px-2 py-1"><p class="m-0 truncate-1"><?= strip_tags(html_entity_decode($row['description'])) ?></p></td>
                                <td class="px-2 py-1 text-center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#edit_project').click(function(){
			uni_modal("Actualizar Información del proyecto","projects/manage_project.php?id=<?= isset($id) ? $id : '' ?>")
		})
        $('#delete_project').click(function(){
			_conf("¿Estás segur@ de eliminar este proyecto?","delete_project",["<?= isset($id) ? $id : '' ?>"])
		})
        $('#close_project').click(function(){
			_conf("¿Estás segur@ de cerrar este proyecto?","close_project",["<?= isset($id) ? $id : '' ?>"])
		})
        $('.view_data').click(function(){
			uni_modal("Detalles del informe","projects/view_report.php?id="+$(this).attr('data-id'),"mid-large")
		})
        $('.table td, .table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
    })
    function close_project($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=close_project",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("Ocurrió un error.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("Ocurrió un error.",'error');
					end_loader();
				}
			}
		})
	}
    function delete_project($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_project",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("Ocurrió un error.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.href="./?page=projects";
				}else{
					alert_toast("Ocurrió un error.",'error');
					end_loader();
				}
			}
		})
	}
=======
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
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
</script>
