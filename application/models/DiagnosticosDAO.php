<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DiagnosticosDAO extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function editar_diagnostico($datos, $id){
        $this->db->where('id_diagnostico', $id);
        $this->db->update('diagnosticos_paciente', $datos);
    }

    function registrar_diagnostico($datos){
        $this->db->insert('diagnosticos_paciente', $datos);
    }

    function listar_diagnosticos(){
        $sql = 'SELECT d.*, p.nombre_paciente FROM diagnosticos_paciente d, pacientes p WHERE id_paciente = fk_paciente';

        $query = $this->db->query($sql);

        return $query->result();
    }

    function obtener_diagnostico_id($id){
        $this->db->where('id_diagnostico', $id);

        $query = $this->db->get('diagnosticos_paciente');
        return $query->row();
    } 

    function borrar_diagnostico($id){
        $this->db->where('id_diagnostico', $id);
        $this->db->delete('diagnosticos_paciente');
    }
}