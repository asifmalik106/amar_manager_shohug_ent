<footer>
    <script src="<?php echo BASE_URL; ?>asset/js/base.js"></script>
    <script src="<?php echo BASE_URL; ?>asset/js/jquery.min.js"></script>
	<script src="<?php echo BASE_URL; ?>asset/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo BASE_URL; ?>asset/js/metisMenu.min.js"></script>
	<script src="<?php echo BASE_URL; ?>asset/js/sb-admin-2.min.js"></script>
	
	<?php
		if(isset($data['js'])){
			foreach ($data['js'] as $js) {
				echo '<script type="text/javascript" src="'.BASE_URL.'asset/'.$js.'"></script>';
			}
		}
	?>
	<script> 
var $buoop = {vs:{i:13,f:-2,o:-2,s:9,c:-2},unsecure:true,api:4}; 
function $buo_f(){ 
 var e = document.createElement("script"); 
 e.src = "//browser-update.org/update.min.js"; 
 document.body.appendChild(e);
};
try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
catch(e){window.attachEvent("onload", $buo_f)}
</script>
</footer>