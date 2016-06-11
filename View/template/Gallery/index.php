<?php include '../View/layout/flash.php' ?>
<?php /** @var MKWeb\ImgDB\Model\Gallery gallery */ ?>
<h1><?= $this->gallery->getName(); ?>
    <small>by <?= $this->gallery->getUser()->getNickname() ?></small>
</h1>
<p><?= $this->gallery->getDescription(); ?></p>
<div class="row gallery">
    <?php
    /**
     * @var MKWeb\ImgDB\Model\Image $image
     */
    foreach ($this->images as $image): ?>
        <div class="col l3 m6 s12 image-wrapper valign-wrapper">
            <a href="/image/show?id=<?= $image->getId() ?>">
                <img class="responsive-img valign hoverable center" src="<?= REL_THUMBNAIL_GALLERY_DIR . getGalleryHash($this->gallery) . '/' . $image->getFilePath() ?>">
            </a>
        </div>
    <?php endforeach; ?>
</div>
<?php if ($this->request->session['user_id'] == $this->gallery->getUser()->getId()): ?>
<div class="fixed-action-btn" style="bottom: 45px; right: 45px;">
    <a href="#add-image-modal" class="btn-floating btn-large waves-effect waves-light red add-image-modal-trigger">
        <i class="large material-icons">add</i>
    </a>
</div>

<!-- Modal Structure -->
<div id="add-image-modal" class="modal bottom-sheet">
    <div class="modal-content">
        <div class="row">
            <div class="col m6 offset-m3 s12">
                <h4>Add a new Image to the gallery.</h4>
                <form action="/image/add" method="post" enctype="multipart/form-data">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="image_add_file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" name="image_add_filename">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="image_add_tags_fields">Tags</label>
                            <input type="text" name="image_add_tags_field" id="image_add_tags_fields" placeholder="Enter additional tags separated by blanks.">
                        </div>
                    </div>
                    <input type="hidden" name="image_add_gallery_id" value="<?= $this->gallery->getId() ?>">
                    <button class="btn waves-effect waves-light" type="submit" name="image_add_submit">
                        Submit<i class="material-icons right">send</i>
                    </button>
                    <button class="btn waves-effect waves-light" type="reset" id="image_add_reset" name="image_add_reset">
                        Reset<i class="material-icons right">close</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>