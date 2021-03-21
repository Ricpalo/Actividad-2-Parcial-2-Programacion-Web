<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitas extends CI_Controller {
	function __construct(){
		parent::__construct();
        $this->load->model('PacientesDAO');
        $this->load->model('VisitasDAO');
    }

    function index(){
        $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
        $data['visitas'] = $this->VisitasDAO->listar_visitas();
        $this->load->view('visitas/visitas_pagina', $data);
    }

    function registrar_visita($clave = NULL){
        $this->form_validation->set_rules('paciente', 'Paciente', 'callback_validar_paciente');
        $this->form_validation->set_rules('fecha', 'Fecha de Tratamiento', 'required');
        $this->form_validation->set_rules('comentario', 'Comentario de Visita', 'required|min_length[3]|max_length[120]');

        if($this->form_validation->run()){
            $datos = array(
                "fk_paciente" => $this->input->post('paciente'),
                "fecha_visita" => $this->input->post('fecha'),
                "comentario_visita" => $this->input->post('comentario')
            );

            if($clave){
                $existe_visita = $this->VisitasDAO->obtener_visita_id($clave);

                if($existe_visita){
                    $id = $clave;

                    $this->VisitasDAO->editar_visita($datos, $id);
                    $this->session->set_flashdata('mensaje', 'Modificado Correcto');
                } else{
                    $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                }
            } else{
                $this->VisitasDAO->registrar_visita($datos);
                $this->session->set_flashdata('mensaje', 'Registro Correcto');
            }

            redirect('visitas');
        } else{
            $this->session->set_flashdata('errores', $this->form_validation->error_array());
            if($clave){
                $id = $clave;
                redirect('visitas/ver_detalle/clave/'. $id);
            } else{
                redirect('visitas');
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
            $visita_existe = $this->VisitasDAO->obtener_visita_id($clave);

            if($visita_existe){
                $data['visita_seleccionada'] = $visita_existe;
                $data['visitas'] = $this->VisitasDAO->listar_visitas();
                $data['pacientes'] = $this->PacientesDAO->listar_pacientes();
                $this->load->view('visitas/visitas_pagina', $data);
            } else{
                $this->session->set_flashdata('mensaje', 'La clave no existe');
                redirect('visitas');
            } 
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('visitas');
        }
    }

    function borrar_visita($clave = NULL){
        if($clave){
            $visita_existe = $this->VisitasDAO->obtener_visita_id($clave);

            if($visita_existe){
                $id = $clave;
                $this->VisitasDAO->borrar_visita($id);
                $this->session->set_flashdata('mensaje', 'Borrado Correcto');
                redirect('visitas');
            } else{
                $this->session->set_flashdata('mensaje', 'La clave enviada no existe');
                redirect('visitas');
            }
        } else{
            $this->session->set_flashdata('mensaje', 'Parámetro no enviado');
            redirect('visitas');
        }
    }
}