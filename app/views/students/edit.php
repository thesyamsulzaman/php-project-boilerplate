<?php $this->start('body'); ?>

<div>
	<h2 class="text-center"> Update <?= $this->student->displayName(); ?> </h2>
	<?php $this->partial('students', 'form'); ?>
</div>

<?php $this->end(); ?>


