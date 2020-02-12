<div class="row">
	<div class="col-md-4 offset-md-4">
		<?php echo $this->Flash->render() ?>
		<div class="card">
			<h3 class="card-header">Login</h3>
			<div class="card-body">
				<?php echo $this->Form->create()?>
				<div class="form-group">
					<?php echo $this->Form->control('email', ['class'=>'form-control'])?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->control('password', ['class'=>'form-control'])?>
				</div>
				<?php
					echo $this->Form->button('Login', ['class'=>'btn btn-primary']);
					echo $this->Html->link('Register', ['action'=>'register'], ['class'=>'btn btn-success']);
					echo $this->Html->link('Forgot Password', ['action'=>'forgotpassword'], ['class'=>'btn btn-info']);
					echo $this->form->end();
				?>
			</div>
		</div>	
	</div>
</div>