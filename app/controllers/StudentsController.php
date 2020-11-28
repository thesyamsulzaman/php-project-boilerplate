<?php 

namespace App\Controllers;
use Core\Controller;
use Core\Session;
use Core\Router;
use App\Models\Students;
use App\Models\Users;


class StudentsController extends Controller {

	public function __construct($controller, $action_name) {
		parent::__construct($controller, $action_name);
		$this->view->setLayout('default');
		$this->load_model("Students");
	}

	public function indexAction() {

		$students = $this->StudentsModel->findAllByUserId(Users::currentUser()->id, ['order' => 'first_name, last_name']);
		$this->view->students = $students;
		$this->view->render('students/index');
	}

	public function addAction() {
		$student = new Students();

		if ($this->request->isPost()) {
			$this->request->csrfCheck();
			$student->assign($this->request->get()); 
			$student->user_id = Users::currentUser()->id;
 			if ($student->save()) {
        Session::addDisplayMessage("success", "Successfully added");
  			Router::redirect('students');
 			}
		}
		$this->view->student = $student;
		$this->view->displayErrors = $student->getErrorMessages();
		$this->view->postAction = PROJECT_ROOT . DS . 'add';
		$this->view->render('students/add');
	}

	public function editAction($id) {
		$student = $this->StudentsModel->findByIdAndUserId((int) $id, Users::currentUser()->id);
		if (!$student) Router::redirect('students');

		if ($this->request->isPost()) {
			$student->assign($this->request->get()); 
 			if ($student->save()) {
        Session::addDisplayMessage("success", "Successfully edited");
 				Router::redirect('students');
 			}
		}

		$this->view->student = $student;
		$this->view->displayErrors = $student->getErrorMessages();
		$this->view->postAction = PROJECT_ROOT . 'students' . DS . 'edit' . DS . $student->id;
		$this->view->render('students/edit');

	}

	public function detailsAction($id) {
		$student = $this->StudentsModel->findByIdAndUserId((int) $id, Users::currentUser()->id);
		if (!$student) {
			Router::redirect('students');
		}
		$this->view->student = $student;
		$this->view->render('students/details');
	}

	public function deleteAction($id) {
		$student = $this->StudentsModel->findByIdAndUserId((int) $id, Users::currentUser()->id);
		if ($student) {
			$student->delete();
      Session::addDisplayMessage("success", "Successfully deleted");
		}
		Router::redirect('students');
	}


} 


 ?>
