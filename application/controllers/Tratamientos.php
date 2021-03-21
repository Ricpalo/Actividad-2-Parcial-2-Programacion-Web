<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tratamientos extends CI_Controller {
	function __construct(){
		parent::__construct();
        $this->load->model('PacientesDAO');
        $this->load->model('TratamientosDAO');
    }

    function index(){
        $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
        $data['tratamientos'] = $this->TratamientosDAO->listar_tratamientos();
        $this->load->view('tratamientos/tratamientos_pagina', $data);
    }

    function registrar_tratamiento($clave = NULL){
        $this->form_validation->set_rules('texto', 'Texto de Tratamiento', 'required|min_length[3]|max_length[120]');
        $this->form_validation->set_rules('fecha', 'Fecha de Tratamiento', 'required');
        $this->form_validation->set_rules('paciente', 'Paciente', 'callback_validar_paciente');

        if($this->form_validation->run()){
            $datos = array(
                "texto_tratamiento" => $this->input->post('texto'),
                "fecha_tratamiento" => $this->input->post('fecha'),
                "fk_paciente" => $this->input->post('paciente')
            );

            if($clave){
                $existe_tratamiento = $this->TratamientosDAO->obtener_tratamiento_id($clave);

                if($existe_tratamiento){
                    $id = $clave;

                    $this->TratamientosDAO->editar_tratamiento($datos, $id);
                    $this->session->set_flashdata('mensaje', 'Modificado Correcto');
                } else{
                    $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                }
            } else{
                $this->TratamientosDAO->registrar_tratamiento($datos);
                $this->session->set_flashdata('mensaje', 'Registro Correcto');
            }

            redirect('tratamientos');
        } else{
            $this->session->set_flashdata('errores', $this->form_validation->error_array());
            if($clave){
                $id = $clave;
                redirect('tratamientos/ver_detalle/clave/'. $id);
            } else{
                redirect('tratamientos');
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
            $tratamiento_existe = $this->TratamientosDAO->obtener_tratamiento_id($clave);

            if($tratamiento_existe){
                $data['tratamiento_seleccionado'] = $tratamiento_existe;
                $data['tratamientos'] = $this->TratamientosDAO->listar_tratamientos();
                $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
                $this->load->view('tratamientos/tratamientos_pagina', $data);
            } else{
                $this->session->set_flashdata('mensaje', 'La clave no existe');
                redirect('tratamientos');
            } 
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('tratamientos');
        }
    }

    function borrar_tratamiento($clave = NULL){
        if($clave){
            $tratamiento_existe = $this->TratamientosDAO->obtener_tratamiento_id($clave);

            if($tratamiento_existe){
                $id = $clave;
                $this->TratamientosDAO->borrar_tratamiento($id);
                $this->session->set_flashdata('mensaje', 'Borrado Correcto');
                redirect('tratamientos');
            } else{
                $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                redirect('tratamientos');
            }
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('tratamientos');
        }
    }
}