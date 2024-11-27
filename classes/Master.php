<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_project(){
    extract($_POST);
    $data = "";

    // Depuración: Verificar los datos recibidos
    error_log(print_r($_POST, true)); // Log de los datos recibidos

    foreach($_POST as $k => $v){
        if(!in_array($k, array('id'))){
            if(!is_numeric($v))
                $v = $this->conn->real_escape_string($v); // Escape de los valores
            if(!empty($data)) $data .= ",";
            $data .= " `{$k}`='{$v}' ";
        }
    }

    // Verificar si el proyecto ya existe
    $check = $this->conn->query("SELECT * FROM `project_list` WHERE `title` = '{$title}' ".(is_numeric($id) && $id > 0 ? " AND id != '{$id}'" : "")." ")->num_rows;
    if($check > 0){
        $resp['status'] = 'failed';
        $resp['msg'] = 'El proyecto ya existe.';
    } else {
        // Crear o actualizar el registro
        if(empty($id)){
            $sql = "INSERT INTO `project_list` SET {$data}";
        } else {
            $sql = "UPDATE `project_list` SET {$data} WHERE id = '{$id}'";
        }

        // Depuración: Verifica la consulta SQL
        error_log("Consulta SQL: " . $sql);

        // Ejecutar la consulta
        $save = $this->conn->query($sql);
        if($save){
            $rid = !empty($id) ? $id : $this->conn->insert_id; // Obtener ID generado si es nuevo
            $resp['id'] = $rid;
            $resp['status'] = 'success';
            $resp['msg'] = empty($id) ? "Proyecto agregado exitosamente." : "Proyecto actualizado exitosamente.";
        } else {
            // Si ocurre un error, mostrar detalles del error
            $resp['status'] = 'failed';
            $resp['msg'] = "Ocurrió un error al guardar los datos.";
            $resp['error'] = $this->conn->error;  // Detalles del error de la consulta
        }
    }

    // Agregar mensaje flash si se guarda correctamente
    if($resp['status'] == 'success')
        $this->settings->set_flashdata('success', $resp['msg']);

    return json_encode($resp); // Devolver respuesta en formato JSON
}

	
	function delete_project(){
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM `report_list` where project_id ='{$id}'")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['mesg'] = 'No se puede eliminar este proyecto porque ya tiene un informe listado.';
		}else{
			$del = $this->conn->query("UPDATE `project_list` set delete_flag = 1 where id = '{$id}'");
			if($del){
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success',"Proyect ha sido eliminado exitósamente.");
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = $this->conn->error;
			}
		}
		return json_encode($resp);
	}
	function close_project(){
		extract($_POST);
		
		$update = $this->conn->query("UPDATE `project_list` set status = 2 where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Proyecto ha sido cerrado exitósamente.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_work_type(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `work_type_list` set {$data} ";
		}else{
			$sql = "UPDATE `work_type_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `work_type_list` where `name` = '{$name}' ".(is_numeric($id) && $id > 0 ? " and id != '{$id}'" : "")." ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = 'Este tipo de trabajo ya existe';
			
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Este tipo de trabajo ha sido agregado exitósamente";
				else
					$resp['msg'] = "La información de este tipo de trabajo ha sido actualizada exitósamente";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "Ocurrió un error.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_work_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `work_type_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Este tipo de trabajo ha sido eliminado exitósamente.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_report(){
		$_POST['description'] = htmlentities($_POST['description']);
		$_POST['employee_id'] = $this->settings->userdata('id');
		$duration = strtotime($_POST['datetime_to']) - strtotime($_POST['datetime_from']);
		$_POST['duration'] = $duration;
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `report_list` set {$data} ";
		}else{
			$sql = "UPDATE `report_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['id'] = $rid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = " Este reporte ha sido agregado exitósamente.";
			else
				$resp['msg'] = " Este reporte ha sido actualizado exitósamente.";

			$this->conn->query("UPDATE `project_list` set `status` ='1' where id = '{$project_id}' ");
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "Ocurrió un error.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_report(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `report_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Reporte ha sido eliminado exitósamente");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_task(){
		extract($_POST);
		$data = "";
		
		// Depuración: Verifica los datos recibidos
		error_log(print_r($_POST, true)); // Log de los datos recibidos
	
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v); // Escape de los valores
				if(!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
	
		if(empty($id)){
			$sql = "INSERT INTO `task_list` SET {$data}";
		}else{
			$sql = "UPDATE `task_list` SET {$data} WHERE id = '{$id}'";
		}
	
		// Depuración: Verifica la consulta SQL
		error_log($sql); // Log de la consulta SQL
	
		$save = $this->conn->query($sql);
	
		if($save){
			$resp['status'] = 'success';
			$resp['msg'] = empty($id) ? "Tarea agregada exitosamente." : "Tarea actualizada exitosamente.";
		}else{
			// Si hay error, loguear el error de la base de datos
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			error_log("Error en la consulta: " . $this->conn->error); // Log de errores de MySQL
		}
		
		return json_encode($resp);
	}
	function delete_task(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `task_list` WHERE id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$resp['msg'] = "Tarea eliminada exitosamente.";
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_progress(){
		extract($_POST);
		$data = "";
	
		// Se obtiene la información de los campos enviados en POST
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'description')
					$v = htmlentities(str_replace("'", "&#x2019;", $v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
	
		// Se calcula la duración del progreso
		$dur = abs(strtotime($datetime_to) - strtotime($datetime_from)); // Calcula el tiempo en segundos
		$dur = $dur / (60 * 60); // Convertimos a horas
		$data .= ", duration='$dur' ";
	
		// Si no se pasa un ID, se crea un nuevo registro, si no, se actualiza el existente
		if(empty($id)){
			$data .= ", employee_id={$_SESSION['login_id']} ";
	
			$save = $this->db->query("INSERT INTO report_list SET $data");
		}else{
			$save = $this->db->query("UPDATE report_list SET $data WHERE id = $id");
		}
	
		if($save){
			return 1; // El guardado fue exitoso
		}
	}
	function delete_progress(){
		extract($_POST);
		// Elimina el progreso según el ID recibido
		$delete = $this->db->query("DELETE FROM report_list WHERE id = $id");
		
		if($delete){
			return 1; // El progreso fue eliminado exitosamente
		}
	}
	
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_project':
		echo $Master->save_project();
	break;
	case 'save_task':
		echo $Master->save_task();
	break;
	case 'delete_task':
		echo $Master->delete_task();
	break;
	case 'delete_project':
		echo $Master->delete_project();
	break;
	case 'close_project':
		echo $Master->close_project();
	break;
	case 'save_work_type':
		echo $Master->save_work_type();
	break;
	case 'delete_work_type':
		echo $Master->delete_work_type();
	break;
	case 'save_report':
		echo $Master->save_report();
	break;
	case 'delete_report':
		echo $Master->delete_report();
	break;
	default:
		// echo $sysset->index();
		break;
}