<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">Reporte de Tiempo Por Tarea</h3>
    </div>
    <div class="card-body">
        <div class="callout border-primary">
            <fieldset>
                <legend>Filtro</legend>
                <form action="" id="filter" method="GET">
                    <div class="row align-items-end">
                        <div class="form-group col-md-3">
                            <label for="start_date" class="control-label">Fecha Inicio</label>
                            <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="end_date" class="control-label">Fecha Fin</label>
                            <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group col-md-3">
                            <button class="btn btn-primary btn-flat btn-sm" type="submit"><i class="fa fa-filter"></i> Filtrar</button>
                            <button class="btn btn-sm btn-flat btn-success" type="button" id="generate_chart"><i class="fa fa-chart-bar"></i> Generar Gráfica</button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
        <div id="chart-container" style="display:none;">
            <canvas id="taskChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

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
