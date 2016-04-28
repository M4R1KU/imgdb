<form method="post" action="<?=ROOT?>/entry/edit?id=<?=$this->entry->getId()?>">
    <div class="form-group"><label for="title">Title</label>
        <input type="text" class="form-control" name="title" id="title" value="<?= $this->h($this->entry->getTitle()) ?>" required="" maxlength="45">
    </div>
    <div class="form-group"><label for="content">Content</label>
        <textarea class="form-control" name="content" id="content" rows="10"><?= str_replace('<br />', "\n", $this->entry->getContent()) ?></textarea>
    </div>
    <div class="form-group"><label for="category">Title</label>
        <select class="form-control" name="category">
            <?php foreach ($this->categories as $c): ?>
                <option value="<?= $c->getId() ?>"><?= $c->getName() ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $this->csrfToken ?>">
        <input type="hidden" class="form-control" name="blog_id" value="<?=$this->entry->getBlog()->getId()?>">
    </div>
    <button type="submit" class="btn btn-primary">Save changes</button>
</form>