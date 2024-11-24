<?php
require_once('../config.php');
Class Logic_task extends DBConnection {
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
	function save_task(){
		extract($_POST);
		$data = "";
	
		// Construir datos dinámicamente desde $_POST
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id'))){ // Excluir `id` porque se maneja por separado
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v); // Escapar valores no numéricos
				if(!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
	
		// Crear o actualizar la tarea
		if(empty($id)){
			$sql = "INSERT INTO `task_list` SET {$data}";
		} else {
			$sql = "UPDATE `task_list` SET {$data} WHERE id = '{$id}'";
		}
	
		// Ejecutar la consulta
		$save = $this->conn->query($sql);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id; // Obtener ID generado si es nuevo
			$resp['id'] = $rid;
			$resp['status'] = 'success';
			$resp['msg'] = empty($id) ? "Tarea guardada exitosamente." : "Tarea actualizada exitosamente.";
		} else {
			// Manejar errores de la consulta
			$resp['status'] = 'failed';
			$resp['msg'] = "Ocurrió un error al guardar los datos.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
	
		// Agregar mensaje flash si se guarda correctamente
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);
	
		return json_encode($resp); // Devolver respuesta en formato JSON
	}	
	function delete_task(){
		extract($_POST);
	
		// Verificar si la tarea existe
		$check = $this->conn->query("SELECT * FROM `task_list` WHERE id = '{$id}'")->num_rows;
		if($check > 0){
			// Eliminar la tarea
			$del = $this->conn->query("DELETE FROM `task_list` WHERE id = '{$id}'");
			if($del){
				$resp['status'] = 'success';
				$resp['msg'] = "Tarea eliminada exitosamente.";
				$this->settings->set_flashdata('success', $resp['msg']);
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "No se pudo eliminar la tarea.";
				$resp['err'] = $this->conn->error;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = "La tarea no existe o ya ha sido eliminada.";
		}
	
		return json_encode($resp); // Devolver respuesta en formato JSON
	}	
	function close_task(){
		extract($_POST);
	
		// Verificar si la tarea existe
		$check = $this->conn->query("SELECT * FROM `task_list` WHERE id = '{$id}'")->num_rows;
		if($check > 0){
			// Actualizar el estado de la tarea a 'Completada'
			$update = $this->conn->query("UPDATE `task_list` SET status = 'Completada', actual_end_date = NOW() WHERE id = '{$id}'");
			if($update){
				$resp['status'] = 'success';
				$resp['msg'] = "Tarea cerrada exitosamente.";
				$this->settings->set_flashdata('success', $resp['msg']);
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "No se pudo cerrar la tarea.";
				$resp['err'] = $this->conn->error;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = "La tarea no existe o ya ha sido cerrada.";
		}
	
		return json_encode($resp); // Devolver respuesta en formato JSON
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
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_project':
		echo $Master->save_project();
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