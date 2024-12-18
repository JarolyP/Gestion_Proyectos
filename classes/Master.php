<?php
require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_project()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `project_list` set {$data} ";
		} else {
			$sql = "UPDATE `project_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `project_list` where `name` = '{$name}' " . (is_numeric($id) && $id > 0 ? " and id != '{$id}'" : "") . " ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Proyecto existe actualmente.';
		} else {
			$save = $this->conn->query($sql);
			if ($save) {
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				if (empty($id))
					$resp['msg'] = "Proyecto ha sido agregado exitósamente";
				else
					$resp['msg'] = "Proyecto ha sido actualizado exitósamente";
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "Ocurrió un error.";
				$resp['err'] = $this->conn->error . "[{$sql}]";
			}
		}
		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function delete_project()
	{
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM `report_list` where project_id ='{$id}'")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['mesg'] = 'No se puede eliminar este proyecto porque ya tiene un informe listado.';
		} else {
			$del = $this->conn->query("UPDATE `project_list` set delete_flag = 1 where id = '{$id}'");
			if ($del) {
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success', "Proyect ha sido eliminado exitósamente.");
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = $this->conn->error;
			}
		}
		return json_encode($resp);
	}
	function close_project()
	{
		extract($_POST);

		$update = $this->conn->query("UPDATE `project_list` set status = 2 where id = '{$id}'");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Proyecto ha sido cerrado exitósamente.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_work_type()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `work_type_list` set {$data} ";
		} else {
			$sql = "UPDATE `work_type_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `work_type_list` where `name` = '{$name}' " . (is_numeric($id) && $id > 0 ? " and id != '{$id}'" : "") . " ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Este tipo de trabajo ya existe';
		} else {
			$save = $this->conn->query($sql);
			if ($save) {
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				if (empty($id))
					$resp['msg'] = "Este tipo de trabajo ha sido agregado exitósamente";
				else
					$resp['msg'] = "La información de este tipo de trabajo ha sido actualizada exitósamente";
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "Ocurrió un error.";
				$resp['err'] = $this->conn->error . "[{$sql}]";
			}
		}
		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function delete_work_type()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `work_type_list` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Este tipo de trabajo ha sido eliminado exitósamente.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_report()
	{
		$_POST['description'] = htmlentities($_POST['description']);
		$_POST['employee_id'] = $this->settings->userdata('id');
		$duration = strtotime($_POST['datetime_to']) - strtotime($_POST['datetime_from']);
		$_POST['duration'] = $duration;
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `report_list` set {$data} ";
		} else {
			$sql = "UPDATE `report_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if ($save) {
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['id'] = $rid;
			$resp['status'] = 'success';
			if (empty($id))
				$resp['msg'] = " Este reporte ha sido agregado exitósamente.";
			else
				$resp['msg'] = " Este reporte ha sido actualizado exitósamente.";

			$this->conn->query("UPDATE `project_list` set `status` ='1' where id = '{$project_id}' ");
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = "Ocurrió un error.";
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function delete_report()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `report_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Reporte ha sido eliminado exitósamente");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function save_task()
	{
		global $conn;

		// Recibir los datos del formulario
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$task = $_POST['name'];
		$description = $_POST['description'];
		$estimated_start_date = $_POST['start_date'];
		$estimated_end_date = $_POST['end_date'];
		$responsible = $_POST['responsible'];
		$status = $_POST['status'];
		$project_id = isset($_POST['project_id']) ? intval($_POST['project_id']) : 0;

		// Validar que los campos requeridos no estén vacíos
		if (empty($task) || empty($description) || empty($estimated_start_date) || empty($estimated_end_date) || empty($responsible) || empty($status)) {
			return json_encode(['status' => 'error', 'msg' => 'Por favor completa todos los campos requeridos.']);
		}

		// Insertar o actualizar según si existe un ID
		if ($id > 0) {
			// Actualizar la tarea existente
			$sql = "UPDATE `task_list` SET 
					`task` = ?, 
					`description` = ?, 
					`estimated_start_date` = ?, 
					`estimated_end_date` = ?, 
					`responsible` = ?, 
					`status` = ?
					WHERE `id` = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ssssssi", $task, $description, $estimated_start_date, $estimated_end_date, $responsible, $status, $id);
		} else {
			// Insertar una nueva tarea
			$sql = "INSERT INTO `task_list` 
					(`task`, `description`, `estimated_start_date`, `estimated_end_date`, `responsible`, `status`, `project_id`) 
					VALUES (?, ?, ?, ?, ?, ?, ?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ssssssi", $task, $description, $estimated_start_date, $estimated_end_date, $responsible, $status, $project_id);
		}

		// Ejecutar la consulta y verificar el resultado
		if ($stmt->execute()) {
			return json_encode(['status' => 'success']);
		} else {
			return json_encode(['status' => 'error', 'msg' => 'Error al guardar los datos: ' . $stmt->error]);
		}
	}
	function delete_task() {
		global $conn;
	
		// Recibir el ID de la tarea a eliminar
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
		// Verificar que el ID es válido
		if ($id <= 0) {
			return json_encode(['status' => 'error', 'msg' => 'ID de tarea no válido.']);
		}
	
		// Preparar la consulta para eliminar la tarea
		$sql = "DELETE FROM `task_list` WHERE `id` = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $id);
	
		// Ejecutar la consulta y verificar el resultado
		if ($stmt->execute()) {
			return json_encode(['status' => 'success']);
		} else {
			return json_encode(['status' => 'error', 'msg' => 'Error al eliminar la tarea: ' . $stmt->error]);
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
