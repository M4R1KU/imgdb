<h1>Hello <?= $this->request->session['nickname'] ?></h1>
<div class="personal-galleries row">
    <h4>Your personal galleries:</h4>
    <?php /** @var \MKWeb\ImgDB\Model\Gallery $gallery */
    foreach ($this->user_galleries as $row): ?>
    <div class="row">
        <?php foreach ($row as $gallery): ?>
            <div class="col s4">
                <div class="card z-depth-1-half">
                    <div class="card-content">
                        <span class="card-title"><a href="<?= ROOT ?>/gallery/index?id=<?= $gallery->getId() ?>" ><?= $gallery->getName(); ?></a>
                            <i class="material-icons right privacy-icon tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?= ((bool) $gallery->getPrivate()) === true ? 'I am a private gallery.' : 'I am a public gallery.' ?>">lock_<?= ((bool) $gallery->getPrivate()) === true ? 'outline' : 'open' ?></i></span>
                        <p><?= $gallery->getDescription(); ?></p>
                    </div>
                    <div class="card-action">
                        <?= linkHelper('/gallery/edit?id=' . $gallery->getId(), '<i class="material-icons">edit</i></i>', ['class' => 'grey-text text-darken-4']) ?>
                        <?= linkHelper('/gallery/delete?id=' . $gallery->getId(), '<i class="material-icons">delete</i></i>', ['class' => 'grey-text text-darken-4']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
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
                <form action="<?= ROOT ?>/gallery/add" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="gallery_add_name" id="gallery_add_name">
                            <label for="gallery_add_name">Gallery Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="gallery_add_description" name="gallery_add_description" class="materialize-textarea" maxlength="500" length="500"></textarea>
                            <label for="gallery_add_description">Gallery Description</label>
                        </div>
                    </div>
                    <p>
                        <input type="checkbox" class="filled-in" id="filled-in-box" name="gallery_add_private" checked="checked" value="private"/>
                        <label for="filled-in-box">Is a private gallery.</label>
                    </p>
                    <button class="btn waves-effect waves-light" type="submit" name="gallery_add_submit">
                        Submit<i class="material-icons right">send</i>
                    </button>
                    <button class="btn waves-effect waves-light" type="reset" name="gallery_add_submit">
                        Reset<i class="material-icons right">close</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>