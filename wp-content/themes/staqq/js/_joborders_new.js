var removed_id = [];
var removed_auswahl = [];

function filterDienstleisterStamm(init){

    var choosen = parseInt(jQuery('select#dienstleister_auswahl_stamm').val());
    
    // Einzelne ID
    jQuery('select#dienstleister_id').append(removed_id);
    removed_id = jQuery('select#dienstleister_id option:not([data-stamm="'+choosen+'"])');
    jQuery('select#dienstleister_id option:not([data-stamm="'+choosen+'"])').remove();

    if (!init) jQuery('select#dienstleister_id').val(jQuery(jQuery('select#dienstleister_id option[data-stamm="'+choosen+'"]')[0]).val());
    
    // Array
    jQuery('select#dienstleister_auswahl').append(removed_auswahl);
    removed_auswahl = jQuery('select#dienstleister_auswahl option:not([data-stamm="'+choosen+'"])');
    jQuery('select#dienstleister_auswahl option:not([data-stamm="'+choosen+'"])').remove();
    
    jQuery('select#dienstleister_auswahl-wrapper .ms-parent').remove();
    
    jQuery('#dienstleister_auswahl').multipleSelect({
        filter: true
    });
}

jQuery(document).ready(function(){
    jQuery('#dienstleister_vorgegeben').change(function(){
        
        var state = jQuery(this).val();
        
        if (state == 1){
            jQuery('#dienstleister_id-wrapper').show();
            
            if (jQuery('#dienstleister_vorgegeben option:selected').data('stamm') == 1){
                jQuery('#dienstleister_id option').hide();
                jQuery('#dienstleister_id option[data-stamm="1"]').show();
            }else{
                jQuery('#dienstleister_id option').show();
            }
            
        } else {
            jQuery('#dienstleister_id-wrapper').hide();
        }
        
    });
    
    jQuery('select#dienstleister_vorgegeben').change(function(){
        
        if (jQuery('select#dienstleister_vorgegeben').val() == 1){
			
			jQuery('#dienstleister_single-wrapper').show();
			jQuery('#dienstleister_auswahl_stamm-wrapper').show();

			if (jQuery('select#dienstleister_single').val() == 1){
				jQuery('#dienstleister_id-wrapper').show();
				jQuery('#dienstleister_auswahl-wrapper').hide();
			}else{
				jQuery('#dienstleister_id-wrapper').hide();
				jQuery('#dienstleister_auswahl-wrapper').show();
			}

		}else{
			jQuery('#dienstleister_single-wrapper').hide();
			jQuery('#dienstleister_auswahl_stamm-wrapper').hide();
			jQuery('#dienstleister_id-wrapper').hide();
			jQuery('#dienstleister_auswahl-wrapper').hide();
		}
        
    });
    
    jQuery('select#dienstleister_single').change(function(){
        
        if (jQuery('select#dienstleister_single').val() == 1){
            jQuery('#dienstleister_id-wrapper').show();
            jQuery('#dienstleister_auswahl-wrapper').hide();
        }else{
            jQuery('#dienstleister_id-wrapper').hide();
            jQuery('#dienstleister_auswahl-wrapper').show();
        }
        
    });
	
	if(jQuery('#einschraenkung_aktiv_von_bis').is(':checked')){
		jQuery('#aktiv_von').show();
		jQuery('#aktiv_bis').show();
	}else{
		jQuery('#aktiv_von').hide();
		jQuery('#aktiv_bis').hide();
	}

	if(jQuery('.verwaltung-user #einschraenkung_berufsfelder').is(':checked')){
		jQuery('.verwaltung-user #berufsfelder-wrapper').show();
	}else{
		jQuery('.verwaltung-user #berufsfelder-wrapper').hide();
	}

	if(jQuery('.verwaltung-user #einschraenkung_suchgruppen').is(':checked')){
		jQuery('.verwaltung-user #suchgruppen-wrapper').show();
	}else{
		jQuery('.verwaltung-user #suchgruppen-wrapper').hide();
	}

	if(jQuery('.verwaltung-user #einschraenkung_filialen').is(':checked')){
		jQuery('.verwaltung-user #filialen-wrapper').show();
	}else{
		jQuery('.verwaltung-user #filialen-wrapper').hide();
	}

	if(jQuery('.verwaltung-user #einschraenkung_arbeitsstaetten').is(':checked')){
		jQuery('.verwaltung-user #arbeitsstaetten-wrapper').show();
	}else{
		jQuery('.verwaltung-user #arbeitsstaetten-wrapper').hide();
	}
	
	jQuery('#vorlage, #einschraenkung_aktiv_von_bis').switchable({
		
		click: function(ev, checked){
			if(jQuery('#vorlage').is(':checked')){
            	jQuery('#vorlage_name').show();
			}else{
				jQuery('#vorlage_name').hide();
			}

			if(jQuery('#einschraenkung_aktiv_von_bis').is(':checked')){
				jQuery('#aktiv_von').show();
				jQuery('#aktiv_bis').show();
			}else{
				jQuery('#aktiv_von').hide();
				jQuery('#aktiv_bis').hide();
			}
			
			if(jQuery('.verwaltung-user #einschraenkung_berufsfelder').is(':checked')){
				jQuery('.verwaltung-user #berufsfelder-wrapper').show();
			}else{
				jQuery('.verwaltung-user #berufsfelder-wrapper').hide();
			}

			if(jQuery('.verwaltung-user #einschraenkung_suchgruppen').is(':checked')){
				jQuery('.verwaltung-user #suchgruppen-wrapper').show();
			}else{
				jQuery('.verwaltung-user #suchgruppen-wrapper').hide();
			}

			if(jQuery('.verwaltung-user #einschraenkung_filialen').is(':checked')){
				jQuery('.verwaltung-user #filialen-wrapper').show();
			}else{
				jQuery('.verwaltung-user #filialen-wrapper').hide();
			}

			if(jQuery('.verwaltung-user #einschraenkung_arbeitsstaetten').is(':checked')){
				jQuery('.verwaltung-user #arbeitsstaetten-wrapper').show();
			}else{
				jQuery('.verwaltung-user #arbeitsstaetten-wrapper').hide();
			}
		}
	});
    
    jQuery('select#dienstleister_auswahl_stamm').change(function(){
        
        filterDienstleisterStamm(false);
        
    });
	
	
	
	// Init
	
    filterDienstleisterStamm(true);
	
	if (jQuery('select#dienstleister_vorgegeben').val() == 1){
			
		jQuery('#dienstleister_single-wrapper').show();
		jQuery('#dienstleister_auswahl_stamm-wrapper').show();

		if (jQuery('select#dienstleister_single').val() == 1){
			jQuery('#dienstleister_id-wrapper').show();
			jQuery('#dienstleister_auswahl-wrapper').hide();
		}else{
			jQuery('#dienstleister_id-wrapper').hide();
			jQuery('#dienstleister_auswahl-wrapper').show();
		}

	}else{
		jQuery('#dienstleister_single-wrapper').hide();
		jQuery('#dienstleister_auswahl_stamm-wrapper').hide();
		jQuery('#dienstleister_id-wrapper').hide();
		jQuery('#dienstleister_auswahl-wrapper').hide();
	}
});