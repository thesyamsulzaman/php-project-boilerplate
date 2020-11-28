<?php $this->setSiteTitle($this->student->displayName());  ?>
<?php $this->start('body');  ?>

<div class="card well" style="max-width: 400px; margin: 0 auto;">
	<div class="card-body">
		<a href="<?= PROJECT_ROOT ?>/students" class="btn btn-dark"> Back </a>
		<table class="table mt-4" >
		  <tbody>
		    <tr>
		      <th>Name : </th>
		      <td><?= $this->student->displayName(); ?></td>
		    </tr>
		    <tr>
		      <th>Email : </th>
		      <td><?= $this->student->email; ?></td>
		    </tr>
		    <tr>
		      <th>Address : </th>
		      <td><?= $this->student->address; ?></td>
		    </tr>
		    <tr>
		      <th>City : </th>
		      <td><?= $this->student->city; ?></td>
		    </tr>
		    <tr>
		      <th>Phone Number : </th>
		      <td><?= $this->student->phone_number; ?></td>
		    </tr>
		    <tr>
		      <th>Major : </th>
		      <td><?= $this->student->major; ?></td>
		    </tr>
		  </tbody>
		</table>	
</div>
</div>



<?php $this->end(); ?>