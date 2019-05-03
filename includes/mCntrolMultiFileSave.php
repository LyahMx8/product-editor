<?php

class mCntrolMultiFileSave{
	
	private $mGetFileSletd;
	private $ModelNmImg=array(0=>"Imagen Alpha Frontal",1=>"Imagen Alpha Trasera",2=>"Imagenes Frontales",3=>"Imagenes Traseras", 4=>"Imagen Editada");
	private $rBasExt;
	private $m_base_post;
	private $_index;

	function __construct($FileGetoSve, $base_post,$index_arry){
		
		$this->mGetFileSletd = $FileGetoSve;

		$this->m_base_post = $base_post; $this->_index = $index_arry; $this->mFunSlcErrFle();

	}
	private function mFunSlcErrFle(){
		
		try{

			if($this->mGetFileSletd['type'][$this->_index]!=UPLOAD_ERR_OK)
				throw new Exception("Error al Subir la Imagen! 2");
			else return $this->mFunSlcTypFle();

		}catch(Exception $mGetState){
			print('<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>'.$mGetState->getMessage().'</b></div>');
		}
	}

	private function mFunSlcTypFle(){
		$mAccssExt = array('png','jpg','jpeg'); $this->rBasExt = pathinfo($this->mGetFileSletd['name'][$this->_index],PATHINFO_EXTENSION);
		if(!in_array($this->rBasExt,$mAccssExt))
			throw new Exception("Formato de Imagen no Valido! 2");
		else return $this->mFunSlcMaxSize();
	}

	private function mFunSlcMaxSize(){
		$mKbySzeUp=1500;
		if($this->mGetFileSletd['size'][$this->_index]>=($mKbySzeUp*1024))
			throw new Exception("La Imagen es muy Pesada! 2");
		else return $this->mFunSlcIsUp();

	}
	private function mFunSlcIsUp(){
		if(!is_uploaded_file($this->mGetFileSletd['tmp_name'][$this->_index]))
			throw new Exception("Error al Subir el Archivo 2");
		else return $this->mFunSlcMovImg();

	}
	private function mFunSlcMovImg(){ $mPath = SERV."/productos/"; $mPatchsave = "productos/";

		global $wpdb; 

		$mNmbArchv = basename(date("Y-m-d")."-".$this->mGetFileSletd['name'][$this->_index]);

		if(strpos($this->mGetFileSletd['name'][$this->_index],"trase")!==false) $this->m_base_post['TiProduct'] = 3;

		$sql = ("INSERT INTO zalemto_editor_img (cmpidprdct, cmpidtipimg, cmpurlimg, cmpfechup) values ('".$this->m_base_post['IdProduct']."','".$this->m_base_post['TiProduct']."','".$mPatchsave.$mNmbArchv."','".date("Y-m-d H:i:s")."')");
		$wpdb->query($sql);

		if(!move_uploaded_file($this->mGetFileSletd['tmp_name'][$this->_index],$mPath.$mNmbArchv))
			throw new Exception("Error Moviendo Archivo Ubicacion 2");
		else return true;
	}
	function __destruct(){
		unset($this->mGetFileSletd);
		unset($this->rBasExt);
		unset($this->m_base_post);
		unset($this->_index);
	}
}