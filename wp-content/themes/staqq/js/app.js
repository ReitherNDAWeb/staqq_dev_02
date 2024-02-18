// @codekit-prepend "_password.js";
// @codekit-prepend "_skill_chooser.js";
// @codekit-prepend "_bundesland_bezirk.js";
// @codekit-prepend "_joborders_new.js";
// @codekit-prepend "_joborders_detail.js";
// @codekit-prepend "_signup.js";

(function($){
    
    $(document).ready(function(){
		
		// Header menü Automatic
		
        $(window).scroll(function(){
            if($(this).scrollTop() > $('.header--pre').outerHeight()){
                $('.header--main').addClass('header--fixed');
            }else{
                $('.header--main').removeClass('header--fixed');
            }
        });
		
		
		$('#header__navigation-rwd-pull').click(function(){
            $('.header__navigation').addClass('header__navigation--rwd-opend');
        });
		
		$('#header__navigation-rwd-close').click(function(){
            $('.header__navigation').removeClass('header__navigation--rwd-opend');
        });
		
		
		
		// Tabs
		
		if (window.location.hash){
			
			var tab = window.location.hash.substring(1);
			
			console.log(tab, $('.tab--'+tab));
			
			if ($('.tab--'+tab)){
				$('.tab-links li').removeClass('current-item');
				$('.tab-links li[data-tab="'+tab+'"]').addClass('current-item');

				$('.tab').removeClass('tab--active');
				$('.tab--'+tab).addClass('tab--active');
			}
		}
        $('.tab-links li').click(function(){
            
            $(this).parent('.tab-links').children('li').removeClass('current-item');
            $(this).addClass('current-item');
            
            $('.tab').removeClass('tab--active');
            $('.tab--'+$(this).data('tab')).addClass('tab--active');
			
			window.location.hash = "#"+$(this).data('tab');
        });
		
		
		
		
		
		
        
        $(document).on("keypress", ":input:not(textarea)", function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
        
        $('.switchable').switchable();
        
        $('select[multiple=multiple]').multipleSelect({
            filter: true,
			selectAllText: "Alle auswählen",
			allSelected: "Alle ausgewählt",
			countSelected: "# von % ausgewählt"
        });
        
        $('.tooltip').tooltipster({
           animation: 'fade',
           theme: 'tooltipster-borderless',
           trigger: 'click'
        });
        
        $('.tooltip-hover').tooltipster({
           animation: 'fade',
           theme: 'tooltipster-borderless',
           trigger: 'hover'
        });
        
        $(".datepicker").datepicker({
            prevText: '&#x3c;zurück', prevStatus: '',
            prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
            nextText: 'Vor&#x3e;', nextStatus: '',
            nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
            currentText: 'heute', currentStatus: '',
            todayText: 'heute', todayStatus: '',
            clearText: '-', clearStatus: '',
            closeText: 'schließen', closeStatus: '',
            monthNames: ['Januar','Februar','März','April','Mai','Juni',
            'Juli','August','September','Oktober','November','Dezember'],
            monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
            'Jul','Aug','Sep','Okt','Nov','Dez'],
            dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
            dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            dateFormat:'dd.mm.yy',
            firstDay: 1
        });
        
        $('#berufsfelder-wrapper input.berufsfelder').change(function(){
            console.log("berufsfelder change");
            
            var feld_id = $(this).val();
            var checked = $(this).is(':checked');
            
            if (checked){
                $('#berufsgruppen-wrapper p[data-berufsfeld='+feld_id+']').show();
            }else{
                $('#berufsgruppen-wrapper p[data-berufsfeld='+feld_id+']').hide();
				$('#berufsgruppen-wrapper p[data-berufsfeld='+feld_id+'] input').prop("checked", false);
				
				$('#berufsgruppen-wrapper p[data-berufsfeld='+feld_id+'] input').each(function(){
					$('#berufsbezeichnungen-wrapper p[data-berufsgruppe='+$(this).val()+']').hide();
					$('#berufsbezeichnungen-wrapper p[data-berufsgruppe='+$(this).val()+'] input').prop("checked", false);
				});
            }
            
        });
        
        $('#berufsgruppen-wrapper  input.berufsgruppen').change(function(){
            console.log("berufsgruppen change");
            
            var feld_id = $(this).val();
            var checked = $(this).is(':checked');
            
            if (checked){
                $('#berufsbezeichnungen-wrapper p[data-berufsgruppe='+feld_id+']').show();
            }else{
                $('#berufsbezeichnungen-wrapper p[data-berufsgruppe='+feld_id+']').hide();
				$('#berufsbezeichnungen-wrapper p[data-berufsgruppe='+feld_id+'] input').prop("checked", false);
            }
            
        });
        
        
		var opts = {
			lines: 10 // The number of lines to draw
			, length: 25 // The length of each line
			, width: 7 // The line thickness
			, radius: 40 // The radius of the inner circle
			, scale: 1 // Scales overall size of the spinner
			, corners: 1 // Corner roundness (0..1)
			, color: '#ffffff' // #rgb or #rrggbb or array of colors
			, opacity: 0.1 // Opacity of the lines
			, rotate: 0 // The rotation offset
			, direction: 1 // 1: clockwise, -1: counterclockwise
			, speed: 1 // Rounds per second
			, trail: 100 // Afterglow percentage
			, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
			, zIndex: 2e9 // The z-index (defaults to 2000000000)
			, className: 'spinner' // The CSS class to assign to the spinner
			, top: '50%' // Top position relative to parent
			, left: '50%' // Left position relative to parent
			, shadow: false // Whether to render a shadow
			, hwaccel: false // Whether to use hardware acceleration
			, position: 'absolute' // Element positioning
		}
		var target = document.getElementById('spinner')
		var spinner = new Spinner(opts).spin(target);
        
    });
    
}(jQuery));

