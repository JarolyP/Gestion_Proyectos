<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreso de Empleados</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <button id="generateChart">Generar Gráfico</button>
    <canvas id="progressChart" width="400" height="400"></canvas>

    <script>
        document.getElementById('generateChart').addEventListener('click', function() {
    // Aquí se supone que los datos provienen de tu base de datos
    // Este es solo un ejemplo estático de cómo se verían esos datos
    const employeeData = [
        { name: 'Juan', progress: 75 },
        { name: 'Jaroly', progress: 50 }
    ];

    // Extraer nombres y progresos de los empleados
    const labels = employeeData.map(employee => employee.name);
    const progressData = employeeData.map(employee => employee.progress);

    // Crear el gráfico
    const ctx = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(ctx, {
        type: 'pie', // Tipo de gráfico
        data: {
            labels: labels,
            datasets: [{
                label: 'Progreso de Tareas',
                data: progressData,
                backgroundColor: ['#FF5733', '#33FF57'], // Puedes agregar más colores
                borderColor: ['#FF5733', '#33FF57'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                        }
                    }
                }
            }
        }
    });
});
    </script>
</body>
</html>