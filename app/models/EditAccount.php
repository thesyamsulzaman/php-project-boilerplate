<?php 

namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class EditAccount extends Model {
	public $id, $username, $email ,$first_name, $last_name, $profile_picture, $password, $con;
	public function construct( ) {
		parent::__construct('tmp_fake');
	}

	public function validator() {
		// Name Validator
		$this->runValidation(new RequiredValidator($this, ['field' => 'first_name',  'message' => 'First Name is required']));
		$this->runValidation(new RequiredValidator($this, ['field' => 'last_name',  'message' => 'Last Name is required']));

		// Email Validator
		$this->runValidation(new RequiredValidator($this, ['field' => 'email',  'message' => 'Email is required']));
		$this->runValidation(new EmailValidator($this, ['field' => 'email',  'message' => 'Email is not valid']));

    // Username Validator
		$this->runValidation(new MinValidator($this, [ 'field' => 'username', 'rule' => 6,  'message' => 'Username must be atleast 6 characters' ]));
		$this->runValidation(new MaxValidator($this, [ 'field' => 'username', 'rule' => 12,  'message' => 'Username cannot be more than 12 characters' ]));
		$this->runValidation(new RequiredValidator($this, ['field' => 'username',  'message' => 'Username is required']));
		$this->runValidation(new UniqueValidator($this, ['field' => 'username', 'message' => 'That username already exists, please choosse something else']));

		// Profile Picture Validator
		$this->runValidation(new RequiredValidator($this, ['field' => 'profile_picture', 'message' => 'Profile Picture is required']));
		$this->runValidation(new FileSizeValidator($this, ['field' => 'profile_picture', 'rule' => 500 ,'message' => 'File is too big, file should be less than 500kb']));
		$this->runValidation(new FileExtensionValidator($this, ['field' => 'profile_picture', 'rule' => ['jpg', 'png', 'jpeg'] , 'message' => 'File is not valid, try using png, jpeg or jpg']));

	}



}

 ?>