function checkForm (fields, showError){

	var state = true;

	for (var i=0;i<fields.length;i++){

		if ((fields[i].type == "single_input") && (fields[i].check == "empty")){
			if (jQuery(fields[i].selector).val() == ""){
				if (showError) error("Das Feld <strong>"+fields[i].name+"</strong> darf nicht leer sein!", 0);
				state = false;
				break;
			}
		}else if ((fields[i].type == "multiple") && (fields[i].check == "lengthMind1")){
			if (jQuery(fields[i].selector).val() == null || jQuery(fields[i].selector).val().length <= 0){
				if (showError) error("Es muss mindestens ein <strong>"+fields[i].name+"</strong> ausgewählt werden!", 0);
				state = false;
				break;
			}
		}else if ((fields[i].type == "multipleCheckboxes") && (fields[i].check == "lengthMind1")){
			
			if (jQuery(fields[i].selector+':checked').length <= 0){
				if (showError) error("Es muss mindestens ein <strong>"+fields[i].name+"</strong> ausgewählt werden!", 0);
				state = false;
				break;
			}
		}else if ((fields[i].type == "multipleInputs") && (fields[i].check == "lengthMind1")){
			
			var e = true;
			
			jQuery(fields[i].selector).each(function(){
				if (jQuery(this).val() != null){
					e = false;
				}
			});
			
			if (e){
				if (showError) error("Es muss mindestens ein <strong>"+fields[i].name+"</strong> ausgewählt werden!", 0);
				state = false;
				break;
			}
		} else if ((fields[i].type == "select") && (fields[i].check == "notNullOrEmpty")){
			if (jQuery(fields[i].selector).val() == "" || jQuery(fields[i].selector).val() == null){
				if (showError) error("Das Feld <strong>"+fields[i].name+"</strong> darf nicht leer sein!", 0);
				state = false;
				break;
			}
		}
	}

	return state;
}

function error(msg, code){
    if (code === undefined) code = "Nicht angegeben";
    showNotification('Fehler', msg, true);
}

function showSpinner(){
    jQuery('.spinner-backdrop').addClass('spinner-backdrop--active');
}

function hideSpinner(){
    jQuery('.spinner-backdrop').removeClass('spinner-backdrop--active');
}

function closeNotification(){
    jQuery('.staqq-notification').animate({'top': '-500px'}, 300, 'swing', function(){});
}

function showNotification(title, msg, autoClose, class){
    
    if ((class != undefined) && (class != '')) jQuery('.staqq-notification').addClass(class);
    jQuery('.staqq-notification__title').html(title);
    jQuery('.staqq-notification__message').html(msg);
    jQuery('.staqq-notification').animate({'top': '0px'}, 300, 'swing', function(){});
    
    if (autoClose == true){
        setTimeout(function(){
            closeNotification();
        }, 5000);
    }
}

function addNewInputByName(name, placeholder, wrapper){
    jQuery('<input type="text" name="'+name+'[]" class="'+name+'" placeholder="'+placeholder+'">').insertBefore(wrapper);
}