<?php
require_once('./../config.php');
$project_id = isset($_GET['project_id']) ? $_GET['project_id'] : "";
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `task_list` WHERE id = '{$_GET['id']}'");
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
    #uni_modal .modal-footer {
        display: block;
    }
</style>
<div class="container-fluid">
    <form action="" id="task-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="project_id" value="<?php echo isset($project_id) ? $project_id : '' ?>">
        <div class="form-group">
            <label for="task" class="control-label">Tarea</label>
            <input type="text" name="task" id="task" class="form-control form-control-sm rounded-0" value="<?php echo isset($task) ? $task : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="responsible" class="control-label">Responsable</label>
            <input type="text" name="responsible" id="responsible" class="form-control form-control-sm rounded-0" value="<?php echo isset($responsible) ? $responsible : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="datetime_from" class="control-label">Fecha de Inicio Estimada</label>
            <input type="date" name="estimated_start_date" id="estimated_start_date" class="form-control form-control-sm rounded-0" value="<?php echo isset($estimated_start_date) ? $estimated_start_date : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="datetime_to" class="control-label">Fecha de Fin Estimada</label>
            <input type="date" name="estimated_end_date" id="estimated_end_date" class="form-control form-control-sm rounded-0" value="<?php echo isset($estimated_end_date) ? $estimated_end_date : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? html_entity_decode($description) : '' ?></textarea>
        </div>
    </form>
</div>
<script>
    $(function () {
        $('#uni_modal').on('shown.bs.modal', function () {
            $('#description').summernote({
                placeholder: "Escribe la descripción de la tarea aquí",
                height: '20vh',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['undo', 'redo']]
                ]
            });
        });

        $('#uni_modal #task-form').submit(function (e) {
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_task",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("Ocurrió un error.", 'error');
                    end_loader();
                },
                success: function (resp) {
                    if (resp.status == 'success') {
                        location.href = _base_url_ + "?page=task/view_task&id=<?= isset($project_id) ? $project_id : '' ?>";
                    } else if (!!resp.msg) {
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        _this.prepend(el);
                    } else {
                        el.addClass("alert-danger");
                        el.text("Se produjo un error debido a un motivo desconocido.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({ scrollTop: 0 }, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>
