<?php
namespace App\Controller;

use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;

class UsersController extends AppController{

	public function index()
	{
		# code...
	}
	public function forgotpassword()
	{
		if ($this->request->is('post')) {
			$myemail = $this->request->getData('email');
			$mytoken = Security::hash(Security::randomBytes(25));

			$userTable = TableRegistry::get('Users');
			$user = $userTable->find('all')->where(['email'=>$myemail])->first();
			$user->password = '';
			$user->token = $mytoken;
			if ($userTable->save($user)) {
				$this->Flash->success('Reset password link has been sent to your email ('.$myemail.'), please open your inbox');
				TransportFactory::setConfig('mailtrap', [
				  'host' => 'smtp.mailtrap.io',
				  'port' => 2525,
				  'username' => '2504befe04af0b',
				  'password' => '031abbc9e34c05',
				  'className' => 'Smtp'
				]);
				$mailer = new Mailer('default');
				$mailer->setTransport('mailtrap');
				$mailer->setFrom(['mahmudulhasan661@gmail.com' => 'Mahmudul Hasan'])
			    ->setTo($myemail)
			    ->setEmailFormat('html')
			    ->setSubject('Verification')
			    ->deliver('Hello '.$myname.'<br/>Please click link below to reset your password<br/><br/><a href="http://localhost:8765/users/resetpassword/'.$mytoken.'">Reset Password</a>');
			}
		}
	}
	public function resetpassword($token)
	{
		if($this->request->is('post')){
			$hasher = new DefaultPasswordHasher();
			$mypass = $hasher->hash($this->request->getData('password'));

			$userTable = TableRegistry::get('Users');
			$user = $userTable->find('all')->where(['token'=>$token])->first();
			$user->password = $mypass;
			if ($userTable->save($user)) {
				return $this->redirect(['action'=>'login']);
			}
		}
	}
	public function login()
	{
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			else
			{
				$this->Flash->error('your username or password is incorrect');
			}
		}
	}
	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}
	public function register()
	{
		if($this->request->is('post')){
			$userTable = TableRegistry::get('Users');
			$user = $userTable->newEntity($this->request->getData());

			$hasher = new DefaultPasswordHasher();
			$myname = $this->request->getData('name');
			$myemail = $this->request->getData('email');
			$mypass = $this->request->getData('password');
			$mytoken = Security::hash(Security::randomBytes(32));

			$user->name = $myname;
			$user->email = $myemail;
			$user->password = $hasher->hash($mypass);
			$user->token = $mytoken;
			$user->created_at = date('Y-m-d H:i:s');
			$user->updated_at = date('Y-m-d H:i:s');
			if($userTable->save($user)){
				$this->Flash->set('Register successful, your confirmation email has been sent', ['alement'=>'success']);
				/*TransportFactory::setConfig('mailtrap', [
				  'host' => 'smtp.mailtrap.io',
				  'port' => 2525,
				  'username' => '2504befe04af0b',
				  'password' => '031abbc9e34c05',
				  'className' => 'Smtp'
				]);

				$email = new Email('default');
				$email->transport('mailtrap');
				$email->emailFormat('html');
				$email->form('mahmudulhasan661@gmail.com', 'Mahmudul Hasan');
				$email->subject('Please confirm to your email to activation your account');
				$email->to($myemail);
				$email->send('Hi'.$myname.'<br/>Please confirm your email link below<br/><a href="hhtp:://localhost:8765/users/verification/'.$mytoken.'">Verification Email</a><br/>Thank you for joining us');*/
				TransportFactory::setConfig('mailtrap', [
				  'host' => 'smtp.mailtrap.io',
				  'port' => 2525,
				  'username' => '2504befe04af0b',
				  'password' => '031abbc9e34c05',
				  'className' => 'Smtp'
				]);
				$mailer = new Mailer('default');
				$mailer->setTransport('mailtrap');
				$mailer->setFrom(['mahmudulhasan661@gmail.com' => 'My Site'])
			    ->setTo($myemail)
			    ->setEmailFormat('html')
			    ->setSubject('Verification')
			    ->deliver('Hi'.$myname.'<br/>Please confirm your email link below<br/><a href="http://localhost:8765/users/verification/'.$mytoken.'">Verification Email</a><br/>Thank you for joining us');
				
			}
			else
			{
				$this->Flash->set('Register failed, please try again', ['alement'=>'error']);
			}
		}
	}

	public function verification($token)
	{
		$userTable = TableRegistry::get('Users');
		$verify = $userTable->find('all')->where(['token'=>$token])->first();
		$verify->verified = '1';
		$userTable->save($verify);
	}
}