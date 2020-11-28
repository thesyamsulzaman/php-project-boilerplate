<?php 

use Core\FormHelpers; 

?>
<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

	<h1 class="text-center">Login</h1>
	<form class="my-4 form center-form" method="POST" action="<?= PROJECT_ROOT; ?>user/login">
		<?= FormHelpers::displayErrors($this->displayErrors); ?>
		<div class="form-group">
	   <?= FormHelpers::csrf_input(); ?>
		</div>
		<?= FormHelpers::inputBlock("text", "Username", 'username', $this->login->username, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("password", "Password", 'password', $this->login->password, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::checkBoxBlock("Remember me", "remember_me", $this->login->getRememberMeChecked(), [], ['class' => 'form-group']); ?>
		<?= FormHelpers::submitBlock("Login",['class' => 'btn btn-primary btn-block'], ['class' => 'form-group']); ?>
		<p>You dont have the account ? <a href="<?= PROJECT_ROOT; ?>register/register"> Register</a></p>
	</form>

<?php $this->end(); ?>
