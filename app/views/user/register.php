<?php

use Core\FormHelpers;

?>
<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

	<h1 class="text-center">Register</h1>
	<form class="my-1 form center-form" method="POST" enctype="multipart/form-data" action="<?= PROJECT_ROOT; ?>user/register">
		<?= FormHelpers::displayErrors($this->displayErrors); ?>
		<div class="form-group">
	   <?= FormHelpers::csrf_input(); ?>
		</div>
		<?= FormHelpers::inputBlock("text", "First Name", 'first_name', $this->newUser->first_name, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("text", "Last Name", 'last_name', $this->newUser->last_name, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("text", "Username", 'username', $this->newUser->username, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("text", "Email", 'email', $this->newUser->email, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("password", "Password", 'password', $this->newUser->password, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("password", "Confirm Password", 'confirm_password', $this->newUser->getConfirmedPassword(), ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("file", "Profile Picture", 'profile_picture', $this->newUser->profile_picture, ['class' => 'form-control-file'], ['class' => 'form-group']); ?>
		<?= FormHelpers::submitBlock("Register", ['class' => 'btn btn-primary btn-block'], ['class' => 'form-group']); ?>
		<p>You already have an account ?  <a href="<?= PROJECT_ROOT; ?>user/login"> Login </a></p>
	</form>

<?php $this->end(); ?>
