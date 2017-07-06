

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagination_model extends CI_Model {

    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    public function record_count($table_name) {
        return $this->db->count_all($table_name);
    }

    public function fetch_data($table_name,$limit, $id) {
        echo $id;die();
        $this->db->limit($limit);
        $this->db->where('donor_id', $id);
        $this->db->where('status',1);
        $query = $this->db->get($table_name);
        echo $query->num_rows();die();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
}
?>

