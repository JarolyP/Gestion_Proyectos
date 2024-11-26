<style>
    .img-thumb-path {
        width: 100px;
        height: 80px;
        object-fit: scale-down;
        object-position: center center;
    }
    .progress-bar {
        transition: width 0.4s ease;
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
                    <col width="3%">
                    <col width="10%">
                    <col width="15%">
                    <col width="12%">
                    <col width="12%">
                    <col width="7%">
                    <col width="20%">
                    <col width="6%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-primary text-light">
                        <th>#</th>
                        <th>Fecha de Creación</th>
                        <th>Tarea</th>
                        <th>Fecha de Inicio Estimada</th>
                        <th>Fecha de Fin Estimada</th>
                        <th>Responsable</th>
                        <th>Progreso</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT t.*, 
                                (SELECT IFNULL(AVG(tk.progress), 0) 
                                 FROM task_list tk 
                                 WHERE tk.project_id = t.project_id) AS progress
                            FROM task_list t
                            WHERE t.status != 'Cancelada'
                            ORDER BY t.date_created DESC");
                        while ($row = $qry->fetch_assoc()):
                            $progress = round($row['progress']);
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                        <td><p class="m-0 truncate-1"><?php echo $row['task'] ?></p></td>
                        <td><?php echo $row['estimated_start_date'] ? date("Y-m-d", strtotime($row['estimated_start_date'])) : 'No definida'; ?></td>
                        <td><?php echo $row['estimated_end_date'] ? date("Y-m-d", strtotime($row['estimated_end_date'])) : 'No definida'; ?></td>
                        <td><p class="m-0 truncate-1"><?php echo $row['responsible'] ?></p></td>
                        <td class="align-middle">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $progress ?>" 
                                     aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress ?>%">
                                </div>
                            </div>
                            <small><?php echo $progress ?>% Completado</small>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                Acción
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="./?page=Task/view_task&id=<?= $row['id'] ?>" data-id="<?php echo $row['id'] ?>">
                                    <span class="fa fa-eye text-dark"></span> Ver
                                </a>
                                <?php if ($row['status'] != 'Completada' && $row['status'] != 'Cancelada'): ?>
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
            uni_modal("Agregar Nueva Tarea", "Task/manage_task.php");
        });
        $('.view_data').click(function(){
            uni_modal("Información de la Tarea", "Task/view_task.php?id=" + $(this).attr('data-id'));
        });
        $('.edit_data').click(function(){
            uni_modal("Actualizar Información de la Tarea", "Task/manage_task.php?id=" + $(this).attr('data-id'));
        });
        $('.delete_data').click(function(){
            _conf("¿Estás segur@ de eliminar esta tarea de forma permanente?", "delete_task", [$(this).attr('data-id')]);
        });
        $('.table').dataTable({
            columnDefs: [{ orderable: false, targets: [6, 7] }],  // Disable sorting on progress and action columns
        });
    });

    function delete_task($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_task",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("Ocurrió un error", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp && resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("Ocurrió un error", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
