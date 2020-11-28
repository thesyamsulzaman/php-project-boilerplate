<?php 

	namespace App\Models;
	use Core\Model;
	use Core\Validators\RequiredValidator;
	use Core\Validators\MaxValidator;

	class Students extends Model {

		public $id, $user_id, $first_name, $last_name, $phone_number, $email, $address, $city, $major, $deleted = 0;
		public function __construct() {
			$table = "students";
			parent::__construct($table);
			$this->_softDelete = true;
		}
		
		public function validator() {
			$this->runValidation(new RequiredValidator($this, ['field' => 'first_name', 'message' => 'First Name is required']));
			$this->runValidation(new RequiredValidator($this, ['field' => 'last_name', 'message' => 'Last Name is required']));
			$this->runValidation(new RequiredValidator($this, ['field' => 'major', 'message' => 'You need to specify the major']));
		} 

		public function findAllByUserId($user_id, $params = []) {
			$conditions = [
				'conditions' => 'user_id = ?', 
				'bind' => [$user_id],
			];

			$conditions = array_merge($conditions, $params);
			return $this->find($conditions);
		}

		public function findByIdAndUserId($studentId, $userId, $params = []) {
			$conditions = [
				'conditions' => 'id = ? AND user_id = ?',
				'bind' => [$studentId, $userId],
			];
			$conditions = array_merge($conditions, $params);
			return $this->findFirst($conditions);
		}

		public function displayName() {
			return $this->first_name . ' ' . $this->last_name;
		}
	}
 ?>
