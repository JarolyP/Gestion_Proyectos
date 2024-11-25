<?php
require_once('../../config.php');

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

// Obtener empleados (staff) y proyectos para asignarlos
$staff_sql = "SELECT id, name FROM employee_list";
$staff_result = $conn->query($staff_sql);

$project_sql = "SELECT id, project_name FROM project_list";
$project_result = $conn->query($project_sql);
?>
<style>
    img#cimg{
        height: 17vh;
        width: 20vw;
        object-fit: scale-down;
    }
</style>
<div class="container-fluid">
    <form action="" id="task-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <div class="form-group">
            <label for="task" class="control-label">Título de la Tarea</label>
            <input type="text" name="task" id="task" class="form-control form-control-border" placeholder="Ingresa Título de la Tarea" value="<?php echo isset($task) ? $task : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="estimated_start_date" class="control-label">Fecha Estimada de Inicio</label>
            <input type="date" name="estimated_start_date" id="estimated_start_date" class="form-control form-control-border" value="<?php echo isset($estimated_start_date) ? $estimated_start_date : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="estimated_end_date" class="control-label">Fecha Estimada de Fin</label>
            <input type="date" name="estimated_end_date" id="estimated_end_date" class="form-control form-control-border" value="<?php echo isset($estimated_end_date) ? $estimated_end_date : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="actual_start_date" class="control-label">Fecha Real de Inicio</label>
            <input type="date" name="actual_start_date" id="actual_start_date" class="form-control form-control-border" value="<?php echo isset($actual_start_date) ? $actual_start_date : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="actual_end_date" class="control-label">Fecha Real de Fin</label>
            <input type="date" name="actual_end_date" id="actual_end_date" class="form-control form-control-border" value="<?php echo isset($actual_end_date) ? $actual_end_date : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="responsible" class="control-label">Responsable de la Tarea</label>
            <select name="responsible" id="responsible" class="form-control form-control-border" required>
                <?php while($staff = $staff_result->fetch_assoc()) { ?>
                    <option value="<?= $staff['id'] ?>" <?= (isset($responsible) && $responsible == $staff['id']) ? 'selected' : '' ?>>
                        <?= $staff['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar Tarea</button>
    </form>
</div>

<script>
// Validación de fechas
document.getElementById("actual_start_date").addEventListener("focus", function() {
    let estimated_start_date = document.getElementById("estimated_start_date").value;
    document.getElementById("actual_start_date").setAttribute("min", estimated_start_date);
});

document.getElementById("actual_end_date").addEventListener("focus", function() {
    let estimated_end_date = document.getElementById("estimated_end_date").value;
    document.getElementById("actual_end_date").setAttribute("min", estimated_end_date);
});

// Deshabilitar fechas anteriores a las estimadas
document.getElementById("actual_start_date").setAttribute("min", document.getElementById("estimated_start_date").value);
document.getElementById("actual_end_date").setAttribute("min", document.getElementById("estimated_end_date").value);

// Manejo de envíos del formulario
$('#task-form').submit(function(e) {
    e.preventDefault();
    start_load(); // Función para mostrar un cargador
    $.ajax({
        url: '/classes/Logic_task.php?action=save_task', // URL ajustada para la acción correcta
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(resp) {
            try {
                let jsonResponse = JSON.parse(resp);
                if (jsonResponse.status === 'success') {
                    alert_toast(jsonResponse.msg, "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast(jsonResponse.msg || "Ocurrió un error inesperado", "error");
                    console.error(jsonResponse.err);
                }
            } catch (err) {
                console.error("Respuesta inválida del servidor:", resp);
            }
        },
        error: function(err) {
            console.error("Error AJAX:", err);
            alert_toast("Ocurrió un error al guardar la tarea.", "error");
        }
    });
});
</script>
