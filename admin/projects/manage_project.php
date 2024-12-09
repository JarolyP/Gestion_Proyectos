<?php
require_once('../../config.php');
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `project_list` where id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k))
                $$k = $v;
        }
    }
}
?>
<style>
    img#cimg {
        height: 17vh;
        width: 25vw;
        object-fit: scale-down;
    }
</style>
<div class="container-fluid">
    <form action="" id="project-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <div class="form-group">
            <label for="name" class="control-label">Nombre del Proyecto</label>
            <input type="text" name="name" id="name" class="form-control form-control-border" placeholder="Ingresa Nombre del Proyecto" value="<?php echo isset($name) ? $name : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? ($description) : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="start_date" class="control-label">Fecha Est. Inicio</label>
            <input
                type="date"
                name="start_date"
                id="start_date"
                class="form-control form-control-border"
                value="<?php echo isset($start_date) ? $start_date : '' ?>"
                required
                onchange="validateDates()">
        </div>

        <div class="form-group">
            <label for="end_date" class="control-label">Fecha Est. Fin</label>
            <input
                type="date"
                name="end_date"
                id="end_date"
                class="form-control form-control-border"
                value="<?php echo isset($end_date) ? $end_date : '' ?>"
                required
                onchange="validateDates()">
        </div>

        <div class="form-group">
            <label for="responsible" class="control-label">Responsable</label>
            <input type="text" name="responsible" id="responsible" class="form-control form-control-border" placeholder="Ingresa Responsable" value="<?php echo isset($responsible) ? $responsible : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="status" class="control-label">Estado</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="Nuevo" <?php echo (isset($status) && $status == 'Nuevo') ? 'selected' : '' ?>>Nuevo</option>
                <option value="Planificación" <?php echo (isset($status) && $status == 'Planificación') ? 'selected' : '' ?>>Planificación</option>
                <option value="En Proceso" <?php echo (isset($status) && $status == 'En Proceso') ? 'selected' : '' ?>>En Proceso</option>
                <option value="Cancelado" <?php echo (isset($status) && $status == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                <option value="Terminado" <?php echo (isset($status) && $status == 'Terminado') ? 'selected' : '' ?>>Terminado</option>
            </select>
        </div>
    </form>
</div>

<script>
    function validateDates() {
        // Obtener los valores de las fechas
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        // Si ambos campos tienen valores
        if (startDate && endDate) {
            const startDateObj = new Date(startDate);
            const endDateObj = new Date(endDate);

            // Verificar que la fecha de inicio no sea mayor que la de fin
            if (startDateObj > endDateObj) {
                alert("La Fecha Est. Inicio no puede ser mayor que la Fecha Est. Fin.");
                document.getElementById('start_date').value = ""; // Limpiar campo
            }

            // Verificar que la fecha de fin no sea menor que la de inicio
            if (endDateObj < startDateObj) {
                alert("La Fecha Est. Fin no puede ser menor que la Fecha Est. Inicio.");
                document.getElementById('end_date').value = ""; // Limpiar campo
            }
        }
    }
    $(function() {
        $('#uni_modal #project-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
            el.addClass("pop-msg alert")
            el.hide()
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_project",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.reload();
                    } else if (!!resp.msg) {
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    } else {
                        el.addClass("alert-danger")
                        el.text("Se produjo un error debido a un motivo desconocido.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html,body,.modal').animate({
                        scrollTop: 0
                    }, 'fast')
                    end_loader();
                }
            })
        })
    })
</script>