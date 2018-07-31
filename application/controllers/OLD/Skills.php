<?php
class Skills extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('skills_model');
                $this->load->helper('url_helper');
        }

        public function index()
        {
            /*
          $data['Skills'] = $this->skills_model->get_skills();
		  $this->load->view('skills_list',$data);//загрузка скилл групп в отдельную форму
		  */
		  $this->load->view('main_view');// загрузка основной страницы
     	  //$this->load->view('templates/footer');
		}
}
?>
		  