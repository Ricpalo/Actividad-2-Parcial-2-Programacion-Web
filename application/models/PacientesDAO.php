<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PacientesDAO extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function editar_paciente($datos, $id){
        $this->db->where('id_paciente', $id);
        $this->db->update('pacientes', $datos);
    }

    function registrar_paciente($datos){
        $this->db->insert('pacientes', $datos);
    }

    function listar_pacientes(){
        $query = $this->db->get('pacientes');

        return $query->result();
    }

    function obtener_paciente_id($id){
        $this->db->where('id_paciente', $id);

        $query = $this->db->get('pacientes');
        return $query->row();
    } 
}