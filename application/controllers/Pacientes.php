<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacientes extends CI_Controller {
	function __construct(){
		parent::__construct();
        $this->load->model('PacientesDAO');
    }

    function index(){
        $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
        $this->load->view('pacientes/pacientes_pagina', $data);
    }

    function registrar_paciente($clave = NULL){
        $this->form_validation->set_rules('nombre', 'Nombre de Paciente', 'required|min_length[3]|max_length[120]');
        $this->form_validation->set_rules('fecha', 'Fecha de Ingreso', 'required');
        $this->form_validation->set_rules('curp', 'Curp del Paciente', 'required|is_unique[pacientes.curp_paciente]');

        if($this->form_validation->run()){
            $datos = array(
                "nombre_paciente" => $this->input->post('nombre'),
                "fecha_ingreso_paciente" => $this->input->post('fecha'),
                "curp_paciente" => $this->input->post('curp')
            );

            if($clave){
                $existe_paciente = $this->PacientesDAO->obtener_paciente_id($clave);

                if($existe_paciente){
                    $id = $clave;

                    $this->PacientesDAO->editar_paciente($datos, $id);
                    $this->session->set_flashdata('mensaje', 'Modificado Correcto');
                } else{
                    $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                }
            } else{
                $this->PacientesDAO->registrar_paciente($datos);
                $this->session->set_flashdata('mensaje', 'Registro Correcto');
            }

            redirect('pacientes');
        } else{
            $this->session->set_flashdata('errores', $this->form_validation->error_array());
            if($clave){
                $id = $clave;
                redirect('pacientes/ver_detalle/clave/'. $id);
            } else{
                redirect('pacientes');
            }
        }
    }

    function ver_detalle($clave = NULL){
        if($clave){
            $paciente_existe = $this->PacientesDAO->obtener_paciente_id($clave);

            if($paciente_existe){
                $data['paciente_seleccionado'] = $paciente_existe;
                $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
                $this->load->view('pacientes/pacientes_pagina', $data);
            } else{
                $this->session->set_flashdata('mensaje', 'La clave no existe');
                redirect('pacientes');
            } 
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('pacientes');
        }
    }
}