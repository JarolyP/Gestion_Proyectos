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
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="25%">
                    <col width="25%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-primary text-light">
                        <th>#</th>
                        <th>Fecha de Creación</th>
                        <th>Tarea</th>
                        <th>Descripción</th>
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
                            <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])); ?></td>
                            <td><p class="m-0 truncate-1"><?php echo $row['task']; ?></p></td>
                            <td><p class="m-0 truncate-1"><?php echo $row['description']; ?></p></td>
                            <td class="text-center">
                                <?php 
                                    switch ($row['status']) {
                                        case 'Nuevo':
                                            echo '<span class="rounded-pill badge badge-success bg-gradient-teal px-3">Nuevo</span>';
                                            break;
                                        case 'En Planificación':
                                            echo '<span class="rounded-pill badge badge-primary bg-gradient-primary px-3">En Planificación</span>';
                                            break;
                                        case 'En Proceso':
                                            echo '<span class="rounded-pill badge badge-warning bg-gradient-warning px-3">En Proceso</span>';
                                            break;
                                        case 'Terminada':
                                            echo '<span class="rounded-pill badge badge-dark bg-gradient-dark px-3 text-light">Terminada</span>';
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
                                    <a class="dropdown-item" href="./?page=task/view_task&id=<?php echo $row['id']; ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                    <?php if ($row['status'] != 'Terminada' && $row['status'] != 'Cancelada'): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
    $(document).ready(function () {
        $('.delete_data').click(function () {
            _conf("¿Estás segur@ de eliminar esta tarea de forma permanente?", "delete_task", [$(this).attr('data-id')]);
        });

        $('.table td, .table th').addClass('py-1 px-2 align-middle');
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
    });

    function delete_task(id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_task",
            method: "POST",
            data: { id: id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("Ocurrió un error.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (typeof resp === 'object' && resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
