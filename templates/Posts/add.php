<div class="row">
	<div class="col-md-6 offset-md-4">
		<div class="card">
			<div class="card-body">
				<?php echo $this->Form->create($posts) ?>
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control">
					</div>
					<div class="form-group">
						<label>Detail</label>
						<textarea name="detail" class="form-control"></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
					<?php echo $this->Html->link('Back',['action'=>'index'],['class'=>'btn btn-success']); ?>
				<?php echo $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>