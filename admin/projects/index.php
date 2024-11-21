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
        <h3 class="card-title">Lista de Proyectos</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span> Agregar Nuevo Proyecto</a>
        </div>
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
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-primary text-light">
                        <th>#</th>
                        <th>Fecha de Creación</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha Estimada de Inicio</th>
                        <th>Fecha Estimada de Fin</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
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
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
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
</script>