<?php
if (isset($_GET['tid']))
    $tid = $_GET['tid'];
$task = "N/A";

function duration($start, $end)
{
    if (!$start || !$end) {
        return "00:00";
    }
    $start_time = strtotime($start);
    $end_time = strtotime($end);
    $dur = $end_time - $start_time;
    $hours = floor($dur / (60 * 60));
    $min = floor($dur / 60) % 60;
    return sprintf("%'.02d", $hours) . ":" . sprintf("%'.02d", $min);
}
?>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">Reporte de Tiempo Por Tarea</h3>
    </div>
    <div class="card-body">
        <div class="callout border-primary">
            <fieldset>
                <legend>Filtro</legend>
                <form action="" id="filter">
                    <div class="row align-items-end">
                        <div class="form-group col-md-4">
                            <label for="" class="control-label">Tarea</label>
                            <select name="tid" id="tid" class="form-control form-control-sm select2">
                                <?php
                                $tasks = $conn->query("SELECT id, task FROM `task_list` ORDER BY `task` ASC");
                                while ($row = $tasks->fetch_assoc()):
                                    if (!isset($tid)) {
                                        $tid = $row['id'];
                                    }
                                    if ($tid == $row['id'])
                                        $task = strtoupper($row['task']);
                                ?>
                                    <option value="<?= $row['id'] ?>" <?= isset($tid) && $tid == $row['id'] ? "selected" : "" ?>><?= strtoupper($row['task']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <button class="btn btn-primary btn-flat btn-sm"><i class="fa fa-filter"></i> Filtro</button>
                            <button class="btn btn-sm btn-flat btn-success" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                            <button class="btn btn-sm btn-flat btn-success" type="button" id="generate_chart"><i class="fa fa-chart-bar"></i> Generar Gráfica</button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
        <div id="outprint">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h4><b>Reporte de Tiempo Por Tarea</b></h4>
                        <h5><b><?= $task ?></b></h5>
                        <h5><b>Hasta</b></h5>
                        <h5><b><?= date("F d, Y") ?></b></h5>
                    </div>
                </div>
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="25%">
                        <col width="20%">
                        <col width="20%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-primary text-light">
                            <th>#</th>
                            <th>Tarea</th>
                            <th>Inicio Real</th>
                            <th>Fin Real</th>
                            <th>Duración</th>
                            <th>Progreso (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM `task_list` WHERE id = '{$tid}'");
                        while ($row = $qry->fetch_assoc()):
                            $duration = duration($row['actual_start_date'], $row['actual_end_date']);
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $row['task'] ?></td>
                                <td><?= $row['actual_start_date'] ?></td>
                                <td><?= $row['actual_end_date'] ?></td>
                                <td><?= $duration ?></td>
                                <td><?= $row['progress'] ?>%</td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($qry->num_rows <= 0): ?>
                            <tr>
                                <th colspan="6">
                                    <center>Sin Datos que Mostrar</center>
                                </th>
                            </tr>
                        <?php endif; ?>
                        <?php
                        if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                            $start_date = $_GET['start_date'];
                            $end_date = $_GET['end_date'];

                            $qry = $conn->query("SELECT task, SUM(TIMESTAMPDIFF(MINUTE, actual_start_date, actual_end_date)) as total_minutes 
                         FROM `task_list` 
                         WHERE DATE(actual_start_date) BETWEEN '{$start_date}' AND '{$end_date}'
                         GROUP BY task 
                         ORDER BY task ASC");
                            $data = [];
                            while ($row = $qry->fetch_assoc()) {
                                $data[] = [
                                    'task' => $row['task'],
                                    'minutes' => $row['total_minutes']
                                ];
                            }
                            echo json_encode($data);
                            exit;
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
        $('#generate_chart').click(function () {
            const start_date = $('#start_date').val();
            const end_date = $('#end_date').val();

            if (!start_date || !end_date) {
                alert('Por favor, selecciona un rango de fechas.');
                return;
            }

            $.ajax({
                url: '', // La misma página actual
                method: 'GET',
                data: { start_date, end_date },
                dataType: 'json',
                success: function (response) {
                    if (response.length === 0) {
                        alert('No hay datos para el rango seleccionado.');
                        return;
                    }

                    $('#chart-container').show();

                    const labels = response.map(item => item.task);
                    const data = response.map(item => item.minutes);

                    const ctx = document.getElementById('taskChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Minutos Trabajados',
                                data: data,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function (err) {
                    console.error(err);
                    alert('Hubo un error al generar la gráfica.');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        })
        $('#filter').submit(function(e) {
            e.preventDefault();
            location.href = './?page=reports/by_Task&' + $(this).serialize();
        })
        $('#print').click(function() {
            start_loader()
            var _p = $('#outprint').clone()
            var _h = $('head').clone()
            var _el = $('<div>')
            _h.find("title").text("Reporte de Tiempo Por Tarea")
            _p.find('tr.text-light').removeClass('text-light bg-gradient-primary')
            _el.append(_h)
            _el.append(_p)
            var nw = window.open("", "_blank", "width=1000,height=900,left=300,top=200")
            nw.document.write(_el.html())
            nw.document.close()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 300);
            }, 750);
        })
    })
</script>