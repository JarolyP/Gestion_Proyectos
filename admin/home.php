<h1>Bienvenid@ a <?php echo $_settings->info('name') ?> - Admin Panel</h1>
<hr class="border-info">
<?php
function duration($dur = 0){
    if($dur == 0){
        return "00:00";
    }
    $hours = floor($dur / (60 * 60));
    $min = floor($dur / (60)) - ($hours * 60);
    $dur = sprintf("%'.02d", $hours) . ":" . sprintf("%'.02d", $min);
    return $dur;
}
?>

    
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-tasks"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Nuevos Proyectos</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `project_list` where delete_flag=0 and `status` = 0 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
       <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-tasks"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Proyectos en Curso</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `project_list` where delete_flag=0 and `status` = 1 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-tasks"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Proyectos Cerrados</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `project_list` where delete_flag=0 and `status` = 2 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-user-tie"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total de Empleados</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `employee_list`")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-file-alt"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total de Reportes</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `report_list`")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- Proyectos Pendientes -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-hourglass-start"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Proyectos Pendientes</span>
                <span class="info-box-number text-right">
                    <?php 
                        echo $conn->query("SELECT * FROM `project_list` WHERE delete_flag=0 AND `status` = 3 ")->num_rows;
                    ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Proyectos Terminados -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-check-circle"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Proyectos Terminados</span>
                <span class="info-box-number text-right">
                    <?php 
                        echo $conn->query("SELECT * FROM `project_list` WHERE delete_flag=0 AND `status` = 4 ")->num_rows;
                    ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Proyectos Cancelados -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-ban"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Proyectos Cancelados</span>
                <span class="info-box-number text-right">
                    <?php 
                        echo $conn->query("SELECT * FROM `project_list` WHERE delete_flag=0 AND `status` = 5 ")->num_rows;
                    ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Proyectos Completados -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-clipboard-check"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Proyectos Completados</span>
                <span class="info-box-number text-right">
                    <?php 
                        echo $conn->query("SELECT * FROM `project_list` WHERE delete_flag=0 AND `status` = 6 ")->num_rows;
                    ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Proyectos Planificados -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-calendar-alt"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Proyectos Planificados</span>
                <span class="info-box-number text-right">
                    <?php 
                        echo $conn->query("SELECT * FROM `project_list` WHERE delete_flag=0 AND `status` = 7 ")->num_rows;
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>


</div>
<hr> 
