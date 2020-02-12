<div class="row">
	<div class="col-md-6 offset-md-3">
		<?= $this->Flash->render() ?>
		<div class="card">
			<h3 class="card-header">Register</h3>
			<div class="card-body">
				<?php echo $this->Form->create() ?>
				<div class="form-group">
					<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'])?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->control('email', ['class'=>'form-control', 'required'])?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->control('password', ['class'=>'form-control', 'required'])?>
				</div>
				<?php
					echo $this->Form->button('Register',['class'=>'btn btn-primary']);
					echo $this->Form->end();
				?>
			</div>
		</div>
	</div>
</div>