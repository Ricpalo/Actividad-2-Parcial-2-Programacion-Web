<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicaciones extends CI_Controller {
	function __construct(){
		parent::__construct();
        $this->load->model('PacientesDAO');
        $this->load->model('MedicacionesDAO');
    }

    function index(){
        $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
        $data['medicaciones'] = $this->MedicacionesDAO->listar_medicaciones();
        $this->load->view('medicaciones/medicaciones_pagina', $data);
    }

    function registrar_medicacion($clave = NULL){
        $this->form_validation->set_rules('nombre', 'Nombre de Medicamento', 'required|min_length[3]|max_length[120]');
        $this->form_validation->set_rules('dosis', 'Dosis de Medicamento', 'required|min_length[3]|max_length[120]');
        $this->form_validation->set_rules('fecha', 'Fecha de Asignación', 'required');
        $this->form_validation->set_rules('paciente', 'Paciente', 'callback_validar_paciente');

        if($this->form_validation->run()){
            $datos = array(
                "nombre_medicamento" => $this->input->post('nombre'),
                "dosis_medicamento" => $this->input->post('dosis'),
                "fecha_asignacion" => $this->input->post('fecha'),
                "fk_paciente" => $this->input->post('paciente')
            );

            if($clave){
                $existe_medicacion = $this->MedicacionesDAO->obtener_medicacion_id($clave);

                if($existe_medicacion){
                    $id = $clave;

                    $this->MedicacionesDAO->editar_medicacion($datos, $id);
                    $this->session->set_flashdata('mensaje', 'Modificado Correcto');
                } else{
                    $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                }
            } else{
                $this->MedicacionesDAO->registrar_medicacion($datos);
                $this->session->set_flashdata('mensaje', 'Registro Correcto');
            }

            redirect('medicaciones');
        } else{
            $this->session->set_flashdata('errores', $this->form_validation->error_array());
            if($clave){
                $id = $clave;
                redirect('medicaciones/ver_detalle/clave/'. $id);
            } else{
                redirect('medicaciones');
            }
        }
    }

    function validar_paciente($value){
        if($value){
            $existe_paciente = $this->PacientesDAO->obtener_paciente_id($value);

            if($existe_paciente){
                return TRUE;
            } else{
                $this->form_validation->set_message('validar_paciente', 'El campo {field} no existe');
            }
        } else{
            $this->form_validation->set_message('validar_paciente', 'El campo {field} es requerido');
            return FALSE;
        }
    }

    function ver_detalle($clave = NULL){
        if($clave){
            $medicacion_existe = $this->MedicacionesDAO->obtener_medicacion_id($clave);

            if($medicacion_existe){
                $data['medicacion_seleccionada'] = $medicacion_existe;
                $data['medicaciones'] = $this->MedicacionesDAO->listar_medicaciones();
                $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
                $this->load->view('medicaciones/medicaciones_pagina', $data);
            } else{
                $this->session->set_flashdata('mensaje', 'La clave no existe');
                redirect('medicaciones');
            } 
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('medicaciones');
        }
    }

    function borrar_medicacion($clave = NULL){
        if($clave){
            $medicacion_existe = $this->MedicacionesDAO->obtener_medicacion_id($clave);

            if($medicacion_existe){
                $id = $clave;
                $this->MedicacionesDAO->borrar_medicacion($id);
                $this->session->set_flashdata('mensaje', 'Borrado Correcto');
                redirect('medicaciones');
            } else{
                $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                redirect('medicaciones');
            }
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('medicaciones');
        }
    }
}