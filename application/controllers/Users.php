<?php

//session_start(); //we need to start session in order to access it through CI

Class Users extends CI_Controller {

public function __construct() {
parent::__construct();

 
        

// Load form helper library
$this->load->helper('form');

$this->load->helper('url');

//xss
$this->load->helper('security');

// Load form validation library
$this->load->library('form_validation');

// Load session library
$this->load->library('session');

// Load database
$this->load->model('login_database');
}

// Show login page
public function index() {
$this->load->view('login_form');
}

// Show registration page
public function user_registration_show() {
$this->load->view('registration_form');
}

// Validate and store registration data in database
public function new_user_registration() {

// Check validation for user input in SignUp form
$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
$this->form_validation->set_rules('email_value', 'Email', 'trim|required|xss_clean');
$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
if ($this->form_validation->run() == FALSE) {
$this->load->view('registration_form');
} else {
$data = array(
'user_name' => $this->input->post('username'),
'user_email' => $this->input->post('email_value'),
'user_password' => $this->input->post('password')
);
$result = $this->login_database->registration_insert($data);
if ($result == TRUE) {
$data['message_display'] = 'Registration Successfully !';
$this->load->view('login_form', $data);
} else {
$data['message_display'] = 'Username already exist!';
$this->load->view('registration_form', $data);
}
}
}

// Check for user login process
public function user_login_process() {

$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
if(isset($this->session->userdata['logged_in'])){
    //When user is logined
redirect('./Main');
//$this->load->view('admin_page');
}else{
$this->load->view('login_form');
}
} else {
$data = array(
'username' => $this->input->post('username'),
'password' => $this->input->post('password')
);
$result = $this->login_database->login($data);
if ($result == TRUE) {

//Check user in DB
$username = $this->input->post('username');
$result = $this->login_database->read_user_information($username);
if ($result != false) {
        $session_data = array(
        'username' => $result[0]->user_name,
        'email' => $result[0]->user_email,
        );
        // Add user data in session
        $this->session->set_userdata('logged_in', $session_data);
        //if valid data of user - RUN
        //начало эксперимента
        $this->load->model('todolist_model');
        
         $allPrjcts = $this->todolist_model->get_all_projects();
          $allTasks = $this->todolist_model->get_all_tasks();
          
          if(count($allPrjcts) > 0){
              
           $compleateHtml = ''; 
          foreach($allPrjcts as $item){
             $data['name'] = $item['name'];
    		 $data['newID'] = $item['id'];
    		 $data['showAdd'] = "N";
    		 $strTask = '';
    		 for($i=0;$i<count($allTasks);$i++){
                    if($allTasks[$i]['project_id'] == $item['id']){
                        $data['taskName'] = $allTasks[$i]['name'];
                        $data['taskId'] = $allTasks[$i]['id'];
                        $data['deadline'] = $allTasks[$i]['deadline'];
                        $data['status'] = $allTasks[$i]['status'];
                        $strTask .= $this->load->view('Parts/taskContainer', $data, TRUE);
                }
    		 }
    		 $data['Tasks'] = $strTask;
    		 $compleateHtml .= $this->load->view('Parts/HeaderForProjects', $data, TRUE);
          }
          //When project selected
            $data['Prjcts'] = $compleateHtml;
            $this->load->view('Parts/header');
            $this->load->view('Parts/body',$data);
            $this->load->view('Parts/new_project');
            $this->load->view('Parts/footer');
            
            //When no projects in DB
          }else{
            $this->load->view('Parts/header');
            $this->load->view('Parts/body');
            $this->load->view('Parts/new_project');
            $this->load->view('Parts/footer');
          }
          
        
        //конец эксперимента
        //redirect('./Main');
        //$this->load->view('admin_page');
}
} else {
$data = array(
'error_message' => 'Invalid Username or Password'
);
$this->load->view('login_form', $data);
}
}
}

// Logout from admin page
public function logout() {

// Removing session data
$sess_array = array(
'username' => ''
);
$this->session->unset_userdata('logged_in', $sess_array);
$data['message_display'] = 'Successfully Logout';
$this->load->view('login_form', $data);
}

}

?>

