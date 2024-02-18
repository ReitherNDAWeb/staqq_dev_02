var removed = [];

function filterBundeslaenderBezirke(init){

    var choosen = parseInt(jQuery('select#bundeslaender').val());

    jQuery('select#bezirke').append(removed);
    removed = jQuery('select#bezirke option:not([data-bundesland="'+choosen+'"]):not([disabled])');
    jQuery('select#bezirke option:not([data-bundesland="'+choosen+'"]):not([disabled])').remove();

    if (!init) jQuery('select#bezirke').val("");
}

jQuery(document).ready(function(){
    
    jQuery('select#bundeslaender').change(function(){
        filterBundeslaenderBezirke();
    });
    
    filterBundeslaenderBezirke(true);
});