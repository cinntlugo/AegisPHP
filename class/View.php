<?php

	/**
	 * ==============================
	 * View
	 * ==============================
	 */

	class View {


		private $view;
		private $template;
		private $data;
		private $type;
		private $meta;

		function __construct($view, $data = null, $meta = null, $template = "default.php", $type = null){
			$this -> view = $view;
			$this -> template = $template;
			$this -> data = $data;
			$this -> type = $type;
			$this -> meta = $meta;
	    }

	    public function getView(){
		    return $this -> view;
	    }

	    public function isCompilable(){
		    return $this -> data != null || $this -> meta != null;
	    }

		public function compile(){

			$viewContent = file_get_contents("views/$this->view");

			if($this -> template != null){
				$templateContent = file_get_contents("templates/$this->template");
				if($this -> meta != null){
					foreach($this -> meta as $key => $value){
						$templateContent = str_replace("{{".$key."}}", $value, $templateContent);
					}
				}
				$mergedContent = str_replace("{{content}}", $viewContent, $templateContent);
			}else{
				$mergedContent = $viewContent;
			}


			if($this -> data != null){
				foreach($this -> data as $key => $value){
					$mergedContent = str_replace("{{".$key."}}", $value, $mergedContent);
				}
			}
			return $mergedContent;
		}

		function __destruct() {

	    }

	}
?>