<?php
class News_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_news($id = FALSE)
		{
        if ($id === FALSE)
        {
                $query = $this->db->get('Skills');
                return $query->result_array();
        }
        $query = $this->db->get_where('Skills', array('id' => $id));
        return $query->row_array();
		}
		
		public function insert_hints($data)
		{
		$this->db->insert('Hints', $data);
		}
		
		
		
		
}



?>

