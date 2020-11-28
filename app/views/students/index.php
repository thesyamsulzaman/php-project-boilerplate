<?php $this->start('body'); ?>

 <h1 class="text-center display-4">Students</h1>


<div class="table-responsive">
	<table class="table mt-5 table-striped table-hover">
	  <thead class="thead-dark">
	    <tr>
	      <th scope="col">Name</th>
	      <th scope="col">Major</th>
	      <th>Action</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php foreach($this->students as $student): ?>
	  		<tr>
 	  			<td>
		  			<a href="<?= PROJECT_ROOT?>students/details/<?= $student->id;?> " class="">
	  	  			<?= $student->displayName(); ?>
		  			</a>
 	  			</td>
	  			<td><?= $student->major; ?></td>
	  			<td>
	  				<a href="<?= PROJECT_ROOT; ?>students/delete/<?= $student->id; ?>" class="btn btn-danger" onclick="if(!confirm('Are You Sure')) return false"> Delete </a>
	  				<a href="<?= PROJECT_ROOT; ?>students/edit/<?= $student->id; ?>" class="btn btn-info"> Edit </a>
	  			</td>
	  		</tr>
	  	<?php endforeach; ?>

	  </tbody>
	</table>    
</div>

<?php $this->end(''); ?>