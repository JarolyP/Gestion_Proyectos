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
            <label for="start_date" class="control-label">Fecha Estimada de Inicio</label>
            <input type="date" name="estimated_start_date" id="estimated_start_date" class="form-control form-control-border" required>
        </div>

        <div class="form-group">
            <label for="end_date" class="control-label">Fecha Estimada de Fin</label>
            <input type="date" name="estimated_end_date" id="estimated_end_date" class="form-control form-control-border" required>
        </div>

        <div class="form-group">
            <label for="responsable" class="control-label">Responsable</label>
            <input type="text" name="responsable" id="responsable" class="form-control form-control-border" placeholder="Ingresa el Responsable" required>
        </div>

        <div class="form-group">
            <label for="status" class="control-label">Estado del Proyecto</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="Pendiente">Pendiente</option>
                <option value="En Proceso">En Proceso</option>
                <option value="Cancelado">Cancelado</option>
                <option value="Terminado">Terminado</option>
            </select>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('#project-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert").hide();
            start_loader(); // Asegúrate de que esta función esté definida en tu entorno

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_project",
                data: new FormData(this), // Corrección aquí
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err) {
                    console.error(err);
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        alert_toast(resp.msg, 'success'); // Muestra un mensaje de éxito
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        console.log(resp); // Muestra todos los datos de respuesta en la consola
                        el.addClass("alert-danger")
                        el.text(resp.msg + (resp.err ? " [" + resp.err + "]" : "")); // Incluye errores si existen
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html,body,.modal').animate({
                        scrollTop: 0
                    }, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>