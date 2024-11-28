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
            <label for="title" class="control-label">Título del Proyecto</label>
            <input type="text" name="title" id="title" class="form-control form-control-border" placeholder="Ingresa Título del Proyecto" value="<?php echo isset($title) ? $title : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="responsible" class="control-label">Responsable del Proyecto</label>
            <select name="responsible" id="responsible" class="form-control form-control-border" required>
                <option value="">Selecciona un responsable</option>
                <?php
                // Obtener los usuarios de la tabla 'users' que son staff (type = 2) y están activos (status = 1)
                $staff_query = $conn->query("SELECT id, firstname, lastname FROM users WHERE type = 2 AND status = 1");
                while ($staff = $staff_query->fetch_array()):
                ?>
                    <option value="<?php echo $staff['id']; ?>" <?php echo (isset($responsible) && $responsible == $staff['id']) ? 'selected' : '' ?>>
                        <?php echo $staff['firstname'] . ' ' . $staff['lastname']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="start_date" class="control-label">Fecha Estimada de Inicio</label>
            <input type="date" name="start_date" id="start_date" class="form-control form-control-border"
                value="<?php echo isset($start_date) ? $start_date : '' ?>" onchange="validateRealDatesRange(); validateEndDate(); updateStatus();">
        </div>

        <div class="form-group">
            <label for="end_date" class="control-label">Fecha Estimada de Fin</label>
            <input type="date" name="end_date" id="end_date" class="form-control form-control-border"
                value="<?php echo isset($end_date) ? $end_date : '' ?>" onchange="validateRealDatesRange(); validateEndDate();  updateStatus();">
        </div>

        <div class="form-group">
            <label for="start_date_real" class="control-label">Fecha de Inicio Real</label>
            <input type="date" name="start_date_real" id="start_date_real" class="form-control form-control-border"
                value="<?php echo isset($start_date_real) ? $start_date_real : '' ?>" onchange="toggleRealDates1(); validateRealDates(); updateStatus();">
        </div>

        <div class="form-group">
            <label for="end_date_real" class="control-label">Fecha de Fin Real</label>
            <input type="date" name="end_date_real" id="end_date_real" class="form-control form-control-border"
                value="<?php echo isset($end_date_real) ? $end_date_real : '' ?>" onchange="toggleRealDates1(); validateRealDates(); updateStatus(); ">
        </div>

        <div class="form-group">
            <label for="status" class="control-label">Estado</label>
            <input type="text" name="status" id="status_text" class="form-control form-control-border" placeholder="Estado" value="<?php echo isset($status) ? $status : 'Estado'; ?>" readonly>
        </div>
    </form>
</div>

<script>
    function updateStatus() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const status = document.getElementById('status_text'); // Cambiado a status_text

        // Si ambas fechas estimadas son seleccionadas, cambia el estado a 'Nuevo'
        if (startDate && endDate) {
            status.value = "En Planificación"; // Estado "Nuevo" si ambas fechas están completas
        } else {
            status.value = "Nuevo"; // Estado "En Planificación" si alguna fecha falta
        }
    }

    function validateRealDatesRange() {
    const startDateEstimated = document.getElementById('start_date').value;
    const endDateEstimated = document.getElementById('end_date').value;
    const startDateReal = document.getElementById('start_date_real').value;
    const endDateReal = document.getElementById('end_date_real').value;

    if (startDateEstimated && endDateEstimated) {
        const startEstimated = new Date(startDateEstimated);
        const endEstimated = new Date(endDateEstimated);

        // Validar fecha de inicio real
        if (startDateReal) {
            const startReal = new Date(startDateReal);
            if (startReal >= startEstimated && startReal <= endEstimated) {
                alert('La fecha de inicio real no puede estar dentro del rango de las fechas estimadas.');
                document.getElementById('start_date_real').value = ''; // Restablece el campo
                return false;
            }
        }

        // Validar fecha de fin real
        if (endDateReal) {
            const endReal = new Date(endDateReal);
            if (endReal >= startEstimated && endReal <= endEstimated) {
                alert('La fecha de fin real no puede estar dentro del rango de las fechas estimadas.');
                document.getElementById('end_date_real').value = ''; // Restablece el campo
                return false;
            }
        }
    }

    return true; // Si pasa las validaciones
}

// Llama a esta función cuando cambien las fechas reales
document.getElementById('start_date_real').addEventListener('change', validateRealDatesRange);
document.getElementById('end_date_real').addEventListener('change', validateRealDatesRange);


    function toggleRealDates1() {
        const startDateEstimated = document.getElementById('start_date');
        const endDateEstimated = document.getElementById('end_date');

        const startDateReal = document.getElementById('start_date_real').value;
        const endDateReal = document.getElementById('end_date_real').value;

        // Si se ha seleccionado una fecha estimada de inicio o fin, deshabilitamos las fechas reales
        if (startDateReal || endDateReal) {
            startDateEstimated.disabled = true;
            endDateEstimated.disabled = true;
        } else {
            startDateEstimated.disabled = false;
            endDateEstimated.disabled = false;
        }
    }

    function updateStatus1() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const status = document.getElementById('status');

        // Si ambas fechas reales son seleccionadas, cambia el estado a 'Nuevo'
        if (startDate && endDate) {
            status.value = "Nuevo";
        }
    }

    function updateStatus2() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const status = document.getElementById('status');

        if (startDate && endDate) {
            status.value = "En Planificación";
        } else {
            status.value = "Nuevo";
        }
    }

    function validateRealDates() {
        const startDateReal = document.getElementById('start_date_real').value;
        const endDateReal = document.getElementById('end_date_real').value;

        if (startDateReal && endDateReal) {
            if (new Date(endDateReal) < new Date(startDateReal)) {
                alert('La fecha de fin real no puede ser menor que la fecha de inicio real.');
                document.getElementById('end_date_real').value = ''; // Restablece el campo de fecha de fin real
            }
        }
    }
    // Valida que la fecha de fin no sea menor a la de inicio
    function validateEndDate() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (startDate && endDate) {
            if (new Date(endDate) < new Date(startDate)) {
                alert('La fecha de fin no puede ser menor que la fecha de inicio.');
                document.getElementById('end_date').value = ''; // Restablece el campo de fecha de fin
            }
        }
    }
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
                    $('html,body,.modal').animate({
                        scrollTop: 0
                    }, 'fast'); // Desplazar al inicio del modal
                    end_loader(); // Ocultar loader
                }
            });
        });
    });
</script>