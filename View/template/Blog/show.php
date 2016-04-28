<?php if ($this->flash): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4><?= $this->title ?></h4><br>
        <p><?= $this->flash ?><p>
    </div>
<?php endif; ?>

<a class="btn btn-primary" href="<?= ROOT ?>/blogs/index">Go back to Overview</a>
<?php if ($this->request->session['user_id'] === $this->blog->getUser()->getId()): ?>
	<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#centry">Create New Entry</button>

	<!-- Modal to create entry-->
	<div class="modal fade" id="centry" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
			<form method="post" action="<?=ROOT?>/entry/add">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel">Create New Entry</h4>
	      	</div>
	      	<div class="modal-body">
				<div class="form-group"><label for="title">Title</label>
					<input type="text" class="form-control" name="title" id="title" placeholder="Enter a title for the entry" required="" maxlength="45">
				</div>
				<div class="form-group"><label for="content">Content</label>
					<textarea class="form-control" name="content" id="content" placeholder="Enter your Text here..." rows="10"></textarea>
				</div>
				<div class="form-group"><label for="category">Title</label>
					<select class="form-control" name="category">
						<?php foreach ($this->categories as $c): ?>
							<option value="<?= $c->getId() ?>"><?= $c->getName() ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control" name="blog_id" value="<?=$this->blog->getId()?>">
				</div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	<button type="submit" class="btn btn-primary">Save changes</button>
	      	</div>
		  </form>
	    </div>
	  </div>
	</div>
<?php endif; ?>

<h1><?= $this->h($this->blog->getName()) ?></h1>
<h5>Author: <?= $this->h($this->blog->getUser()->getNickname()) ?></h5>

<?php if ($this->entries): ?>
	<table class="table table-hover entry-table">
		<thead>
			<tr>
				<th>Title</th>
				<th>Date</th>
				<th>Category</th>
                <?php if ($this->request->session['user_id'] === $this->blog->getUser()->getId()): ?>
                    <th>Action</th>
                <?php endif; ?>
			</tr>
		</thead>
		<tbody>
		<?php foreach($this->entries as $entry): ?>
			<tr data-href="<?= ROOT ?>/entry/show?id=<?= $entry->getId() ?>">
				<td><?= $this->h($entry->getTitle()) ?></td>
				<td><?= $this->h($entry->getDate()) ?></td>
				<td><?= $this->h($entry->getCategory()->getName()) ?></td>
                <?php if ($this->request->session['user_id'] === $this->blog->getUser()->getId()): ?>
                    <td>
                        <a class="" href="<?=ROOT?>/entry/delete?id=<?=$entry->getId()?>"><i class="material-icons md-18">delete</i></a>
                        <a class="" href="<?=ROOT?>/entry/edit?id=<?=$entry->getId()?>"><i class="material-icons md-18">edit</i></a>
                    </td>
                <?php endif; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
	</table>
<?php else: ?>
	<h2>There are no posts yet :(</h2>
<?php endif; ?>
