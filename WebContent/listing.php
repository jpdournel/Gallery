<?php

$GLOBALS['root_dir'] = 'gallery/';
$GLOBALS['original_dir'] = $root_dir . 'original/';
$GLOBALS['thumb_dir'] = $root_dir . 'thumb/';
$GLOBALS['forgotten'] = array('.','..','thumb.jpg', '.DS_Store');


class Photo {
	
	public $link;
	public $thumbLink;
	
	function __construct($link) {
		$temp = str_replace($root_dir, '', $link);
		$this->thumbLink = $temp;
		$this->link = str_replace('thumb', 'fullsize', $temp);
	}
}

class Dossier {
	
	public $link;
	public $thumb;
	public $name;
	public $dossierList = array();
	public $photoList = array();
	
	// Construit un objet dossier ˆ partir de son nom relatif
	function __construct($name) {
		$this->name = end( explode('/', $name) );

		//On ouvre le dossier pour affecter le premier ŽlŽment en thumb
		$this->thumb = $GLOBALS['thumb_dir'] . $name . '/thumb.jpg';
		
		$this->link = $name;
	}
}
    
// rŽcupŽration du dossier de thumb correspondant au dossier demandŽ
$var_name = $HTTP_GET_VARS['dir'];
$requested_dir_name = $thumb_dir . $HTTP_GET_VARS['dir'];
    
    
//Ouverture du dossier en lecture seule
$requested_dir = opendir($requested_dir_name);

if (!$requested_dir) {
    echo 'Dossier introuvable';
    return;
}
	
//CrŽation de l'objet dossier ˆ renvoyer
$dossierParent = new Dossier($var_name);
	
//itŽration sur le contenu
while (($file = readdir($requested_dir)) !== false) {
    
	if(!in_array($file, $GLOBALS['forgotten'])) {
        if (end( explode('.',$file)) !='jpg' ) { //dossier
            $dossier = new Dossier($file);
            $dossierParent->dossierList[] = $dossier;
        } else {  //photo
            $photo = new Photo($requested_dir_name.'/'.$requested_dir.'/'.$file);
            $dossierParent->photoList[] = $photo;
        }
    }
}

closedir($requested_dir);
    
echo json_encode($dossierParent);
	

?>