<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `task_list` WHERE id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Información de Tarea</h5>
            <div class="card-tools">
                <?php if(isset($status) && $status == 'En Proceso'): ?>
                <button class="btn btn-sm btn-default bg-gradient-navy btn-flat" id="close_task">Cerrar Tarea</button>
                <?php endif; ?>
                <?php if(isset($status) && $status != 'Completada' && $status != 'Cancelada'): ?>
                <button class="btn btn-sm btn-primary btn-flat" id="edit_task"><i class="fa fa-edit"></i> Editar Información</button>
                <button class="btn btn-sm btn-danger btn-flat" id="delete_task"><i class="fa fa-trash"></i> Eliminar Información</button>
                <?php endif; ?>
                <a href="./?page=Task" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Tarea</label>
                            <div class="pl-4"><?= isset($task) ? $task : 'N/A' ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Estado</label>
                            <div class="pl-4">
                                <?php 
                                    switch ($status){
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
                <h3 class="border-bottom"><b>Detalles de la Tarea</b></h3>
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
                            <th class="text-center">Tipo de Tarea</th>
                            <th class="text-center">Duración Estimada (dd-mm-yy)</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                            $qry = $conn->query("SELECT * FROM `task_list` WHERE project_id = '{$project_id}' ORDER BY unix_timestamp(date_created) DESC");
                            while($row = $qry->fetch_assoc()):
                        ?>
                            <tr>
                                <td class="px-2 py-1 text-center"><?= $i++; ?></td>
                                <td class="px-2 py-1"><?= date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                                <td class="px-2 py-1"><?= $row['responsible'] ?></td>
                                <td class="px-2 py-1"><?= $row['task_type'] ?></td>
                                <td class="px-2 py-1 text-right"><?= $row['estimated_start_date'] . " - " . $row['estimated_end_date'] ?></td>
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
        $('#edit_task').click(function(){
            uni_modal("Actualizar Información de la Tarea","Task/manage_project.php?id=<?= isset($id) ? $id : '' ?>")
        })
        $('#delete_task').click(function(){
            _conf("¿Estás segur@ de eliminar esta tarea?","delete_task",["<?= isset($id) ? $id : '' ?>"])
        })
        $('#close_task').click(function(){
            _conf("¿Estás segur@ de cerrar esta tarea?","close_task",["<?= isset($id) ? $id : '' ?>"])
        })
        $('.view_data').click(function(){
            uni_modal("Detalles de la Tarea","Task/view_report.php?id="+$(this).attr('data-id'),"mid-large")
        })
        $('.table td, .table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
    })
    function close_task($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=close_task",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error:err=>{ console.log(err); alert_toast("Ocurrió un error.",'error'); end_loader(); },
            success:function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("Ocurrió un error.",'error');
                    end_loader();
                }
            }
        })
    }
    function delete_task($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_task",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error:err=>{ console.log(err); alert_toast("Ocurrió un error.",'error'); end_loader(); },
            success:function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.href="./?page=tasks";
                }else{
                    alert_toast("Ocurrió un error.",'error');
                    end_loader();
                }
            }
        })
    }
</script>
