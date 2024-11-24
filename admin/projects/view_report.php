<?php
require_once('./../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT r.*, w.name as work_type, e.code as ecode, CONCAT(e.firstname,' ',e.middlename,' ', e.lastname) as fullname,p.status as project_status FROM `report_list` r inner join `work_type_list` w on r.work_type_id = w.id inner join employee_list e on r.employee_id = e.id inner join project_list p on r.project_id = p.id where r.id = '{$_GET['id']}'");
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
<style>
    #uni_modal .modal-footer{
        display:none;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <dl>
                <dt class="text-muted">Tarea</dt>
                <dd class='pl-4 fs-4'><?= isset($task) ? $task : 'N/A' ?></dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <dl>
                <dt class="text-muted">Descripción</dt>
                <dd class='pl-4 fs-4'><?= isset($description) ? html_entity_decode($description) : 'N/A' ?></dd>
                <dt class="text-muted">Fecha Estimada de Inicio</dt>
                <dd class='pl-4 fs-4'><?= isset($estimated_start_date) ? date("M d, Y", strtotime($estimated_start_date)) : 'N/A' ?></dd>
                <dt class="text-muted">Fecha Real de Inicio</dt>
                <dd class='pl-4 fs-4'><?= isset($actual_start_date) ? date("M d, Y", strtotime($actual_start_date)) : 'N/A' ?></dd>
                <dt class="text-muted">Responsable</dt>
                <dd class='pl-4 fs-4'><?= isset($responsible) ? $responsible : 'N/A' ?></dd>
            </dl>
        </div>
        <div class="col-md-6">
            <dl>
                <dt class="text-muted">Fecha Estimada de Finalización</dt>
                <dd class='pl-4 fs-4'><?= isset($estimated_end_date) ? date("M d, Y", strtotime($estimated_end_date)) : 'N/A' ?></dd>
                <dt class="text-muted">Fecha Real de Finalización</dt>
                <dd class='pl-4 fs-4'><?= isset($actual_end_date) ? date("M d, Y", strtotime($actual_end_date)) : 'N/A' ?></dd>
                <dt class="text-muted">Progreso</dt>
                <dd class='pl-4 fs-4'><?= isset($progress) ? $progress . "%" : 'N/A' ?></dd>
                <dt class="text-muted">Estado</dt>
                <dd class='pl-4 fs-4 fw-bold'><?= isset($status) ? $status : 'N/A' ?></dd>
                <dt class="text-muted">Tipo de Tarea</dt>
                <dd class='pl-4 fs-4'><?= isset($task_type) ? $task_type : 'N/A' ?></dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <dl>
                <dt class="text-muted">Fecha de Creación</dt>
                <dd class='pl-4 fs-4'><?= isset($date_created) ? date("M d, Y h:i A", strtotime($date_created)) : 'N/A' ?></dd>
            </dl>
        </div>
    </div>
    <div class="text-right">
        <?php if(isset($project_status) && $project_status != 2): ?>
        <button class="btn btn-primary btn-sm btn-flat" type="button" id="edit_report"><i class="fa fa-edit"></i> Editar</button>
        <button class="btn btn-danger btn-sm btn-flat" type="button" id="delete_report"><i class="fa fa-trash"></i> Eliminar</button>
        <?php endif; ?>
        <button class="btn btn-dark btn-sm btn-flat" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
    </div>
</div>

<script>
    $(function(){
        $('#edit_report').click(function(){
            setTimeout(() => {
                uni_modal("Editar Reporte","projects/manage_report.php?id=<?= isset($id) ? $id : '' ?>",'mid-large')
            }, 500);
            $('.modal').modal('hide')
        })
        $('#delete_report').click(function(){
			_conf("¿Estás segur@ de eliminar este informe de forma permanente?","delete_report",["<?= isset($id) ? $id : '' ?>"])
            $('.modal').modal('hide')
		})
        
    })
    function delete_report($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_report",
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
</script>
