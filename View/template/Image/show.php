<?php include '../View/layout/flash.php' ?>
<h1>Image</h1>
<div class="row">
    <?= linkHelper('/gallery/index?id=' . $this->gallery->getId(), 'Back to Gallery', ['class' => 'btn']) ?>
</div>
<div class="row">
    <div class="col l10 m10 s12" id="image-show">
        <img class="responsive-img"
             src="<?= REL_FINAL_GALLERY_DIR . getGalleryHash($this->gallery) . '/' . $this->currentImage->getFilePath(); ?>">
    </div>
    <div class="col l2 m2 s12">
        <div class="row">
            <?php if ($this->prevImage === null): ?>
                <a class="btn disabled col l6 m12 s6"><i class="material-icons">arrow_back</i></a>
            <?php else: ?>
                <?= linkHelper('/image/show?id=' . $this->prevImage->getId(), '<i class="material-icons">arrow_back</i>', ['class' => ['btn', 'col', 'l6', 'm12', 's6']]) ?>
            <?php endif; ?>
            <?php if ($this->nextImage === null): ?>
                <a class="btn disabled col l6 m12 s6"><i class="material-icons">arrow_forward</i></a>
            <?php else: ?>
                <?= linkHelper('/image/show?id=' . $this->nextImage->getId(), '<i class="material-icons">arrow_forward</i>', ['class' => ['btn', 'col', 'l6', 'm12', 's6']]) ?>
            <?php endif; ?>
        </div>
        <div class="row tags">
            <?php
            /** @var MKWeb\ImgDB\Model\Entity\Tag $tag */
            if (count($this->tags) > 0):
                foreach ($this->tags as $tag): ?>
                    <div class="chip"><?= h($tag->getName()) ?></div>
                <?php endforeach;
            else: ?>
                <p>This image does not have tags.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <h3>Information</h3>
    <form class="col s12" action="/image/edit" method="post">
        <div class="row">
            <div class="input-field col s12">
                <input name="image_edit_title" id="image_edit_title" type="text" class="validate" <?= ($this->currentImage->getTitle() != null || strlen($this->currentImage->getTitle()) > 0) ? 'value="' . h($this->currentImage->getTitle()) . '"' : '' ?>>
                <label for="image_edit_title">Title</label>
            </div>
                <div class="input-field col s12">
                    <textarea id="image_edit_description" name="image_edit_description"
                                      class="materialize-textarea" maxlength="100" length="100"><?= h($this->currentImage->getDescription()) ?></textarea>
                <label for="gallery_add_description">Image Description</label>
            </div>
            <input type="hidden" id="image_edit_id" name="image_edit_id" value="<?= $this->currentImage->getId() ?>">
        </div>
        <div class="row">
            <button class="btn waves-effect waves-light" type="submit" name="image_edit_submit">
                Save<i class="material-icons right">send</i>
            </button>
            <a class="btn right" href="/image/delete?id=<?= $this->currentImage->getId() ?>">Delete<i class="material-icons right">delete</i></a>
        </div>
    </form>
</div>