<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumno_model extends CI_Model {

    private $campus;

    public function __construct() {
        parent::__construct();
        $this->campus = $this->load->database('campus', TRUE);
    }

    public function listCarrerasByPeopleId($people_id) {
        $sql = "SELECT DISTINCT 
            a.ACADEMIC_SESSION plantel, 
            a.PEOPLE_ID matricula, 
            a.PROGRAM modalidad, 
            a.DEGREE nivel, 
            a.CURRICULUM carrera,
            cc.LONG_DESC descripcion
        FROM ACADEMIC a, CODE_CURRICULUM cc
        WHERE PEOPLE_ID = '$people_id'
            AND a.CURRICULUM = cc.CODE_VALUE_KEY
            AND a.ACADEMIC_SESSION <> '' 
            AND a.APPLICATION_FLAG = 'Y'";

        $query = $this->campus->query($sql);

        return $query->result();
    }
}