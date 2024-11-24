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
<<<<<<< HEAD
	
		// Construir datos dinámicamente desde $_POST
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id'))){ // Excluir `id` porque se maneja por separado
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v); // Escapar valores no numéricos
				if(!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
	
		// Verificar si el proyecto ya existe (por nombre y excluir el actual si se está actualizando)
		$check = $this->conn->query("SELECT * FROM `project_list` WHERE `title` = '{$title}' ".(is_numeric($id) && $id > 0 ? " AND id != '{$id}'" : "")." ")->num_rows;
=======
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id'))){
				$v = $this->conn->real_escape_string($v); // Escapar datos
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
	
		if(empty($id)){
			$sql = "INSERT INTO `project_list` SET {$data}";
		} else {
			$sql = "UPDATE `project_list` SET {$data} WHERE id = '{$id}'";
		}
	
		// Validar si el nombre ya existe
		$check = $this->conn->query("SELECT * FROM `project_list` WHERE `name` = '{$name}' ". (is_numeric($id) && $id > 0 ? "AND id != '{$id}'" : ""))->num_rows;
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = 'El proyecto ya existe.';
		} else {
<<<<<<< HEAD
			// Crear o actualizar el registro
			if(empty($id)){
				$sql = "INSERT INTO `project_list` SET {$data} ";
			} else {
				$sql = "UPDATE `project_list` SET {$data} WHERE id = '{$id}' ";
			}
	
			// Ejecutar la consulta
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id; // Obtener ID generado si es nuevo
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Proyecto agregado exitosamente.";
				else
					$resp['msg'] = "Proyecto actualizado exitosamente.";
			} else {
				// Manejar errores de la consulta
				$resp['status'] = 'failed';
				$resp['msg'] = "Ocurrió un error al guardar los datos.";
				$resp['err'] = $this->conn->error."[{$sql}]";
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
=======
			$save = $this->conn->query($sql);
			if($save){
				$rid = empty($id) ? $this->conn->insert_id : $id;
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				$resp['msg'] = empty($id) ? "Proyecto agregado exitosamente." : "Proyecto actualizado exitosamente.";
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "Ocurrió un error al guardar.";
				$resp['err'] = $this->conn->error . "[{$sql}]";
			}
		}
	
		return json_encode($resp);
	}
	public function delete_project() {
		// Verificar si se envió el ID
		if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'ID de proyecto no válido o no proporcionado.';
			return json_encode($resp);
		}
	
		$id = intval($_POST['id']); // Asegurar que el ID sea un número entero
	
		// Ejecutar consulta para eliminar permanentemente el proyecto
		$del = $this->conn->query("DELETE FROM `project_list` WHERE id = {$id}");
	
		if ($del) {
			$resp['status'] = 'success';
			$resp['msg'] = 'Proyecto eliminado permanentemente.';
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Error al eliminar el proyecto.';
			$resp['err'] = $this->conn->error; // Incluir el error SQL para depuración
		}
	
		// Devolver respuesta en formato JSON
		return json_encode($resp);
	}
	public function edit_project() {
		// Validar datos enviados
		if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'ID de proyecto no válido o no proporcionado.';
			return json_encode($resp);
		}
	
		$id = intval($_POST['id']);
		$name = $this->conn->real_escape_string($_POST['name']);
		$description = $this->conn->real_escape_string($_POST['description']);
	
		// Actualizar los datos del proyecto en la base de datos
		$update = $this->conn->query("UPDATE `project_list` SET name = '{$name}', description = '{$description}' WHERE id = {$id}");
	
		if ($update) {
			$resp['status'] = 'success';
			$resp['msg'] = 'Proyecto actualizado exitosamente.';
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = 'No se pudo actualizar el proyecto.';
			$resp['err'] = $this->conn->error; // Mostrar error SQL para depuración
		}
	
		// Devolver respuesta en formato JSON
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
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
<<<<<<< HEAD
=======
	public function delete_task() {
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `task_list` WHERE id = '{$id}'");
		if ($delete) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function edit_task() {
		extract($_POST);
		$update = $this->conn->query("UPDATE `task_list` SET 
			project_name = '{$project_name}', 
			task_name = '{$task_name}', 
			start_date = '{$start_date}', 
			end_date = '{$end_date}', 
			project_status = '{$project_status}', 
			task_status = '{$task_status}' 
			WHERE id = '{$id}'");
		if ($update) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		return json_encode($resp);
	}
>>>>>>> 1b45fe63b38a4569f2263a092e494b7082413516
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