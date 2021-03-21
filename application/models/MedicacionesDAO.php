<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedicacionesDAO extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function editar_medicacion($datos, $id){
        $this->db->where('id_medicamento', $id);
        $this->db->update('medicacion_paciente', $datos);
    }

    function registrar_medicacion($datos){
        $this->db->insert('medicacion_paciente', $datos);
    }

    function listar_medicaciones(){
        $sql = 'SELECT m.*, p.nombre_paciente FROM medicacion_paciente m, pacientes p WHERE id_paciente = fk_paciente';

        $query = $this->db->query($sql);

        return $query->result();
    }

    function obtener_medicacion_id($id){
        $this->db->where('id_medicamento', $id);

        $query = $this->db->get('medicacion_paciente');
        return $query->row();
    } 

    function borrar_medicacion($id){
        $this->db->where('id_medicamento', $id);
        $this->db->delete('medicacion_paciente');
    }
}