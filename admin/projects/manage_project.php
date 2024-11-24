<?php
require_once('../../config.php');
<<<<<<< HEAD
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `project_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
=======
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `project_list` where id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k))
                $$k = $v;
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
        }
    }
}
?>
<style>
<<<<<<< HEAD
	img#cimg{
		height: 17vh;
		width: 25vw;
		object-fit: scale-down;
	}
=======
    img#cimg {
        height: 17vh;
        width: 25vw;
        object-fit: scale-down;
    }
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
</style>
<div class="container-fluid">
    <form action="" id="project-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <div class="form-group">
<<<<<<< HEAD
            <label for="title" class="control-label">Título del Proyecto</label>
            <input type="text" name="title" id="title" class="form-control form-control-border" placeholder="Ingresa Título del Proyecto" value="<?php echo isset($title) ? $title : '' ?>" required>
=======
            <label for="name" class="control-label">Nombre del Proyecto</label>
            <input type="text" name="name" id="name" class="form-control form-control-border" placeholder="Ingresa Nombre del Proyecto" value="<?php echo isset($name) ? $name : '' ?>" required>
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
        </div>

        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
<<<<<<< HEAD
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : '' ?></textarea>
=======
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? ($description) : '' ?></textarea>
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
        </div>

        <div class="form-group">
            <label for="start_date" class="control-label">Fecha Estimada de Inicio</label>
<<<<<<< HEAD
            <input type="date" name="start_date" id="start_date" class="form-control form-control-border" value="<?php echo isset($start_date) ? $start_date : '' ?>">
=======
            <input type="date" name="estimated_start_date" id="estimated_start_date" class="form-control form-control-border" required>
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
        </div>

        <div class="form-group">
            <label for="end_date" class="control-label">Fecha Estimada de Fin</label>
<<<<<<< HEAD
            <input type="date" name="end_date" id="end_date" class="form-control form-control-border" value="<?php echo isset($end_date) ? $end_date : '' ?>">
        </div>

        <div class="form-group">
            <label for="responsible" class="control-label">Responsable del Proyecto</label>
            <input type="text" name="responsible" id="responsible" class="form-control form-control-border" placeholder="Ingresa Responsable del Proyecto" value="<?php echo isset($responsible) ? $responsible : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="status" class="control-label">Estado</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="Nuevo" <?php echo (isset($status) && $status == 'Nuevo') ? 'selected' : '' ?>>Nuevo</option>
                <option value="En Proceso" <?php echo (isset($status) && $status == 'En Proceso') ? 'selected' : '' ?>>En Proceso</option>
                <option value="Cancelado" <?php echo (isset($status) && $status == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                <option value="Terminado" <?php echo (isset($status) && $status == 'Terminado') ? 'selected' : '' ?>>Terminado</option>
                <option value="Pendiente" <?php echo (isset($status) && $status == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                <option value="Cerrado" <?php echo (isset($status) && $status == 'Cerrado') ? 'selected' : '' ?>>Cerrado</option>
=======
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
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
            </select>
        </div>
    </form>
</div>
<<<<<<< HEAD

<script>
    $(function() {
        $('#uni_modal #project-form').submit(function(e) {
            e.preventDefault(); // Prevenir el comportamiento predeterminado del formulario
            var _this = $(this);
            $('.pop-msg').remove(); // Eliminar mensajes previos de error o éxito

            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();

            start_loader(); // Mostrar loader durante el proceso

            // Usar FormData para enviar datos del formulario con soporte de archivos
            var formData = new FormData(this);

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_project", // Ruta del backend
                data: formData,
                cache: false, // No almacenar en caché la solicitud
                contentType: false, // No configurar manualmente el encabezado
                processData: false, // Evitar transformar los datos
                method: 'POST', // Método HTTP
                dataType: 'json', // Respuesta esperada del servidor
                error: function(err) {
                    console.log("Error de AJAX:", err); // Mostrar error en la consola
                    alert_toast("Ocurrió un error. Revisa la consola para más detalles.", 'error');
                    end_loader(); // Ocultar loader
                },
                success: function(resp) {
                    // Evaluar el estado de la respuesta
                    if (resp.status === 'success') {
                        alert_toast("Proyecto guardado con éxito.", 'success');
                        setTimeout(function() {
                            location.reload(); // Recargar la página
                        }, 1500); // Retraso de 1.5 segundos
                    } else if (resp.msg) {
                        // Mensaje de error personalizado del servidor
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        _this.prepend(el);
                    } else {
                        // Mensaje de error genérico
                        el.addClass("alert-danger");
                        el.text("Se produjo un error debido a un motivo desconocido.");
                        _this.prepend(el);
                    }
                    el.show('slow'); // Mostrar el mensaje de error
                    $('html,body,.modal').animate({ scrollTop: 0 }, 'fast'); // Desplazar al inicio del modal
                    end_loader(); // Ocultar loader
=======
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
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
                }
            });
        });
    });
<<<<<<< HEAD
</script>
=======
</script>
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
