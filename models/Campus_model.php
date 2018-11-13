<?php

class Campus_model extends CI_Model {

    private $campus;

    public function __construct() {
        //$this->campus = $this->load->database('campus', TRUE);
    }
    /**
     * Obtiene todos los estados de la tabla CODE_STATE, actualmente contiene solo los de Mexico
     *
     * @param boolean $number_as_id Usar el campo StateProvinceId como id, este campo es un numero entero 
     * consecutivo que corresponde con el orden alfabetico ascendente de los estados.
     * @return ResultSet con id y descripcion de los estados
     */
    public function geo_estados($number_as_id = false) {
        if ( $number_as_id ) {
            $this->campus->select('code_value as code, long_desc as description, StateProvinceId as id');
        } else {
            $this->campus->select('code_value as id, long_desc as description, StateProvinceId as state_id');
        }
        $query = $this->campus->get('code_state');

        return $query->result();
    }

    public function planteles() {
        /*
        $this->campus->select('code_value as id, short_desc as description');
        $query = $this->campus->get('code_acasession');
        
        return $query->result();*/
        return array(
            (object) array('id' => 'PUE', 'description' => 'Puebla'),
            (object) array('id' => 'TEH', 'description' =>'Tehuacán')
        );
    }

    public function ciclos_academicos() {
        /*$this->campus->distinct();
        $this->campus->select('academic_year as id, academic_year as description');
        $this->campus->where(array(
            'academic_year >' => '1980',
            'academic_year <' => date('Y', strtotime('+2 year'))
        ));
        $this->campus->order_by('academic_year', 'DESC');
        $query = $this->campus->get('academic');

        return $query->result();*/
        $years = array();
        for ( $i = 1980; $i < 2020; $i++ ) {
            $years[] = (object) array('id' => $i, 'description' => $i);
        }
        return $years;
    }

    public function periodos_academicos() {
        $this->campus->select('code_value as id, code_value as description');
        $this->campus->where(array(
            'status = ' => 'A'
        ));
        $this->campus->order_by('');
        $query = $this->campus->get('code_acaterm');

        return $query->result();
    }

    public function programas_educativos() {
        $this->campus->select('code_value as id, formal_title as description');
        $query = $this->campus->get('code_curriculum');

        return $query->result();
    }

    public function modalidades() {
        $this->campus->select('code_value as id, long_desc as description');
        $this->campus->where(array(
            'status = ' => 'A'
        ));
        $query = $this->campus->get('code_program');

        return $query->result();
    }

    public function niveles_estudios() {
        $this->campus->select('code_value as id, medium_desc as description');
        $this->campus->where(array(
            'status = ', 'A'
        ));
        $query = $this->campus->get('code_degree');

        return $query->result();
    }

    /**
     * Obtiene las diferentes modalidades de titulacion definidas en la tabla CODE_EXAMINATIONSTATUS
     *
     * @param boolean $code_value_as_id Especificar si se desea usar 
     * el campo CODE_VALUE como id, por default se usa el campo ExaminationStatusId
     * @return ResultSet de las modalidades de titulacion con id y descripcion
     */
    public function titulacion_modalidades($code_value_as_id = false) {
        if ( $code_value_as_id ) {
            $this->campus->select('code_value as id, examinationstatusid as status, long_desc as description');
        } else {
            $this->campus->select('code_value as code, examinationstatusid as id, long_desc as description');
        }
        $query = $this->campus->get('code_examinationstatus');

        return $query->result();
    }

    public function getEstadoById($state_province_id) {
        $this->campus->where(array(
            'StateProvinceId' => $state_province_id
        ));
        $query = $this->campus->get('code_state');

        return $query->row();
    }

}
