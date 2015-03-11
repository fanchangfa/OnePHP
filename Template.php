<?php
	/*模板类*/
	class Template{
		public $arrConfig = array(
			'templeDir'		=>		'./templates/',		//模板目录
			'cacheDir'		=>		'./templates_c',	//模板缓存目录
			'compileDir'	=>		'./compiles',		//模板文件编译后存放目录
			'profix'		=>		'.x',				//模板文件的扩展名
			'cacheExpire'	=>		'10',				//缓存文件过期时间(单位:s)
			'cache_html'	=>		true,				//是否需要生成静态文件
		);

		public $file = '';	//模板文件,仅文件名，不包含路径和扩展

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

		/*
			获取完整的模板文件路径
		*/
		public function path(){
			return $this->arrConfig['templeDir'] . $this->file . $this->arrConfig['profix'];
		}

		public function display($file){
			$this->file = $file;

			//当前模板文件对应的编译文件
			$compileFile = $this->arrConfig['compileDir'] . md5($file) .'.php';

			//当前模板文件对应的缓存静态文件
			$cacheFile = $this->arrConfig['cacheDir'] . md5($file) .'.htm';
			
			if($this->needCache($cacheFile)){
				//生成缓存文件
				self::compileTool = new CompileClass($this->path() , $compileFile);
			}
		}

		/*
		是否需要重新生成静态文件
		*/
		public function needCache($file){
			if($this->arrConfig['cache_html'] !== false){
				if(is_file($file) && 
					(time() - @filemtime($file) < $this->arrConfig['cacheExpire'])){
					return false;
				}else{
					return true;
				}
			}

			return false;
		}
	}

	class CompileClass{
		private $compileFile;		//编译后的文件
		private $templateFile;		//待编译的文件
		public function __construct($templateFile , $compileFile){
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
