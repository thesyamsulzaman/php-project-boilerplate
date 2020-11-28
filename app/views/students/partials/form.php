<?php 

use Core\FormHelpers; 

?>
<form class="form mt-4 col-md-8 card py-3" style="margin: 0 auto; background-color: #eeeeee;" action="<?php $this->postAction; ?>" method="POST">
	<?= FormHelpers::displayErrors($this->displayErrors); ?>
	<div class="form-group">
   <?= FormHelpers::csrf_input(); ?>
	</div>
	<div class="row card-body ">
		<?= FormHelpers::inputBlock('text', 'First Name', 'first_name', $this->student->first_name, ['class' => 'form-control'], ['class' => 'form-group col-md-6']); ?>
		<?= FormHelpers::inputBlock('text', 'Last Name', 'last_name', $this->student->last_name, ['class' => 'form-control'], ['class' => 'form-group col-md-6']); ?>
		<?= FormHelpers::inputBlock('email', 'Email ', 'email', $this->student->email, ['class' => 'form-control'], ['class' => 'form-group col-md-4']); ?>
		<?= FormHelpers::inputBlock('text', 'Address ', 'address', $this->student->address, ['class' => 'form-control'], ['class' => 'form-group col-md-4']); ?>
		<?= FormHelpers::inputBlock('text', 'City ', 'city', $this->student->city, ['class' => 'form-control'], ['class' => 'form-group col-md-4']); ?>
		<?= FormHelpers::inputBlock('text', 'Phone Number ', 'phone_number', $this->student->phone_number, ['class' => 'form-control'], ['class' => 'form-group col-md-6']); ?>
		<?= FormHelpers::inputBlock('text', 'Major ', 'major', $this->student->major, ['class' => 'form-control'], ['class' => 'form-group col-md-6']); ?>
		<div class="col-md-12 text-right">
			<a href="<?= PROJECT_ROOT . 'students' ?>" class="btn btn-dark">Cancel</a>
			<?= FormHelpers::submitTag("Save", ['class' => 'btn btn-primary ']); ?>
		</div>

	</div>
</form>