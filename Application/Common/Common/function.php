<?php 
		function getRandFileName(){
			return date('His')."_".md5(uniqid('',true).'.'.rand());
		}
 ?>