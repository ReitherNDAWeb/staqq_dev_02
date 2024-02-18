var addedSkills = [];
var removedSkills = [];

function removeSkillFromList(id){
    addedSkills.splice(addedSkills.indexOf(id), 1);
    jQuery('.selected-skills .selected-skills__item[data-id='+id+']').remove();
}

function filterKategorienSkills(){
        var kat = jQuery('#skill-chooser__kategorie option:selected').data('kategorie');
	
        jQuery('#skill-chooser__items').append(removedSkills);
        removedSkills = jQuery('#skill-chooser__items option:not([data-kategorie="'+kat+'"])');
	
        jQuery('#skill-chooser__items option:not([data-kategorie="'+kat+'"])').remove();

        jQuery('#skill-chooser__items').val(jQuery(jQuery('#skill-chooser__items option[data-kategorie="'+kat+'"]')[0]).val()) ;
		jQuery('#skill-chooser__items').multipleSelect();
		jQuery('#skill-chooser__items').multipleSelect('uncheckAll');
}

jQuery(document).ready(function(){

	jQuery('#skill-chooser__items').multipleSelect({placeholder: "Skills wählen", selectAllText: "Alle auswählen", allSelected: "Alle ausgewählt", countSelected: "# von % ausgewählt"});

    jQuery('#skill-chooser__add').click(function(){
		
		var ids = jQuery('#skill-chooser__items').multipleSelect('getSelects');
		var names = jQuery('#skill-chooser__items').multipleSelect('getSelects', 'text');
		
		for (var i=0;i<ids.length;i++){

			var id = parseInt(ids[i]);
			var name = names[i];

			if (addedSkills.indexOf(id) < 0){
				addedSkills.push(id);
				jQuery('.selected-skills').append('<p class="selected-skills__item" data-id="'+id+'"><input type="hidden" class="skills" name="skills[]" value="'+id+'"><span class="name">'+name+'</span><span class="select-wrapper"><select name="skills_praedikat_'+id+'"><option value="kann">kann</option><option value="soll">soll</option><option value="muss">muss</option></select></span><button type="button" onclick="removeSkillFromList('+id+')">X</button></p>');
			}
		}
    });

    jQuery('#skill-chooser__kategorie').change(function(){
        filterKategorienSkills();
    });
    
    filterKategorienSkills();
    
	jQuery('.selected-skills .selected-skills__item').each(function(){
		addedSkills.push(jQuery(this).data('id'));
	});
	
});




var addedRegionen = [];
var removedRegionen = [];

function removeRegionFromList(id){
    addedRegionen.splice(addedRegionen.indexOf(id), 1);
    jQuery('.selected-regionen .selected-regionen__item[data-id='+id+']').remove(); 
}

function removeAlleRegionenWien(ids){
	
	jQuery('.selected-regionen__item--wien').remove();
	
	for(var i=0;i<ids.length;i++){
		removeRegionFromList(ids[i]);
	}
}

function filterKategorienRegionen(){
        var kat = jQuery('#region-chooser__kategorie option:selected').data('kategorie');
	
        jQuery('#region-chooser__items').append(removedRegionen);
        removedRegionen = jQuery('#region-chooser__items option:not([data-kategorie="'+kat+'"])');
	
        jQuery('#region-chooser__items option:not([data-kategorie="'+kat+'"])').remove();

        jQuery('#region-chooser__items').val(jQuery(jQuery('#region-chooser__items option[data-kategorie="'+kat+'"]')[0]).val()) ;
		jQuery('#region-chooser__items').multipleSelect();
		jQuery('#region-chooser__items').multipleSelect('uncheckAll');
}

jQuery(document).ready(function(){

	jQuery('#region-chooser__items').multipleSelect({placeholder: "Bezirke wählen", selectAllText: "Alle auswählen", allSelected: "Alle ausgewählt", countSelected: "# von % ausgewählt"});

    jQuery('#region-chooser__add').click(function(){
		
		var ids = jQuery('#region-chooser__items').multipleSelect('getSelects');
		var names = jQuery('#region-chooser__items').multipleSelect('getSelects', 'text');
		
		for (var i=0;i<ids.length;i++){

			var id = parseInt(ids[i]);
			var name = names[i];

			if (addedRegionen.indexOf(id) < 0){
				addedRegionen.push(id);
				jQuery('.selected-regionen').append('<p class="selected-regionen__item" data-id="'+id+'"><input type="hidden" class="regionen" name="regionen[]" value="'+id+'"><span class="name">'+name+'</span><span class="select-wrapper"></span><button type="button" onclick="removeRegionFromList('+id+')">X</button></p>');
			}
		}

    });

    jQuery('#region-chooser__kategorie').change(function(){
        filterKategorienRegionen();
    });
    
    filterKategorienRegionen();
    
	jQuery('.selected-regionen .selected-regionen__item').each(function(){
		addedRegionen.push(jQuery(this).data('id'));
	});
    
});