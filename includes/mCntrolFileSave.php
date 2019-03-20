<?php

class mCntrolFileSave{
	
	private $mGetFileSletd;
	private $ModelNmImg;
	private $rBasExt;

	function __construct($FileGetoSve){
		
		$this->mGetFileSletd = $FileGetoSve; $this->mFunSlcErrFle();

	}
	private function mFunSlcErrFle(){
		
		try{

			if($this->mGetFileSletd['type']!=UPLOAD_ERR_OK)
				throw new Exception("Error al Subir la Imagen!");
			else return $this->mFunSlcTypFle();

		}catch(Exception $mGetState){
			print('<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>'.$mGetState->getMessage().'</b></div>');
		}
	}

	private function mFunSlcTypFle(){
		$mAccssExt = array('png','jpg','jpeg'); $this->rBasExt = pathinfo($this->mGetFileSletd['name'],PATHINFO_EXTENSION);
		if(!in_array($this->rBasExt,$mAccssExt))
			throw new Exception("Formato de Imagen no Valido!");
		else return $this->mFunSlcMaxSize();
	}

	private function mFunSlcMaxSize(){
		$mKbySzeUp=600;
		if($this->mGetFileSletd['size']>=($mKbySzeUp*1024))
			throw new Exception("La Imagen es muy Pesada!");
		else return $this->mFunSlcIsUp();

	}
	private function mFunSlcIsUp(){
		if(!is_uploaded_file($this->mGetFileSletd['tmp_name']))
			throw new Exception("Error al Subir el Archivo");
		else return $this->mFunSlcMovImg();

	}
	private function mFunSlcMovImg(){ $mPath = SERV."/productos/";

		$mNmbArchv = basename(date("Y-m-d").".".$this->rBasExt);
		if(!move_uploaded_file($this->mGetFileSletd['tmp_name'],$mPath.$mNmbArchv))
			throw new Exception("Error Moviendo Archivo Ubicacion");
		else return true;
	}
	function __destruct(){
		unset($this->mGetFileSletd);
		unset($this->rBasExt);
	}
}