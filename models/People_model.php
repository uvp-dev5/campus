<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class People_model extends CI_Model {

    private $campus;

    public function __construct() {
        parent::__construct();
        $this->campus = $this->load->database('campus', TRUE);
    }

    public function list() {
    }

    public function get() {
    }

    public function getByTaxId($tax_id) {
        $this->campus->select('people_id as matricula');
        $this->campus->where(array(
            'tax_id' => $tax_id
        ));
        $query = $this->campus->get('people');

        return $query->row();
    }

    public function getEmail($people_id) {
        $this->campus->select('email_addresss');
        $this->campus->where(array(
            'people_org_id', $people_id,
            'address_type', 'DOM'
        ));
        $this->campus->order_by('start_date', 'DESC');
        return $this->campus->get('adressschedule')->row()->email_address;
    }

    public function getPhoneNumber($people_id) {
        $sql = "SELECT PersonPhone.PhoneNumber AS phone_number ";
        $sql.= "FROM ";
        $sql.= "PEOPLE LEFT JOIN PersonPhone";
        $sql.= "ON PEOPLE.PrimaryPhoneId = PersonPhone.PersonPhoneId";
        $sql.= "WHERE PEOPLE.PEOPLE_ID = '".$people_id."' ";

        $query = $this->campus->query($sql);

        return $query->row()->phone_number;
    }

    public function getGender($people_id, $human_readable = false) {
        $this->campus->select('gender');
        $this->campus->where(array('people_id' => $people_id));

        $result = $this->campus->get('demographics')->row();
        if ($human_readable) {
            return ($result->gender === 'F') ? 'Femenino' : 'Masculino';
        } else {
            return $result->gender;
        }
    }

    public function getCurp($people_id, $human_readable = false) {
        $this->campus->select('curp');
        $this->campus->where(array('people_id' => $people_id));

        return $this->campus->get('userdefinedind')->row()->curp;
    }
}