/**
 * Created by M4R1KU on 11.06.2016.
 */
function editGallery(btn, id){

    var card = $(btn).parent().parent();
    var desc = $(card).find('p.wrapped').html();
    var title = $(card).find('a.title').html();
    var isPrivate = $(card).find('.privacy-icon').html().indexOf('outline') > -1;

    var modal = $('#add-gallery-modal');

    $(modal).find('form').attr('action', '/gallery/edit?id=' + id);
    $(modal).find('#gallery_add_name').val(title);
    $(modal).find('#gallery_add_name').siblings('label').addClass('active');
    $(modal).find('#gallery_add_description').val(desc);
    $(modal).find('#gallery_add_description').siblings('label').addClass('active');
    $(modal).find('#gallery_add_reset').remove();
    $(modal).find('#filled-in-box').prop('checked', isPrivate);
    $(modal).openModal();
}