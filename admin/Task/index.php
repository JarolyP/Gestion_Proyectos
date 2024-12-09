<style>
    .img-thumb-path {
        width: 100px;
        height: 80px;
        object-fit: scale-down;
        object-position: center center;
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
                    <col width="20%">
                    <col width="20%">
                    <col width="20%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-primary text-light">
                        <th>#</th>
                        <th>Nombre de Tarea</th>
                        <th>Descripción</th>
                        <th>Fecha Est. Inicio</th>
                        <th>Fecha Est. Fin</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT * FROM `task_list` ORDER BY `date_created` DESC");
                    while ($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['task']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['estimated_start_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['estimated_end_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['responsible']); ?></td>
                            <td class="text-center">
                                <?php
                                switch ($row['status']) {
                                    case 'Pendiente':
                                        echo '<span class="rounded-pill badge badge-warning px-3">Pendiente</span>';
                                        break;
                                    case 'En Proceso':
                                        echo '<span class="rounded-pill badge badge-primary px-3">En Proceso</span>';
                                        break;
                                    case 'Completada':
                                        echo '<span class="rounded-pill badge badge-success px-3">Completada</span>';
                                        break;
                                    case 'Cancelada':
                                        echo '<span class="rounded-pill badge badge-danger px-3">Cancelada</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Acción
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="./?page=task/view_task&id=<?= $row['id'] ?>" data-id="<?php echo $row['id'] ?>">
                                        <span class="fa fa-eye text-dark"></span> Ver
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
                                        <span class="fa fa-edit text-primary"></span> Editar
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
                                        <span class="fa fa-trash text-danger"></span> Eliminar
                                    </a>
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
    $(document).ready(function() {
        $('#create_new').click(function() {
            uni_modal("Agregar Nueva Tarea", "task/manage_task.php");
        });

        $('.edit_data').click(function() {
            uni_modal("Actualizar Información de la Tarea", "task/manage_task.php?id=" + $(this).attr('data-id'));
        });

        $('.delete_data').click(function() {
            _conf("¿Estás segur@ de eliminar esta tarea de forma permanente?", "deleteTask", [$(this).attr('data-id')]);
        });

        $('.table td, .table th').addClass('py-1 px-2 align-middle');

        $('.table').dataTable({
            columnDefs: [{
                orderable: false,
                targets: 7
            }]
        });
    });

    function deleteTask(id) {
        if (confirm("¿Estás seguro de que quieres eliminar esta tarea? Esta acción no se puede deshacer.")) {
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=delete_task",
                method: 'POST',
                data: { id: id },
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("Ocurrió un error al intentar eliminar la tarea.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status === 'success') {
                        alert_toast("Tarea eliminada exitosamente.", 'success');
                        location.reload();
                    } else if (resp.msg) {
                        alert_toast(resp.msg, 'error');
                    } else {
                        alert_toast("Error desconocido al eliminar la tarea.", 'error');
                    }
                    end_loader();
                }
            });
        }
    }
</script>
