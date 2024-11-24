<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">Lista de Tareas</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary">
                <span class="fas fa-plus"></span> Agregar Nueva Tarea
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-primary text-light">
                        <th>#</th>
                        <th>Fecha de Creación</th>
                        <th>Tarea</th>
                        <th>Fecha de Inicio Estimada</th>
                        <th>Fecha de Fin Estimada</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT * from `task_list` where status != 'Cancelada' order by `task` asc");
                        while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                        <td class=""><p class="m-0 truncate-1"><?php echo $row['task'] ?></p></td>
                        <td class=""><?php echo $row['estimated_start_date'] ? date("Y-m-d", strtotime($row['estimated_start_date'])) : 'No definida'; ?></td>
                        <td class=""><?php echo $row['estimated_end_date'] ? date("Y-m-d", strtotime($row['estimated_end_date'])) : 'No definida'; ?></td>
                        <td class=""><p class="m-0 truncate-1"><?php echo $row['responsible'] ?></p></td>
                        <td class="text-center">
                            <?php 
                                switch ($row['status']){
                                    case 'Pendiente':
                                        echo '<span class="rounded-pill badge badge-warning bg-gradient-warning px-3">Pendiente</span>';
                                        break;
                                    case 'En Proceso':
                                        echo '<span class="rounded-pill badge badge-primary bg-gradient-primary px-3">En Proceso</span>';
                                        break;
                                    case 'Completada':
                                        echo '<span class="rounded-pill badge badge-success bg-gradient-teal px-3">Completada</span>';
                                        break;
                                    case 'Cancelada':
                                        echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3">Cancelada</span>';
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
                                <a class="dropdown-item" href="./?page=tasks/view_task&id=<?= $row['id'] ?>" data-id="<?php echo $row['id'] ?>">
                                    <span class="fa fa-eye text-dark"></span> Ver
                                </a>
                                <?php if($row['status'] != 'Cancelada'): ?>
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
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
        $('#create_new').click(function(){
			uni_modal("Agregar Nuevo Tarea","Task/manage_task.php")
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
</script>