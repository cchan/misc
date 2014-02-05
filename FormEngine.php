<?php
//Random concepts - code written for frameworks that don't exist

$html=new HTMLTemplateEngine($templatefile);
$session=new DBSessionManager();

if(!$session->logged_in){
	if(FormMaker::submitted('Login','normal')){
		$form=new FormParser('Login');
		if(!$session->login($form->get('user'),$form->get('pass')))
			$html->alert_error('Incorrect username or password');
		else
			$html->alert_success('Successfully logged in');
	}
	else{
		$form=new FormMaker('Login');
		$form->askText('Username:','user','John S. Smith')->askPass('Password','pass')
			->submitBtn('Log In','normal')->submitBtn('Log In as Admin','admin')->clearBtn('Clear');
		echo $form->out();
		
		$form->init('Register');
		$form->askText('Your Username:','user','John S. Smith')->askPass('Password','pass')
			->submitBtn('Register');
		echo $form->out();
	}
}
else{
	echo "Hi you're logged in as {$session->user} yay";
	if(FormMaker::submitted('Logout')){
		$session->logout();
	}
	else{
		$form=new FormMaker('Logout');
		$form->submitBtn('Logout');
		echo $form->out();//Output
	}
}

?>
<table class="FE_form_wrapper">
	<tr>
		<td>Enter your Username:</td>
		<td><input type="text" name="f8729d3" placeholder="John S. Smith" /></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="gj28283" /></td>
	</tr>
</table>