<?php
class News extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
                $this->load->helper('url_helper');
				$this->load->view('templates/header');
        }

        public function index()
        {
          $data['Skills'] = $this->news_model->get_news();
		  //$this->load->view('templates/header');
		  $this->load->view('Skills/index',$data);
     	  $this->load->view('templates/footer');
		}  
		  
		public function detail_skill()
		{
		//Get the value from the form.
		$Skill_id = $this->input->post('skills_list');
		$product_list = file_get_contents("https://crm.privatbank.ua/WidgetMaster/rest/thematic/get/product?list=0,$Skill_id");	
		//Put the value in an array to pass to the view. 
		$data['Skill_id'] = $Skill_id;
		$data['product_list'] = json_decode($product_list,true);
		$temp_pr_list = json_decode($product_list,true);
		$temp = $temp_pr_list["data"];
		$options = "";
		for($i=0;$i<count($temp);$i++){
		$options .= '<option value="'.$temp[$i]["id"].'">'.$temp[$i]["name"].'</option>';
		}
		$data['options'] = $options;

		//$this->load->view('templates/header');
		$this->load->view('Skills/detail', $data);
		$this->load->view('templates/footer');
		
		}


		public function detail_product()
		{
		//то что получили из view
		$product_id = $this->input->post('product_list');
		$Skill_id = $this->input->post('Skill_id');
		//запрос списка продуктов
		$product_list = file_get_contents("https://crm.privatbank.ua/WidgetMaster/rest/thematic/get/product?list=0,$Skill_id");	
		$temp_pr_list = json_decode($product_list,true);
		$temp = $temp_pr_list["data"];
		$options = "";
		for($i=0;$i<count($temp);$i++){
			if($temp[$i]["id"] == $product_id){		
			$options .= '<option value="'.$temp[$i]["id"].'" selected="selected">'.$temp[$i]["name"].'</option>';
			}else{
			$options .= '<option value="'.$temp[$i]["id"].'">'.$temp[$i]["name"].'</option>';
			}
		}
		//запрос списка тематик
		$tema_list = file_get_contents("https://crm.privatbank.ua/WidgetMaster/rest/thematic/get/thematics?group=$Skill_id&product=$product_id");
		$tema_list = json_decode($tema_list,true);
		
		$options_for_tema = "";
		$temp = $tema_list["data"];
		for($i=0;$i<count($temp);$i++){
		$options_for_tema .= '<option value="'.$temp[$i]["id"].'" title="'.$temp[$i]["name"].'">'.$temp[$i]["name"].'</option>';
		}
		$data['options_for_tema'] = $options_for_tema;
		
		//записываем все что хотим передать во view 
		$data['product_list'] = json_decode($product_list,true);
		$data['options'] = $options;
		
		$data['Skill_id'] = $Skill_id;
		$data['product_id'] = $product_id;
		$data['style'] = "";
		//$this->load->view('templates/header');
		$this->load->view('Skills/detail', $data);// выводит список продуктов
		$this->load->view('Skills/detail_product', $data);//выводит список тематик по продукту
		$this->load->view('templates/footer');
		}

		
		
		
		
		//финальное сохранение текста подсказки 
		public function finish()
		{
		$arr = array();
		$stringa = "";
		$koma = ",";
	
		//получаем то что пришло из предыдущего view
		$product_id = $this->input->post('product_id');
		$Skill_id = $this->input->post('Skill_id');
		$tema_list = $this->input->post("tema_list");

		if(count($tema_list)>1){
			for($i=0;$i<count($tema_list);$i++){
				if($i !== count($tema_list)-1){	
				$stringa .= $tema_list[$i].$koma;
				}else{
					$stringa .= $tema_list[$i];
				}
			}
		}else{
			$stringa .= $tema_list[0];
		}
		
	
		$data['list_tema_selected'] = $stringa;//можно будет по идее удалить когда селект заработает
		$data['Skill_id'] = $Skill_id;
		$data['product_id'] = $product_id;
		
		
		//заполняем "селект" продуктов
		$product_list = file_get_contents("https://crm.privatbank.ua/WidgetMaster/rest/thematic/get/product?list=0,$Skill_id");	
		$temp_pr_list = json_decode($product_list,true);
		$temp = $temp_pr_list["data"];
		
		
		$options = "";
		for($i=0;$i<count($temp);$i++){
			if($temp[$i]["id"] == $product_id){		
			$options .= '<option value="'.$temp[$i]["id"].'" selected="selected">'.$temp[$i]["name"].'</option>';
			}else{
			$options .= '<option value="'.$temp[$i]["id"].'">'.$temp[$i]["name"].'</option>';
			}
		}
		$data['options'] = $options;
		
		
		
		// по продуктам закончили
		
		//заполняем "селект" тематик
		$tema_list = file_get_contents("https://crm.privatbank.ua/WidgetMaster/rest/thematic/get/thematics?group=$Skill_id&product=$product_id");
		$tema_list = json_decode($tema_list,true);
		
		$options_for_tema = "";
		$temp = $tema_list["data"];
		
		//массив с выбранными тематиками - $stringa;
		$arrTem = explode(",", $stringa);
		for($i=0;$i<count($temp);$i++){
			if(array_search($temp[$i]["id"], $arrTem) !== false){		
				$options_for_tema .= '<option value="'.$temp[$i]["id"].'" selected="selected" title="'.$temp[$i]["name"].'">'.$temp[$i]["name"].'</option>';
			}else{
			$options_for_tema .= '<option value="'.$temp[$i]["id"].'" title="'.$temp[$i]["name"].'">'.$temp[$i]["name"].'</option>';
			}
		}
		$data['options_for_tema'] = $options_for_tema;
		$data['stringa'] = $stringa;
		$data['style'] = "display:none;";
		//$this->load->view('templates/header');
		$this->load->view('Skills/detail', $data);// выводит список продуктов
		$this->load->view('Skills/detail_product', $data);//выводит список тематик по продукту
		$this->load->view('Skills/finish',$data);//форма с заполнением текста подсказки
		$this->load->view('templates/footer');	
		}
		
		
		public function result()
		{
		$Skill_id = $this->input->post('Skill_id');
		$Product_id = $this->input->post('product_id');
		$Theme_list = $this->input->post("tema_list");
		$Hint = $this->input->post("text_hint");
		
		if(strpos($Theme_list,",") !== false){
			$Theme_arr = explode(",", $Theme_list);
				foreach($Theme_arr as $key){
				$data = array(
				'Skill' => (int)$Skill_id,
				'Product_id' => (int)$Product_id,
				'Theme_id' => (int)$key,
				'Hint' => $Hint
				);
				$this->news_model->insert_hints($data);
				}
		}else{//если выбрана была только одна тематика
			$data = array(
			'Skill' => (int)$Skill_id,
			'Product_id' => (int)$Product_id,
			'Theme_id' => (int)$Theme_list,
			'Hint' => $Hint
		);
		$this->news_model->insert_hints($data);
		}
		//echo "Сохранение подсказки прошло успешно!";
		//$this->load->view('templates/header');
		$this->load->view('Skills/result');
		}
		
		
		
		
}
?>