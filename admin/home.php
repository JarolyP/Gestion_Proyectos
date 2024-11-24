<h1>Bienvenid@ a <?php echo $_settings->info('name') ?> - Admin Panel</h1>
<hr class="border-info">
<?php
function duration($dur = 0){
    if($dur == 0){
        return "00:00";
    }
    $hours = floor($dur / (60 * 60));
    $min = floor($dur / (60)) - ($hours*60);
    $dur = sprintf("%'.02d",$hours).":".sprintf("%'.02d",$min);
    return $dur;
}
?>
<div class="row">
        <div class="col-md-8">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Progreso del Proyecto</b>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0 table-hover">
                <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup>
                <thead>
                  <th>Nº</th>
                  <th>Proyecto</th>
                  <th>Progreso</th>
                  <th>Estado</th>
                  <th></th>
                </thead>
                <tbody>
                <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['name']) ?>
                          </a>
                          <br>
                          <small>
                              Due: <?php echo date("Y-m-d",strtotime($row['end_date'])) ?>
                          </small>
                      </td>
                      <td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                              </div>
                          </div>
                          <small>
                              <?php echo $prog ?>% Completado
                          </small>
                      </td>
                      <td class="project-state">
                          <?php
                            if($stat[$row['status']] =='Pendiente'){
                              echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Inicio'){
                              echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='En Progreso'){
                              echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='En Espera'){
                              echo "<span class='badge badge-warning'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Retrazado'){
                              echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Finalizado'){
                              echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                            }
                          ?>
                      </td>
                      <td>
                        <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>">
                              <i class="fas fa-folder">
                              </i>
                              Ver
                        </a>
                      </td>
                  </tr>
                  </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="row">
          <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-success shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM project_list $where")->num_rows; ?></h3>

                <p>Total de Proyectos</p>
              </div>
              <div class="icon">
                <i class="fa fa-layer-group"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-success shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT t.*,p.name as pname,p.start_date,p.status as pstatus, p.end_date,p.id as pid FROM task_list t inner join project_list p on p.id = t.project_id $where2")->num_rows; ?></h3>
                <p>Total de Tareas</p>
              </div>
              <div class="icon">
                <i class="fa fa-tasks"></i>
              </div>
            </div>
          </div>
      </div>
        </div>
      </div>
<!-- <div class="row">
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
            <!-- /.info-box-content 
        </div>
       <!-- /.info-box
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
            <!-- /.info-box-content 
        </div>
        <!-- /.info-box 
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
            <!-- /.info-box-content 
        </div>
        <!-- /.info-box 
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
            <!-- /.info-box-content 
        </div>
        <!-- /.info-box 
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
            <!-- /.info-box-content 
        </div>
        <!-- /.info-box 
    </div>
    <!-- Proyectos Pendientes 
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

    <!-- Proyectos Terminados 
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

    <!-- Proyectos Cancelados 
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

    <!-- Proyectos Completados 
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

    <!-- Proyectos Planificados 
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
<hr> -->
