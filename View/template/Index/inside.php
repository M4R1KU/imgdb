<?php include '../View/layout/flash.php' ?>
<h1>Hello <?= $this->request->session['nickname'] ?></h1>
<div class="personal-galleries row">
    <h4>Your personal galleries:</h4>
    <?php /** @var \MKWeb\ImgDB\Model\Entity\Gallery $gallery */
    if ($this->user_galleries):
        foreach ($this->user_galleries as $row): ?>
            <div class="row">
                <?php foreach ($row as $gallery): ?>
                    <div class="col s12 m4">
                        <div class="card z-depth-1-half">
                            <div class="card-content">
                        <span class="card-title wrapped"><a
                                href="/gallery/index?id=<?= $gallery->getId() ?>" class="title"><?= h($gallery->getName()); ?></a>
                            <i class="material-icons right privacy-icon tooltipped" data-position="bottom"
                               data-delay="50"
                               data-tooltip="<?= ((bool)$gallery->isPrivate()) === true ? 'I am a private gallery.' : 'I am a public gallery.' ?>">lock_<?= ((bool)$gallery->isPrivate()) === true ? 'outline' : 'open' ?></i></span>
                                <p class="wrapped description"><?= $gallery->getDescription(); ?></p>
                            </div>
                            <div class="card-action">
                                <a class="edit grey-text text-darken-4" onclick="editGallery(this, <?= $gallery->getId() ?>)"><i class="material-icons">edit</i></i></a>
                                <?= linkHelper('/gallery/delete?id=' . $gallery->getId(), '<i class="material-icons">delete</i></i>', ['class' => 'grey-text text-darken-4']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach;
    else : ?>
        <p>You don't have any personal galleries.</p>
    <?php endif; ?>
</div>
<div class="public-galleries row">
    <h4>Some public galleries:</h4>
    <?php /** @var \MKWeb\ImgDB\Model\Entity\Gallery $gallery */
    if ($this->public_galleries):
        foreach ($this->public_galleries as $row): ?>
            <div class="row">
                <?php foreach ($row as $gallery): ?>
                    <div class="col s12 m4">
                        <div class="card z-depth-1-half">
                            <div class="card-content">
                        <span class="card-title wrapped"><a
                                href="/gallery/index?id=<?= $gallery->getId() ?>"><?=h($gallery->getName()); ?></a>
                            <i class="material-icons right privacy-icon tooltipped" data-position="bottom"
                               data-delay="50"
                               data-tooltip="<?= ((bool)$gallery->isPrivate()) === true ? 'I am a private gallery.' : 'I am a public gallery.' ?>">lock_<?= ((bool)$gallery->isPrivate()) === true ? 'outline' : 'open' ?></i></span>
                                <p class="wrapped"><?= $gallery->getDescription(); ?></p>
                            </div>
                            <div class="card-action">
                                <?php if($gallery->getUser()->getId() == $this->request->session['user_id']) { ?>
                                    <a class="edit grey-text text-darken-4" onclick="editGallery(this, <?= $gallery->getId(); ?>)"><i class="material-icons">edit</i></i></a>
                                    <?= linkHelper('/gallery/delete?id=' . $gallery->getId(), '<i class="material-icons">delete</i></i>', ['class' => 'grey-text text-darken-4']); ?>
                                    <i class="material-icons right tooltipped" data-position="bottom"
                                       data-delay="50" data-tooltip="This gallery belongs to <?= h($gallery->getUser()->getNickname()) ?>">account_box</i>
                                <?php } else { ?>
                                    <i class="material-icons tooltipped" data-position="bottom"
                                       data-delay="50" data-tooltip="This gallery belongs to <?= h($gallery->getUser()->getNickname()) ?>">account_box</i>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach;
    else : ?>
        <p>There aren't any public galleries.</p>
    <?php endif; ?>
</div>
<div class="fixed-action-btn" style="bottom: 45px; right: 45px;">
    <a href="#add-gallery-modal" class="btn-floating btn-large waves-effect waves-light red add-gallery-modal-trigger">
        <i class="large material-icons">add</i>
    </a>
</div>

<!-- Modal Structure -->
<div id="add-gallery-modal" class="modal bottom-sheet">
    <div class="modal-content">
        <div class="row">
            <div class="col m6 offset-m3 s12">
                <h4>Add a new gallery.</h4>
                <form action="/gallery/add" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="gallery_add_name" id="gallery_add_name" maxlength="50" length="50">
                            <label for="gallery_add_name">Gallery Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="gallery_add_description" name="gallery_add_description"
                                      class="materialize-textarea" maxlength="500" length="500"></textarea>
                            <label for="gallery_add_description">Gallery Description</label>
                        </div>
                    </div>
                    <p>
                        <input type="checkbox" class="filled-in" id="filled-in-box" name="gallery_add_private"
                               checked="checked" value="private"/>
                        <label for="filled-in-box">Is a private gallery.</label>
                    </p>
                    <button class="btn waves-effect waves-light" type="submit" name="gallery_add_submit">
                        Submit<i class="material-icons right">send</i>
                    </button>
                    <button class="btn waves-effect waves-light" type="reset" name="gallery_add_reset" id="gallery_add_reset">
                        Reset<i class="material-icons right">close</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/js/gallery.js"></script>