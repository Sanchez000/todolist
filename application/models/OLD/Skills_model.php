<?php
class Skills_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        
		//Метод для получения всех скиллов из таблицы или получение информации по ID скила(если было передано)
		public function get_skills($id = FALSE)
		{
        if ($id === FALSE)
        {
                $query = $this->db->get('Skills');
                return $query->result_array();
        }
        $query = $this->db->get_where('Skills', array('id' => $id));
        return $query->row_array();
		}
		
		
		//Метод для записи уже сформированной подсказки
		public function insert_hints($data)
		{
		$this->db->insert('Hints', $data);
		}
		
		
		
		
}



?>

