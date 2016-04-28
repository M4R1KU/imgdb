<?php if ($this->flash): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4><?= $this->title ?></h4><br>
        <p><?= $this->flash ?><p>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-4">
	   <h1>Blogs</h1>
    </div>
    <div class="col-sm-4 col-sm-offset-4">
	   <button type="button" class="btn btn-primary btn-lg btn-cblog" data-toggle="modal" data-target="#cblog">
		      Create Blog
	   </button>
    </div>
</div>
<div class="b-content container-fluid">
<?php if($this->blogs): ?>
	<?php foreach($this->blogs as $blog): ?>
		<div>
			<h3><a href="<?= ROOT; ?>/blog/show?id=<?= $blog->getId(); ?>"><?= $this->h($blog->getName()) ?></a><h3>
			<h5><?= $this->h($blog->getUser()->getNickname()) ?></h5>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<h2>There are no Blogs yet :(</h2>
	<h5>Create your first!</h5>
<?php endif; ?>
</div>

<div class="modal fade" id="cblog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form method="post" action="<?=ROOT?>/blogs/add">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="myModalLabel">Create New Blog</h4>
      	</div>
      	<div class="modal-body">
			<div class="form-group"><label for="name">E-Mail</label>
				<input type="text" class="form-control" name="name" id="name" placeholder="Enter a Blog Name" required="" maxlength="45">
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
