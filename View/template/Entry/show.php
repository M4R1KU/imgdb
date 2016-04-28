<?php if ($this->flash): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4><?= $this->h($this->title) ?></h4><br>
        <p><?= $this->h($this->flash) ?><p>
    </div>
<?php endif; ?>
<a class="btn btn-primary" href="<?= ROOT ?>/blog/show?id=<?= $this->entry->getBlog()->getId() ?>">Go back to Blog</a>
<?php if ($this->entry->getBlog()->getUser()->getId() !== $this->request->session['user_id']): ?>
    <button class="pull-right btn btn-primary" data-toggle="modal" data-target="#wcomment">Write comment</button>
<?php endif; ?>
<h1><?= $this->h($this->entry->getTitle()) ?><small> #<?= $this->h($this->entry->getCategory()->getName()) ?></small></h1>
<div class="row">
	<div class="col-xs-6">
		<h4><i class="material-icons">schedule</i><br><?= $this->entry->getDate()?></h4>
	</div>
	<div class="col-xs-6">
		<h4 class="text-right">
			<i class="material-icons">face</i><br>Written by
			<a href="<?= ROOT ?>/blog/show?id=<?= $this->entry->getBlog()->getId() ?>"><?= $this->h($this->entry->getBlog()->getUser()->getNickname()) ?></a>
		</h4>
	</div>
</div>
<div class="row">
	<div class="col-lg-10 col-lg-offset-1 entry-content well">
		<?= $this->entry->getContent() ?>
	</div>
</div>
<div class="row">
	<div class="col-lg-10 col-lg-offset-1 comment-section">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Comments</h2>
			</div>
			<div class="panel-body">
			<?php if ($this->comments): ?>
				<?php foreach($this->comments as $c): ?>
					<div class="list-group-item">
						<h4 class="comname"><i class="material-icons">face</i><?= $this->h($c->getUser()->getNickname()) ?> </h4>
                        <?php if ($this->request->session['user_id'] === $c->getEntry()->getBlog()->getUser()->getId() || $this->request->session['user_id'] === $c->getUser()->getId()): ?>
                            <div class="ceditbtn">
                                <a class="btn btn-default" href="<?=ROOT?>/comment/delete?id=<?=$c->getId()?>"><i class="material-icons">delete</i></a>
                                <?php if ($this->request->session['user_id'] === $c->getUser()->getId()): ?>
                                    <a class="btn btn-default" href="<?=ROOT?>/comment/edit?id=<?=$c->getId()?>"><i class="material-icons">edit</i></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
						<p><?= $c->getComment() ?></p>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<h4>There are no Comments for this Entry</h4>
			<?php endif; ?>
		</div>
		</div>
	</div>
</div>

<!-- Write comment modal -->
<div class="modal fade" id="wcomment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form method="post" action="<?=ROOT?>/comment/add">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="myModalLabel">Write a Comment</h4>
      	</div>
      	<div class="modal-body">
			<div class="form-group"><label for="comment">Comment</label>
				<textarea class="form-control" name="comment" id="comment" placeholder="Enter your comment" required="" rows="8"></textarea>
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" name="entry_id" id="entry_id" value="<?= $this->entry->getId() ?>">
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
