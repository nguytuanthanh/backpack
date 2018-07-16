<?php 
function get_phone_number($args, $content){
	if(isset($_POST['reg-button'])){
	    if($_POST['phone_number'] != "" && preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})?[-\. ]?([0-9]{7})$/', trim($_POST['phone_number']))){
	        $phone = trim($_POST['phone_number']);
	        date_default_timezone_set('Asia/Ho_Chi_Minh');
	      //getPhone($phone);
	        $result = 'tc';
	    }else{
	    	$result = 'tb';
	    }
   	}
	  return '
	    <form action="" method="POST" class="form_phone_number">
	      <input name="phone_number" type="text" placeholder="Nhập SĐT cần gọi lại">
	      <button name="reg-button" class="reg-button">Gọi lại cho tôi</button>
	    </form>
	  ';
	echo ($result != "")?$result:null;
}
add_shortcode( 'get_phone_number', 'get_phone_number' );
?>