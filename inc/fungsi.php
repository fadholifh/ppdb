<?php
function yesno($boolean){
	if($boolean == 1){
		echo 'Ya';
	}else{
		echo 'tidak';
	}
}
function adm($boolean){
	if($boolean == 2){
		echo 'admin';
	}else if($boolean == 1){
		echo 'verifikator';
	}else if($boolean == 0){
		echo 'operator';
	}
}
?>