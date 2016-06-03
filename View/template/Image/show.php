<?php include '../View/layout/flash.php' ?>
<h1>Image</h1>
<div class="row">
    <?= linkHelper('/gallery/index?id=' . $this->gallery->getId(), 'Back to Gallery', ['class' => 'btn']) ?>
</div>
<div class="row">
    <div class="col l10 m10 s12">
        <img class="responsive-img" src="<?= REL_FINAL_GALLERY_DIR . getGalleryHash($this->gallery) . '/' . $this->currentImage->getFilePath(); ?>">
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
            if (count($this->tags) > 0):
                foreach ($this->tags as $tag): ?>
                    <div class="chip"><?= $tag->getName() ?></div>
                <?php endforeach;
            endif; ?>
        </div>

    </div>
</div>