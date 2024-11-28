<?php
// Verifica que se haya enviado un 'id' por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $project_id = intval($_GET['id']); // Asegura que sea un entero

    // Consulta segura utilizando una declaración preparada
    $qry = $conn->prepare("SELECT * FROM `project_list` WHERE id = ? AND delete_flag = 0");
    $qry->bind_param("i", $project_id);
    $qry->execute();
    $result = $qry->get_result();

    // Si se encuentra un registro
    if ($result->num_rows > 0) {
        $res = $result->fetch_assoc();
        foreach ($res as $k => $v) {
            $$k = $v; // Crea variables dinámicas con los nombres de las columnas
        }
    } else {
        echo "<div class='alert alert-danger'>Proyecto no encontrado o eliminado.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID de proyecto no válido.</div>";
    exit;
}

// Función para calcular la duración (si es necesario en otro contexto)
function duration($dur = 0)
{
    $hours = floor($dur / (60 * 60));
    $min = floor($dur / 60) - ($hours * 60);
    return sprintf("%'.02d", $hours) . ":" . sprintf("%'.02d", $min);
}
?>

<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Información de Proyecto</h5>
            <div class="card-tools">
                <?php if (isset($status) && $status == 'Cancelado'): ?>
                    <button class="btn btn-sm btn-default bg-gradient-navy btn-flat" id="close_project">Cerrar Proyecto</button>
                <?php endif; ?>
                <?php if (isset($status) && $status != 'Terminado'): ?>
                    <button class="btn btn-sm btn-primary btn-flat" id="edit_project"><i class="fa fa-edit"></i> Editar Información</button>
                    <button class="btn btn-sm btn-danger btn-flat" id="delete_project"><i class="fa fa-trash"></i> Eliminar Información</button>
                <?php endif; ?>
                <a href="./?page=projects" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <!-- Nombre del Proyecto -->
                    <?php
                    // Asegúrate de que se ha pasado el ID del proyecto
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        // Consulta para obtener el nombre del proyecto desde la base de datos
                        $qry = $conn->query("SELECT name FROM `project_list` WHERE id = '{$id}'");
                        if ($qry && $qry->num_rows > 0) {
                            $project = $qry->fetch_assoc();
                            $name = $project['name'];  // Guarda el nombre del proyecto
                        } else {
                            $name = 'N/A';  // Si no se encuentra el proyecto, muestra 'N/A'
                        }
                    } else {
                        $name = 'N/A';  // Si no se pasa un ID, muestra 'N/A'
                    }
                    ?>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Proyecto</label>
                            <div class="pl-4"><?= isset($name) ? htmlspecialchars($name) : 'N/A' ?>
                            </div>
                        </div>
                    </div>
                        <!-- Estado de Aprobación -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label text-muted">Estado</label>
                                <div class="pl-4">
                                    <?php
                                    switch ($status) { // Cambia 'approval_status' por 'status'
                                        case 'En Planificación':
                                            echo '<span class="rounded-pill badge badge-warning bg-gradient-warning px-3">En Planificación</span>';
                                            break;
                                        case 'Terminado':
                                            echo '<span class="rounded-pill badge badge-success bg-gradient-success px-3">Terminado</span>';
                                            break;
                                        case 'Nuevo':
                                            echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3">Nuevo</span>';
                                            break;
                                        case 'En Proceso':
                                            echo '<span class="rounded-pill badge badge-primary bg-gradient-primary px-3">En Progreso</span>';
                                            break;
                                        default:
                                            echo '<span class="rounded-pill badge badge-secondary bg-gradient-secondary px-3">Cancelado</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Descripción -->
                        <div class="col-md-12">
                            <label class="control-label text-muted">Descripción</label>
                            <div>
                                <?= isset($description) ? html_entity_decode($description) : 'No disponible' ?>
                            </div>
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
                            <th class="text-center">Responsable</th>
                            <th class="text-center">Tareas Asignadas</th>
                            <th class="text-center">Duración Proyecto</th>
                            <th class="text-center">Reportes Entregados</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener los detalles del proyecto
                        $projectQry = $conn->query("SELECT * FROM `project_list` WHERE id = '{$id}'");
                        $project = $projectQry->fetch_assoc();

                        // Datos del proyecto que se desean mostrar en la tabla
                        $projectTitle = isset($project['title']) ? $project['title'] : 'N/A';
                        $projectResponsible = isset($project['responsible']) ? $project['responsible'] : 'N/A';
                        $projectCreationDate = isset($project['date_created']) ? date("Y-m-d H:i", strtotime($project['date_created'])) : 'N/A';

                        // Consulta para obtener los reportes asignados
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, w.name as work_type, e.code as ecode, CONCAT(e.firstname,' ',e.middlename,' ', e.lastname) as fullname
                         FROM `report_list` r
                         INNER JOIN `work_type_list` w ON r.work_type_id = w.id
                         INNER JOIN `employee_list` e ON r.employee_id = e.id
                         WHERE r.project_id = '{$id}'
                         ORDER BY UNIX_TIMESTAMP(r.date_created) DESC");

                        while ($row = $qry->fetch_assoc()):
                        ?>
                            <tr>
                                <td class="px-2 py-1 text-center"><?= $i++; ?></td>
                                <td class="px-2 py-1"><?= date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                <td class="px-2 py-1"><?= $row['fullname'] ?></td>
                                <td class="px-2 py-1"><?= $row['work_type'] ?></td>
                                <td class="px-2 py-1 text-right"><?= duration($row['duration']) ?></td>
                                <td class="px-2 py-1">
                                    <p class="m-0 truncate-1"><?= strip_tags(html_entity_decode($row['description'])) ?></p>
                                </td>
                                <td class="px-2 py-1 text-center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Acción
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
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
        $('#edit_project').click(function() {
            uni_modal("Actualizar Información del proyecto", "projects/manage_project.php?id=<?= isset($id) ? $id : '' ?>")
        })
        $('#delete_project').click(function() {
            _conf("¿Estás segur@ de eliminar este proyecto?", "delete_project", ["<?= isset($id) ? $id : '' ?>"])
        })
        $('#close_project').click(function() {
            _conf("¿Estás segur@ de Cancelar este proyecto?", "close_project", ["<?= isset($id) ? $id : '' ?>"])
        })
        $('.view_data').click(function() {
            uni_modal("Detalles del informe", "projects/view_report.php?id=" + $(this).attr('data-id'), "mid-large")
        })
        $('.table td, .table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable({
            columnDefs: [{
                orderable: false,
                targets: 5
            }],
        });
    })

    function close_project($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=close_project",
            method: "POST",
            data: {
                id: $id
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("Ocurrió un error.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                }
            }
        })
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
                console.log(err)
                alert_toast("Ocurrió un error.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.href = "./?page=projects";
                } else {
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>