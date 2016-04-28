<form method="post" action="<?=ROOT?>/comment/edit?id=<?=$this->comment->getId()?>">
    <div class="form-group"><label for="comment">Content</label>
        <textarea class="form-control" name="comment" id="comment" rows="10"><?= str_replace('<br />', "\n", $this->comment->getComment()) ?></textarea>
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="entry_id" value="<?=$this->comment->getEntry()->getId()?>">
    </div>
    <button type="submit" class="btn btn-primary">Save changes</button>
</form>
