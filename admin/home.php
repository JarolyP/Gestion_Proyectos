<!-- Info boxes -->
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h1>Bienvenid@ a <?php echo $_settings->info('name') ?> - Admin Panel</h1>
    </div>
  </div>
</div>
<hr>

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
              <?php
              $i = 1;
              $stat = array("Nuevo", "En Proceso", "Cancelado", "Terminado", "Pendiente", "Cerrado");

              $qry = $conn->query("SELECT * FROM project_list $where ORDER BY name ASC");
              while ($row = $qry->fetch_assoc()):
                $prog = 0;
                $tprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']}")->num_rows;
                $cprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']} AND status = 3")->num_rows;
                $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                $prog = $prog > 0 ? number_format($prog, 2) : $prog;
              ?>
                <tr>
                  <td><?php echo $i++ ?></td>
                  <td>
                    <a><?php echo ucwords($row['name']) ?></a><br>
                    <small>Due: <?php echo date("Y-m-d", strtotime($row['end_date'])) ?></small>
                  </td>
                  <td class="project_progress">
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $prog ?>%">
                      </div>
                    </div>
                    <small><?php echo $prog ?>% Completado</small>
                  </td>
                  <td class="project-state">
                    <span class="badge badge-info"><?php echo $row['status'] ?></span>
                  </td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="./projects/manage_project.php echo $row['id'] ?>">
                      <i class="fas fa-folder"></i> Ver
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-12">
        <div class="small-box bg-primary shadow-sm border">
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
        <div class="small-box bg-primary shadow-sm border">
          <div class="inner">
            <h3><?php echo $conn->query("SELECT t.*, p.name as pname FROM task_list t INNER JOIN project_list p ON p.id = t.project_id $where2")->num_rows; ?></h3>
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
</div>
</div>