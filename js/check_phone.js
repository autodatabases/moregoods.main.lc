function check_phone()
{
	if(document.getElementById('user_phone').value.length < 14){
        return false
      } else {
        document.location='/?action=cart_order_by_phone&phone='+document.getElementById('user_phone').value+'&user_name='+document.getElementById('user_name').value+'&user_email='+document.getElementById('user_email').value+'&user_comment='+document.getElementById('user_comment').value;
      }
}