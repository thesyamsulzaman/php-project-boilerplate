
<?php

use Core\FormHelpers;

?>
<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

	<form class="my-1 form center-form" method="POST" enctype="multipart/form-data" action="<?= PROJECT_ROOT; ?>register/edit/<?= $this->user->id ?>">
    <div class="form-group d-flex justify-content-center">
		 <img class="profile_picture" src="<?= PICTURES . $this->user->profile_picture; ?>" alt="profile_picture" height="100"/>
    </div>
	  <h1 class="text-center my-4">Edit <?= $this->user->displayFullName(); ?></h1>
		<?= FormHelpers::displayErrors($this->displayErrors); ?>
		<div class="form-group">
	   <?= FormHelpers::csrf_input(); ?>
		</div>
		<?= FormHelpers::inputBlock("text", "First Name", 'first_name', $this->user->first_name, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("text", "Last Name", 'last_name', $this->user->last_name, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("text", "Username", 'username', $this->user->username, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("text", "Email", 'email', $this->user->email, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
		<?= FormHelpers::inputBlock("file", "Profile Picture", 'profile_picture', "", ['class' => 'form-control-file'], ['class' => 'form-group']); ?>
		<?= FormHelpers::submitBlock("Edit", ['class' => 'btn btn-primary btn-block'], ['class' => 'form-group']); ?>
		<a class="btn btn-danger btn-block"href="<?= PROJECT_ROOT; ?>register/detail/<?= $this->user->id ?>"> Cancel </a></p>
	</form>

<?php $this->end(); ?>
