<?php

	function read_dir($dir, $array = array()){
        $dh = opendir($dir);
        $files = array();
        while (($file = readdir($dh)) !== false) {
            $flag = false;
            if($file !== 'global' && $file !== '.' && $file !== '..' && $file !== '.ftpquota' && !in_array($file, $array)) {
                $files[] = $file;
            }
        }
        return $files;
    }
	
    //available themes			
	$dir= FCPATH.'themesv2/';
	$data=read_dir($dir);	
	echo serialize($data);	
	exit;
?>


