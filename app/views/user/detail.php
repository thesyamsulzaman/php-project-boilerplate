<?php $this->setSiteTitle("Charlie");  ?>
<?php $this->start('body');  ?>

<div class="card well" style="max-width: 500px; margin: 0 auto;">
	<div class="card-body">
		<a href="<?= PROJECT_ROOT ?>" class="btn btn-dark"> Back </a>
		<table class="table mt-4" >
			<thead>
		    <tr class="d-flex justify-content-center">
		      <th>
						<img class="profile_picture" src="<?= PICTURES . $this->user->profile_picture; ?>" alt="profile_picture" height="100"/>
					</th>
		    </tr>
			</thead>
		  <tbody>
		    <tr>
		      <th>Name : </th>
		      <td><?= $this->user->displayFullName(); ?></td>
		    </tr>
		    <tr>
		      <th>Email : </th>
		      <td><?= $this->user->email; ?></td>
		    </tr>
		    <tr>
		      <th>Username : </th>
		      <td><?= $this->user->username; ?></td>
		    </tr>
		  </tbody>
			<tbody>
				<tr>
					<th>
						<a href="<?=PROJECT_ROOT; ?>user/edit/<?= $this->user->id ?>" class="btn btn-small btn-success">Edit Profile</a>
					</th>
				</tr>
			</tbody>
		</table>
</div>
</div>



<?php $this->end(); ?>
