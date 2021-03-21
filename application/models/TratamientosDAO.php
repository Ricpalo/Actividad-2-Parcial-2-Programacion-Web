<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TratamientosDAO extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function editar_tratamiento($datos, $id){
        $this->db->where('id_tratamiento', $id);
        $this->db->update('tratamiento_paciente', $datos);
    }

    function registrar_tratamiento($datos){
        $this->db->insert('tratamiento_paciente', $datos);
    }

    function listar_tratamientos(){
        $sql = 'SELECT t.*, p.nombre_paciente FROM tratamiento_paciente t, pacientes p WHERE id_paciente = fk_paciente';

        $query = $this->db->query($sql);

        return $query->result();
    }

    function obtener_tratamiento_id($id){
        $this->db->where('id_tratamiento', $id);

        $query = $this->db->get('tratamiento_paciente');
        return $query->row();
    } 

    function borrar_tratamiento($id){
        $this->db->where('id_tratamiento', $id);
        $this->db->delete('tratamiento_paciente');
    }
}