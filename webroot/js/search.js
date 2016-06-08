$(function () {

    var searchBar = $('#search');

    $(searchBar).keyup(function () {
        var val = $(searchBar).val();
        removeOverlay();
        $('main').append('<div class="overlay"><div class="container"><div class="row" id="search-results"><h2>Search results:<i class="material-icons right" id="dismiss" onclick="removeOverlay()">close</i></h2></div></div></div>');
        var results = $('#search-results');
        $(results).append('<div class="progress"><div class="indeterminate"></div></div>');

        if (window.location.pathname.indexOf('/index') == 0) {
            $.ajax({
                url: '/ajax/gallery',
                method: 'POST',
                data: {needle: val},
                dataType: 'json',
                success: function (data) {
                    $(results).find('.progress').remove();
                    console.log(data);
                    if (data.length > 0) {
                        $.each(data, function (index, element) {
                            var row = $(results).append('<div class="row" id="' + index + '"></div>').find('#' + index);
                            $.each(element, function (i, e) {
                                $(row).append('<div class="col s12 m4"><div class="card z-depth-1-half"><div class="card-content"><span class="card-title"><a href="/gallery/index?id=' + e.gallery_id + '">' + e.name + '</a><i class="material-icons right privacy-icon tooltipped" data-position="bottom" data-delay="50" data-tooltip="' + (Boolean(e.private) == true ? 'I am a private gallery.' : 'I am a public gallery.') + '">lock_' + (Boolean(e.private) == true ? 'outline' : 'open') + '</i></span><p class="wrapped">' + e.description + '</p></div></div></div>');
                            });
                        });
                    } else {
                        $(results).append('<h3>No results for: ' + val + '<i class="material-icons no-results-icon">sentiment_dissatisfied</i></h3>')
                    }
                }

            });
        } else if (window.location.pathname.indexOf('/gallery') == 0) {
            var galleryId = getParam('id');
            $.ajax({
                url: '/ajax/image',
                method: 'POST',
                data: {
                    needle: val,
                    gallery_id: galleryId
                },
                dataType: 'json',
                success: function (data) {
                    var relThumbnailDir = '/galleries/thumbnail/';
                    $(results).find('.progress').remove();
                    console.log(data);
                    if (data.length > 0) {
                        $.each(data, function(i, e) {
                            //noinspection JSUnresolvedVariable
                            console.log(e.gallery_id);
                            $(results).append('<div class="col l3 m6 s12 image-wrapper valign-wrapper"><a href="/image/show?id=' + e.image_id + '"><img class="responsive-img valign hoverable" src="' + relThumbnailDir + e.hash + '/' + e.file_path + '"></a></div>');
                        });
                    } else {
                        $(results).append('<h3>No results for: ' + val + '<i class="material-icons no-results-icon">sentiment_dissatisfied</i></h3>')
                    }
                }
            });
        } else {
            removeOverlay();
        }
    });
});

$('#search').blur(function() {
    if ($(this).val() == "") {
        removeOverlay();
    }
});

function removeOverlay() {
    $('main').find('.overlay').remove();
}

function getParam(name) {
    if (window.location.href.indexOf('?') < 0) return [];
    var query = window.location.href.split('?')[1];
    var params = query.split('&');
    var result = [];
    for (var i = 0; i < params.length; i++) {
        var pair = params[i].split('=');
        if (name != '' && name == pair[0]) return pair[1];
        result[i] = pair;
    }
    return result;
}