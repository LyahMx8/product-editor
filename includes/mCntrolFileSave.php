<?php

class mCntrolFileSave{
	
	private $mGetFileSletd;
	private $ModelNmImg=array(0=>"Imagen Alpha Frontal",1=>"Imagen Alpha Trasera",2=>"Imagenes Frontales",3=>"Imagenes Traseras", 4=>"Imagen Editada");
	private $rBasExt;
	private $m_base_post;

	function __construct($FileGetoSve, $base_post){
		
		$this->mGetFileSletd = $FileGetoSve;

		$this->m_base_post = $base_post; $this->mFunSlcErrFle();

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
		$mKbySzeUp=1500;
		if($this->mGetFileSletd['size']>=($mKbySzeUp*1024))
			throw new Exception("La Imagen es muy Pesada!");
		else return $this->mFunSlcIsUp();

	}
	private function mFunSlcIsUp(){
		if(!is_uploaded_file($this->mGetFileSletd['tmp_name']))
			throw new Exception("Error al Subir el Archivo");
		else return $this->mFunSlcMovImg();

	}
	private function mFunSlcMovImg(){ $mPath = SERV."/productos/"; $mPatchsave = "productos/";

		global $wpdb; 

		$mNmbArchv = basename(date("Y-m-d-H-i-s").".".$this->rBasExt);

		if($this->m_base_post['TiProduct']==0 || $this->m_base_post['TiProduct']==1){
	
			$result = $wpdb->get_row("SELECT cmpidimg,cmpurlimg FROM zalemto_editor_img WHERE cmpidtipimg = ".$this->m_base_post['TiProduct']." AND cmpidprdct = ".$this->m_base_post['IdProduct'], ARRAY_A);
			//echo $result['cmpurlimg'];
			if(!empty($result['cmpidimg']) || !is_null($result['cmpidimg'])) $wpdb->query("DELETE FROM zalemto_editor_img WHERE cmpidimg = ".$result['cmpidimg']); unlink(SERV."/".$result['cmpurlimg']);
		}

		$sql = ("INSERT INTO zalemto_editor_img (cmpidprdct, cmpidtipimg, cmpurlimg, cmpfechup) values ('".$this->m_base_post['IdProduct']."','".$this->m_base_post['TiProduct']."','".$mPatchsave.$mNmbArchv."','".date("Y-m-d H:i:s")."')");
		$wpdb->query($sql);

		if(!move_uploaded_file($this->mGetFileSletd['tmp_name'],$mPath.$mNmbArchv))
			throw new Exception("Error Moviendo Archivo Ubicacion");
		else return true;
	}
	function __destruct(){
		unset($this->mGetFileSletd);
		unset($this->rBasExt);
		unset($this->m_base_post);
	}
}