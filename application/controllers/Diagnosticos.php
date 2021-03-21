<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diagnosticos extends CI_Controller {
	function __construct(){
		parent::__construct();
        $this->load->model('PacientesDAO');
        $this->load->model('DiagnosticosDAO');
    }

    function index(){
        $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
        $data['diagnosticos'] = $this->DiagnosticosDAO->listar_diagnosticos();
        $this->load->view('diagnosticos/diagnosticos_pagina', $data);
    }

    function registrar_diagnostico($clave = NULL){
        $this->form_validation->set_rules('text', 'Texto de Diagnostico', 'required|min_length[3]|max_length[120]');
        $this->form_validation->set_rules('fecha', 'Fecha de Diagnostico', 'required');
        $this->form_validation->set_rules('diagnostico', 'Diagnosticado Por', 'required|min_length[3]|max_length[120]');
        $this->form_validation->set_rules('paciente', 'Paciente', 'callback_validar_paciente');

        if($this->form_validation->run()){
            $datos = array(
                "text_diagnostico" => $this->input->post('text'),
                "fecha_diagnostico" => $this->input->post('fecha'),
                "diagnostico_por" => $this->input->post('diagnostico'),
                "fk_paciente" => $this->input->post('paciente')
            );

            if($clave){
                $existe_diagnostico = $this->DiagnosticosDAO->obtener_diagnostico_id($clave);

                if($existe_diagnostico){
                    $id = $clave;

                    $this->DiagnosticosDAO->editar_diagnostico($datos, $id);
                    $this->session->set_flashdata('mensaje', 'Modificado Correcto');
                } else{
                    $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                }
            } else{
                $this->DiagnosticosDAO->registrar_diagnostico($datos);
                $this->session->set_flashdata('mensaje', 'Registro Correcto');
            }

            redirect('diagnosticos');
        } else{
            $this->session->set_flashdata('errores', $this->form_validation->error_array());
            if($clave){
                $id = $clave;
                redirect('diagnosticos/ver_detalle/clave/'. $id);
            } else{
                redirect('diagnosticos');
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
            $diagnostico_existe = $this->DiagnosticosDAO->obtener_diagnostico_id($clave);

            if($diagnostico_existe){
                $data['diagnostico_seleccionado'] = $diagnostico_existe;
                $data['diagnosticos'] = $this->DiagnosticosDAO->listar_diagnosticos();
                $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
                $this->load->view('diagnosticos/diagnosticos_pagina', $data);
            } else{
                $this->session->set_flashdata('mensaje', 'La clave no existe');
                redirect('diagnosticos');
            } 
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('diagnosticos');
        }
    }

    function borrar_diagnostico($clave = NULL){
        if($clave){
            $diagnostico_existe = $this->DiagnosticosDAO->obtener_diagnostico_id($clave);

            if($diagnostico_existe){
                $id = $clave;
                $this->DiagnosticosDAO->borrar_diagnostico($id);
                $this->session->set_flashdata('mensaje', 'Borrado Correcto');
                redirect('diagnosticos');
            } else{
                $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                redirect('diagnosticos');
            }
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('diagnosticos');
        }
    }
}