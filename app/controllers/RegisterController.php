<?php

namespace App\Controllers;
use Core\Controller;
use Core\Router;
use Core\Session;
use Core\Helpers;

use App\Models\Users;
use App\Models\Login;
use App\Models\EditAccount;

class RegisterController extends Controller {
	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
    $this->load_model('Users');
	}
	
	public function editAction($id) {
		$user = $this->UsersModel->findById($id);
		$user->assign($this->request->get());
		if ($this->request->isPost()) {
  		$user->setProfilePicture();
			if ($user->save()) {
				Router::redirect("register/detail/{$id}");
			}
		}

		$this->view->user = $user;
		$this->view->displayErrors = $user->getErrorMessages();
		$this->view->render('register/edit');
	}

	public function detailAction($id) {
		$user = $this->UsersModel->findById($id);
		$this->view->user = $user;
		$this->view->render('register/detail');
	}

  public function registerAction() {
  	$newUser = new Users();

		if ($this->request->isPost()) {
			$this->request->csrfCheck();
			$newUser->setProfilePicture();
			$newUser->assign($this->request->get());
			$newUser->setConfirmedPassword($this->request->get('confirm_password'));
			if ($newUser->save()) {
				Router::redirect("register/login");
			}
		}

		$this->view->newUser = $newUser;
		$this->view->displayErrors = $newUser->getErrorMessages();
  	$this->view->render('register/register');
  }

	public function loginAction() {
		$loginModel = new Login();
		if ($this->request->isPost()) {
			$this->request->csrfCheck();
			$loginModel->assign($this->request->get());
			$loginModel->validator();

			if ($loginModel->validationPassed()) {
				$user = $this->UsersModel->findByUsername($_POST["username"]);
				if ($user && password_verify($this->request->get("password"), $user->password)) {
					// $remember = (isset($this->request->get()['remember_me']) && $loginModel->remember_me) ? true : false ;
					$remember = $loginModel->getRememberMeChecked();
					$user->login($remember);
					Router::redirect('');
				} else {
					$loginModel->addErrorMessage('username', 'there is something wrong with the username or password');
				}
			}
		}
		$this->view->login = $loginModel;
		$this->view->displayErrors = $loginModel->getErrorMessages();
		$this->view->render('register/login');
	}

	public function logoutAction() {
		if (Users::currentUser()) {
			Users::currentUser()->logout();
		}
		Router::redirect("register/login");
	}

}

?>
