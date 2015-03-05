<?php
	class Template{
		public $arrConfig = array(
			'templeDir'		=>		'./templates/',		//模板目录
			'cacheDir'		=>		'./templates_c',	//模板缓存目录
			'profix'		=>		'.x',				//模板文件的扩展名
			'cacheExpire'	=>		'10',				//缓存文件过期时间(单位:s)
		);

		public $file = '';	//模板文件

		private static $compileTool;	//编译模板工具

		public function __construct(){
			
		}

		public function setConfig($key , $value){
			if(is_array($key)){
				$this->arrConfig += $key;
			}else{
				$this->arrConfig[$key] = $value;
			}
		}

		public function path(){
			return $this->arrConfig['templeDir'] . md5($this->file) . $this->arrConfig['profix'];
		}

		public function display($file){
			$this->file = $file;

			if($this->needCache()){
				//生成缓存文件
				self::compileTool = new CompileClass($this->arrConfig , $this->path() , $this->file);
			}
		}

		/*
		是否需要缓存
		*/
		public function needCache(){
			if(is_file($this->path()) && filemtime($this->path()) < $this->arrConfig['cacheExpire']){
				return false;
			}else{
				return true;
			}
		}
	}

	class CompileClass{
		private $distFile;
		private $templateFile;
		public function __construct($arrConfig , $distFile , $templateFile){
			$this->distFile = $distFile;
			$this->templateFile = $arrConfig['templeDir'] . $templateFile . $arrConfig['profix'];

			$P_T[] = '#\{(foreach|loop) (\\$[a-zA-Z_][a-zA-Z0-9_]*)\}#';
			$P_T[] = '#\{\/(foreach|loop)\}#';
			$P_T[] = '#\{if (.*?)\}#';
			$P_T[] = '#\{(elseif|else if) (.*?)\}#';
			$P_T[] = '#\{else\}#';
			$P_T[] = '#\{\/if\}#';

			$P_R[] = "<?php echo '\\1(\\2 as $K=>$V){'; ?>";
			$P_R[] = "<?php echo '}'; ?>";
			$P_R[] = "<?php echo 'if(\\1){'; ?>";
			$P_R[] = "<?php echo '}else if(\\2){'; ?>";
			$P_R[] = "<?php echo '}else{'; ?>";
			$P_R[] = "<?php echo '}'; ?>";
		}

		public function compile(){
			$templateFile = 
		}
	}
