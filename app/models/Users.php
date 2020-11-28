<?php

	namespace App\Models;

	use Core\Model;
	use Core\Cookie;
	use Core\Session;
	use Core\Helpers;

	use App\Models\UserSessions;
	use App\Models\Users;

	use Core\Validators\RequiredValidator;
	use Core\Validators\MinValidator;
	use Core\Validators\MaxValidator;
	use Core\Validators\UniqueValidator;
	use Core\Validators\EmailValidator;
	use Core\Validators\MatchesValidator;
	use Core\Validators\FileExtensionValidator;
	use Core\Validators\FileSizeValidator;


	class Users extends Model {
		private $_isLoggedIn, $_sessionName, $_cookieName, $_confirmedPassword;
		public static $currentLoggedInUser = null;

    // Table field as a method
		public $id, $username, $email, $password, $first_name, $last_name, $access_control_level, $profile_picture, $deleted = 0;

		public function __construct($user = "") {
			$table = "users";
			parent::__construct($table);
			$this->_sessionName = CURRENT_USER_SESSION_NAME;
			$this->_cookieName = REMEMBER_ME_COOKIE_NAME;
			$this->_softDelete = true;
			if (!$user == "") {
				if (is_int($user)) {
					$u = $this->_db->findFirst(
						'users', [
							"conditions" => 'id = ?',
							"bind" => [$user]],
							'App\Models\Users'
						);
				} else {
					$u = $this->_db->findFirst(
						'users',
						[
							"conditions" => "username = ?",
							"bind" => [$user]],
							'App\Models\Users'
						);
				}

				if ($u) {
					foreach ($u as $key => $value) {
						$this->$key = $value;
					}
				}
			}
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

			// Password Validator
			$this->runValidation(new RequiredValidator($this, ['field' => 'password',  'message' => 'Password cannot be empty ']));

			// Profile Picture Validator
			$this->runValidation(new FileSizeValidator($this, ['field' => 'profile_picture', 'rule' => 500 ,'message' => 'File is too big, file should be less than 500kb']));
 			$this->runValidation(new FileExtensionValidator($this, ['field' => 'profile_picture', 'rule' => ['jpg', 'png', 'jpeg'] , 'message' => 'File is not valid, try using png, jpeg or jpg']));

			if ($this->isNew()) {
  			$this->runValidation(new MatchesValidator($this, ['field' => 'password', 'rule' => $this->_confirmedPassword, 'message' => "Password should matches"]));
			  $this->runValidation(new UniqueValidator($this, ['field' => 'username', 'message' => 'That username already exists, please choosse something else']));
				$this->runValidation(new MinValidator($this, [ 'field' => 'password', 'rule' => 6,  'message' => 'Password must be atleast 6 characters' ]));
				$this->runValidation(new MaxValidator($this, [ 'field' => 'password', 'rule' => 12,  'message' => 'Password cannot be more than 12 characters' ]));
  			$this->runValidation(new RequiredValidator($this, ['field' => 'profile_picture', 'message' => 'Profile Picture is required']));
			}

		}

		public function beforeSave() {
			if ($this->isNew()) {
  			$this->password = password_hash($this->password, PASSWORD_DEFAULT);
				Helpers::dnd("Picture has been uploaded");
			  $this->saveProfilePicture();
			} else if (!$this->isNew()) {
				Helpers::dnd("Picture has been uploaded");
			  $this->saveProfilePicture();
			}
		}

		public function findByUsername($username) {
			$user = $this->findFirst(['conditions' => "username = ? ", "bind" => [$username]]);
			return $user;
		}


		public function findById($id) {
			$user = $this->findFirst(['conditions' => "id = ? ", "bind" => [$id]]);
			return $user;
		}

		public static function currentUser() {if (!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
				$U = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
				self::$currentLoggedInUser = $U;
			}
			// return self::$currentLoggedInUser;
			return self::$currentLoggedInUser;
		}

		public function login($rememberMe = false) {
			Session::set($this->_sessionName, $this->id);
			if ($rememberMe) {
				$hash = md5(uniqid());
				$user_agent = Session::user_agent_no_version();
				Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
				$fields = ['session' => $hash, "user_agent" => $user_agent, 'user_id' => $this->id];
				$this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
				$this->_db->insert("user_sessions", $fields);
			}
		}

	  public static function loginUserFromCookie() {
	  	$user_session = UserSessions::getFromCookie();
	    if ($user_session && $user_session->user_id != '') {
	    	$user = new self((int) $user_session->user_id);
		    if ($user) {
		      $user->login();
		    }
	    }
	    return;

	  }

		public function logout() {
			$userSession = UserSessions::getFromCookie();
			if ($userSession) $userSession->delete();
			Session::delete(CURRENT_USER_SESSION_NAME);
			if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
				Cookie::delete(REMEMBER_ME_COOKIE_NAME);
			}
			self::$currentLoggedInUser = null;
			return true;
		}

		public function setProfilePicture() {
		  $fileName = $_FILES["profile_picture"]["name"];
		  $tmpName = $_FILES["profile_picture"]["tmp_name"];
		  $errorLog = $_FILES["profile_picture"]["error"];
			$fileNameArray = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameArray));
			$newFileName = uniqid() . "." . $fileExtension;

			if ($this->isNew()) {
			  $this->profile_picture = ($errorLog == 0 ? $newFileName : "");
			} else {
			  $this->profile_picture = ($errorLog == 0 ? $newFileName : $this->profile_picture);
			}
			Helpers::dnd($this->profile_picture);
			return;
		}

		public function saveProfilePicture() {
		  $tmpName = $_FILES["profile_picture"]["tmp_name"];
		  move_uploaded_file($tmpName, MEDIA_FILES_PICTURES . $this->profile_picture);
			return;
		}

		public function acls() {
			if (empty($this->acl)) return [];
	    return json_decode($this->acl, true);
		}

		public function setConfirmedPassword($value) {
			$this->_confirmedPassword = $value;
		}

		public function getConfirmedPassword() {
			return $this->_confirmedPassword;
		}

		public function getUserId() {
			return $this->id;
		}

		public function displayFullName() {
			return $this->first_name . ' ' . $this->last_name;
		}

		public static function getProfilePicture() {
			return $this->profile_picture;
		}

	}


 ?>
