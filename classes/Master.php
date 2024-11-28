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

		// Depuración: Verificar los datos recibidos
		error_log(print_r($_POST, true)); // Log de los datos recibidos

		// Validar y establecer el estado basado en fechas
		if (!empty($start_date_real) || !empty($end_date_real)) {
			$status = "En Progreso";
		} elseif (!empty($start_date) && !empty($end_date)) {
			$status = "En Planificación";
		} else {
			$status = "Nuevo";
		}

		// Validar rangos de fechas
		if (!empty($start_date) && !empty($end_date) && strtotime($end_date) < strtotime($start_date)) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'La fecha estimada de fin no puede ser anterior a la fecha de inicio.';
			return json_encode($resp);
		}

		if (!empty($start_date_real) && !empty($end_date_real) && strtotime($end_date_real) < strtotime($start_date_real)) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'La fecha real de fin no puede ser anterior a la fecha de inicio.';
			return json_encode($resp);
		}

		// Validar que las fechas reales no estén dentro del rango estimado
		if (!empty($start_date) && !empty($end_date)) {
			if (!empty($start_date_real) && strtotime($start_date_real) >= strtotime($start_date) && strtotime($start_date_real) <= strtotime($end_date)) {
				$resp['status'] = 'failed';
				$resp['msg'] = 'La fecha real de inicio no puede estar dentro del rango de fechas estimadas.';
				return json_encode($resp);
			}

			if (!empty($end_date_real) && strtotime($end_date_real) >= strtotime($start_date) && strtotime($end_date_real) <= strtotime($end_date)) {
				$resp['status'] = 'failed';
				$resp['msg'] = 'La fecha real de fin no puede estar dentro del rango de fechas estimadas.';
				return json_encode($resp);
			}
		}

		// Añadir el estado al arreglo de datos
		$_POST['status'] = $status;

		// Construir el conjunto de datos para la consulta SQL
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!is_numeric($v))
					$v = $this->conn->real_escape_string($v); // Escape de los valores
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		// Verificar si el proyecto ya existe
		$check = $this->conn->query("SELECT * FROM `project_list` WHERE `title` = '{$title}' " . (is_numeric($id) && $id > 0 ? " AND id != '{$id}'" : "") . " ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'El proyecto ya existe.';
		} else {
			// Crear o actualizar el registro
			if (empty($id)) {
				// Agregar el nuevo proyecto
				$sql = "INSERT INTO `project_list` SET {$data}";
			} else {
				// Actualizar el proyecto existente
				$sql = "UPDATE `project_list` SET {$data} WHERE id = '{$id}'";
			}

			// Depuración: Verifica la consulta SQL
			error_log("Consulta SQL: " . $sql);

			// Ejecutar la consulta
			$save = $this->conn->query($sql);
			if ($save) {
				$rid = !empty($id) ? $id : $this->conn->insert_id; // Obtener ID generado si es nuevo
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				$resp['msg'] = empty($id) ? "Proyecto agregado exitosamente." : "Proyecto actualizado exitosamente.";
			} else {
				// Si ocurre un error, mostrar detalles del error
				$resp['status'] = 'failed';
				$resp['msg'] = "Ocurrió un error al guardar los datos.";
				$resp['error'] = $this->conn->error; // Detalles del error de la consulta
			}
		}

		// Agregar mensaje flash si se guarda correctamente
		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);

		return json_encode($resp); // Devolver respuesta en formato JSON
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
		// Asegurarse de que los valores vienen del formulario
		$task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : 0;
		$project_id = isset($_POST['project_id']) ? intval($_POST['project_id']) : 0;
		$task = isset($_POST['task']) ? $this->conn->real_escape_string($_POST['task']) : '';
		$description = isset($_POST['description']) ? $this->conn->real_escape_string($_POST['description']) : '';
		$estimated_start_date = isset($_POST['estimated_start_date']) ? $_POST['estimated_start_date'] : null;
		$estimated_end_date = isset($_POST['estimated_end_date']) ? $_POST['estimated_end_date'] : null;
		$actual_start_date = isset($_POST['actual_start_date']) ? $_POST['actual_start_date'] : null;
		$actual_end_date = isset($_POST['actual_end_date']) ? $_POST['actual_end_date'] : null;
		$status = isset($_POST['status']) ? $this->conn->real_escape_string($_POST['status']) : 'Pendiente';
		$responsible = isset($_POST['responsible']) ? intval($_POST['responsible']) : 0;
		$task_type = isset($_POST['task_type']) ? $this->conn->real_escape_string($_POST['task_type']) : '';

		// Definir la consulta SQL de inserción o actualización
		if (empty($task_id)) {
			// Inserción de nueva tarea
			$sql = "INSERT INTO task_list (project_id, task, description, estimated_start_date, estimated_end_date, actual_start_date, actual_end_date, status, responsible, task_type) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("issssssiss", $project_id, $task, $description, $estimated_start_date, $estimated_end_date, $actual_start_date, $actual_end_date, $status, $responsible, $task_type);
		} else {
			// Actualización de tarea existente
			$sql = "UPDATE task_list SET project_id = ?, task = ?, description = ?, estimated_start_date = ?, estimated_end_date = ?, actual_start_date = ?, actual_end_date = ?, status = ?, responsible = ?, task_type = ? 
                WHERE task_id = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("issssssissi", $project_id, $task, $description, $estimated_start_date, $estimated_end_date, $actual_start_date, $actual_end_date, $status, $responsible, $task_type, $task_id);
		}

		// Ejecutar la consulta SQL
		if ($stmt->execute()) {
			// Si la ejecución fue exitosa
			$resp['status'] = 'success';
			$resp['msg'] = empty($task_id) ? "Tarea agregada exitosamente." : "Tarea actualizada exitosamente.";
		} else {
			// Si hubo un error en la consulta
			$resp['status'] = 'failed';
			$resp['error'] = $stmt->error;
			error_log("Error en la consulta: " . $stmt->error); // Log de errores
		}

		// Cerrar la declaración preparada
		$stmt->close();

		return json_encode($resp);
	}

	function delete_task()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `task_list` WHERE id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$resp['msg'] = "Tarea eliminada exitosamente.";
		} else {
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
