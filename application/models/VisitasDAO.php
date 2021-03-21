<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VisitasDAO extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function editar_visita($datos, $id){
        $this->db->where('id_visita', $id);
        $this->db->update('visitas_paciente', $datos);
    }

    function registrar_visita($datos){
        $this->db->insert('visitas_paciente', $datos);
    }

    function listar_visitas(){
        $sql = 'SELECT v.*, p.nombre_paciente FROM visitas_paciente v, pacientes p WHERE id_paciente = fk_paciente';

        $query = $this->db->query($sql);

        return $query->result();
    }

    function obtener_visita_id($id){
        $this->db->where('id_visita', $id);

        $query = $this->db->get('visitas_paciente');
        return $query->row();
    } 

    function borrar_visita($id){
        $this->db->where('id_visita', $id);
        $this->db->delete('visitas_paciente');
    }
}