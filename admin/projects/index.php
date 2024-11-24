<style>
<<<<<<< HEAD
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
=======
    .img-thumb-path {
        width: 100px;
        height: 80px;
        object-fit: scale-down;
        object-position: center center;
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">Lista de Proyectos</h3>
        <div class="card-tools">
<<<<<<< HEAD
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary">
                <span class="fas fa-plus"></span> Agregar Nuevo Proyecto
            </a>
=======
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span> Agregar Nuevo Proyecto</a>
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
<<<<<<< HEAD
                    <col width="15%">
                    <col width="15%">
                    <col width="20%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
=======
                    <col width="25%">
                    <col width="25%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
                </colgroup>
                <thead>
                    <tr class="bg-gradient-primary text-light">
                        <th>#</th>
                        <th>Fecha de Creación</th>
<<<<<<< HEAD
                        <th>Título</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
=======
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha Estimada de Inicio</th>
                        <th>Fecha Estimada de Fin</th>
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
<<<<<<< HEAD
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT * from `project_list` where delete_flag = 0 order by `title` asc ");
                        while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                        <td class=""><p class="m-0 truncate-1"><?php echo $row['title'] ?></p></td>
                        <td class=""><?php echo $row['start_date'] ? date("Y-m-d", strtotime($row['start_date'])) : 'No definida'; ?></td>
                        <td class=""><?php echo $row['end_date'] ? date("Y-m-d", strtotime($row['end_date'])) : 'No definida'; ?></td>
                        <td class=""><p class="m-0 truncate-1"><?php echo $row['responsible'] ?></p></td>
                        <td class="text-center">
                            <?php 
                                switch ($row['status']){
                                    case 'Nuevo':
                                        echo '<span class="rounded-pill badge badge-success bg-gradient-teal px-3">Nuevo</span>';
                                        break;
                                    case 'En Proceso':
                                        echo '<span class="rounded-pill badge badge-primary bg-gradient-primary px-3">En Proceso</span>';
                                        break;
                                    case 'Cancelado':
                                        echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3">Cancelado</span>';
                                        break;
                                    case 'Terminado':
                                        echo '<span class="rounded-pill badge badge-success bg-gradient-green px-3">Terminado</span>';
                                        break;
                                    case 'Pendiente':
                                        echo '<span class="rounded-pill badge badge-warning bg-gradient-warning px-3">Pendiente</span>';
                                        break;
                                    case 'Cerrado':
                                        echo '<span class="rounded-pill badge badge-dark bg-gradient-dark px-3 text-light">Cerrado</span>';
                                        break;
                                }
                            ?>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                Acción
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="./?page=projects/view_project&id=<?= $row['id'] ?>" data-id="<?php echo $row['id'] ?>">
                                    <span class="fa fa-eye text-dark"></span> Ver
                                </a>
                                <?php if($row['status'] != 'Cerrado'): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
                                    <span class="fa fa-edit text-primary"></span> Editar
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
                                    <span class="fa fa-trash text-danger"></span> Eliminar
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
=======
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT * from `project_list` where delete_flag = 0 order by `name` asc ");
                    while ($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                            <td class="">
                                <p class="m-0 truncate-1"><?php echo $row['name'] ?></p>
                            </td>
                            <td class="">
                                <p class="m-0 truncate-1"><?php echo $row['description'] ?></p>
                            </td>
                            <td class=""><?php echo date("Y-m-d", strtotime($row['estimated_start_date'])) ?></td>
                            <td class=""><?php echo date("Y-m-d", strtotime($row['estimated_end_date'])) ?></td>
                            <td class=""><?php echo $row['responsable'] ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <?php
                                        switch ($row['status']) {
                                            case 0:
                                                echo 'Pendiente';
                                                break;
                                            case 1:
                                                echo 'En Proceso';
                                                break;
                                            case 2:
                                                echo 'Cancelado';
                                                break;
                                            case 3:
                                                echo 'Terminado';
                                                break;
                                        }
                                        ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="0">Pendiente</a>
                                        <a class="dropdown-item" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="1">En Proceso</a>
                                        <a class="dropdown-item" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="2">Cancelado</a>
                                        <a class="dropdown-item" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="3">Terminado</a>
                                    </div>
                                </div>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Acción
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class=" dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="./?page=projects/view_project&id=<?= $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                    <?php if ($row['status'] != 2): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
<<<<<<< HEAD
	$(document).ready(function(){
        $('#create_new').click(function(){
			uni_modal("Agregar Nuevo Proyecto","projects/manage_project.php")
		})
		$('.view_data').click(function(){
			uni_modal("Información del Proyecto","projects/view_project.php?id="+$(this).attr('data-id'))
		})
        $('.edit_data').click(function(){
			uni_modal("Actualizar Información del Proyecto","projects/manage_project.php?id="+$(this).attr('data-id'))
		})
		$('.delete_data').click(function(){
			_conf("¿Estás segur@ de eliminar este proyecto de forma permanente?","delete_project",[$(this).attr('data-id')])
		})
		$('.table td, .table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_project($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_project",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("Ocurrió un error",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("Ocurrió un error",'error');
					end_loader();
				}
			}
		})
	}
=======
    $(document).ready(function() {
        $('#create_new').click(function() {
            uni_modal("Agregar Nuevo Proyecto", "projects/manage_project.php")
        })
        $('.view_data').click(function() {
            uni_modal("Información del Proyecto", "projects/view_project.php?id=" + $(this).attr('data-id'))
        })
        $('.edit_data').click(function() {
            uni_modal("Actualizar Información del Proyecto", "projects/manage_project.php?id=" + $(this).attr('data-id'))
        })
        $('.delete_data').click(function() {
            _conf("¿Estás segur@ de eliminar este proyecto de forma permanente?", "delete_project", [$(this).attr('data-id')])
        })
        $('.table td, .table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable({
            columnDefs: [{
                orderable: false,
                targets: 8
            }],
        });

        // Cambiar estado del proyecto
        $('.dropdown-item').click(function() {
            var projectId = $(this).data('id');
            var newStatus = $(this).data('status');
            updateProjectStatus(projectId, newStatus);
        });
    })

    function updateProjectStatus(id, status) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=update_project_status",
            method: "POST",
            data: {
                id: id,
                status: status
            },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("Ocurrió un error", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("Ocurrió un error", 'error');
                    end_loader();
                }
            }
        });
    }

    function delete_project($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_project",
            method: "POST",
            data: {
                id: $id
            },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("Ocurrió un error", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("Ocurrió un error", 'error');
                    end_loader();
                }
            }
        });
    }
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
</script>