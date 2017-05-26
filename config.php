<?php

/*classe de configuração que faz com que possa enxergar as outras classes 
em outros diretorios, quando for importar classes */

spl_autoload_register(function($class_name){

	$filename = "classes".DIRECTORY_SEPARATOR.$class_name.".php";//classes dentro da pasta classes

	if (file_exists(($filename))) {
		require_once($filename);
	}

});

?>