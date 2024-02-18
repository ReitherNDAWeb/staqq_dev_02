
var user_type = "";
var registrations_id = 0;
var passwort = "";
var user = {};
var ressource = {
    id: 0,
    email: "",
    passwort: "",
    telefon: "",
    vorname: "",
    nachname: "",
    adresse_strasse_hn: "",
    adresse_plz: "",
    adresse_ort: "",
    berufsfelder: [],
    berufsgruppen: [],
    berufsbezeichnungen: [],
    skills: [],
    regionen: [],
    dl_gecastet: [],
    dl_blacklist: [],
    skill_fuehrerschein: false,
    skill_berufsabschluss: false,
    skill_hoechster_schulabschluss: "",
    skill_pkw: false,
    skill_eu_buerger: false,
    skill_rwr_karte: false,
    registrations_id: 0,
    agb_accept: 0,
    debug: DEBUG
};

var dienstleister = {
    id: 0,
    email: "",
    passwort: "",
    firmenwortlaut: "",
    gesellschaftsform: "",
    ansprechpartner_anrede: "",
    ansprechpartner_titel: "",
    ansprechpartner_vorname: "",
    ansprechpartner_nachname: "",
    ansprechpartner_position: "",
    ansprechpartner_telefon: "",
    uid: "",
    fn: "",
    website: "",
    firmensitz_plz: 0,
    firmensitz_adresse: "",
    firmensitz_ort: "",
    anzahl_user: 0,
    anzahl_joborders: 5,
    registrations_id: 0,
    agb_accept: 0,
    berufsfelder: [],
    filialen: [],
    debug: DEBUG
};

var kunde = {
    id: 0,
    email: "",
    passwort: "",
    firmenwortlaut: "",
    gesellschaftsform: "",
    ansprechpartner_anrede: "",
    ansprechpartner_titel: "",
    ansprechpartner_vorname: "",
    ansprechpartner_nachname: "",
    ansprechpartner_position: "",
    ansprechpartner_telefon: "",
    uid: "",
    fn: "",
    website: "",
    firmensitz_plz: 0,
    firmensitz_adresse: "",
    firmensitz_ort: "",
    anzahl_user: 0,
    anzahl_joborders: 5,
    registrations_id: 0,
    agb_accept: 0,
    arbeitsstaetten: [],
    dienstleister: [],
	dl_anforderung_bool: 0,
	dl_anforderung_name: "",
	dl_anforderung_ansprechpartner_titel: "",
	dl_anforderung_ansprechpartner_vorname: "",
	dl_anforderung_ansprechpartner_nachname: "",
	dl_anforderung_ansprechpartner_email: "",
    debug: DEBUG
};

function nextStep(f, n){
        if(jQuery('.signup-step--step-'+f).hasClass('signup-step--active')){

            if (f == "user-type"){
            
                user_type = jQuery('.signup-step--step-user-type [name=user_type]:checked').val();
                jQuery('.signup-step--user-'+user_type).css('display', 'block');
                if(user_type == "dienstleister" || user_type == "kunde") jQuery('.signup-step--step-tel #firmenwortlaut').show();
                goTo(n);
                
            } else if (f == "tel"){
                
                user = {
                    user_type: user_type,
                    firmenwortlaut: jQuery('.signup-step--step-tel #firmenwortlaut').val(),
                    email: jQuery('.signup-step--step-tel #email').val(),
                    telefon: jQuery('.signup-step--step-tel #laendervorwahl').val() + jQuery('.signup-step--step-tel #vorwahl').val() + jQuery('.signup-step--step-tel #telefon').val(),
                    vorname: jQuery('.signup-step--step-tel #vorname').val(),
                    nachname: jQuery('.signup-step--step-tel #nachname').val(),
                    debug: DEBUG
                };
                
                
                if ((user.email != "") && (jQuery('.signup-step--step-tel #telefon').val() != "") && (user.vorname != "") && (user.nachname != "") && ((user.user_type == "ressource") || (user.firmenwortlaut != ""))){
                    
                    if (jQuery.isNumeric(jQuery('.signup-step--step-tel #telefon').val())){

                        jQuery(".signup-step--step-user-type .form-center").validate({
                          debug: true
                        });

                        showSpinner();

                        signUpRegister(function(d) {

                            hideSpinner();

                            if (d.status){
                                goTo(n);
                            }else{
                                error(d.msg);
                            }
                        });
                    }else{
                        error("Angegebene Telefonnummer ist nicht numerisch!");
                    }
                }else{
                    error("Es müssen alle Felder ausgefüllt sein!");
                }
            } else if (f == "aktivierung") {
                showSpinner();
                signUpActivation(function(d){
                    
                    hideSpinner();
                    if (d.status){
                        ressource.registrations_id = d.id;
                        dienstleister.registrations_id = d.id;
                        kunde.registrations_id = d.id;
                        goTo(n);
                    }else{
                        error(d.msg);
                    }
                });
            } else if (f == "passwort") {
                
                var p1 = jQuery('.signup-step--step-passwort #password').val();
                var p2 = jQuery('.signup-step--step-passwort #password2').val();
                
                if (p1 == ""){
                    error("Es muss ein Passwort gewählt werden!");
                } else if(!jQuery('.signup-step--step-passwort #password').hasClass('valid')){
                    error("Das Passwort entspricht nicht den Anforderungen!");
                } else if (p1 != p2){
                    error("Die beiden Passwörter stimmen nicht überein!");
                }else{
                    showSpinner();
                    passwort = p1;
                
                    signUpPassword(function(d){
                    
                        hideSpinner();
                        if (d.status){
                            goTo(n);
                        }else{
                            error(d.msg);
                        }
                    });
                }
                    
            } else if (f == "informationen") {
                
                showSpinner();
                signUpInformationen(function(d){

                    hideSpinner();
                    if (d.status){
                        goTo(n);
                    }else{
                        error(d.msg);
                    }
                });
                
            } else {
                goTo(n);
            }
            
        }
    }


function goTo(n){
    jQuery('.signup-step').removeClass('signup-step--active');
    jQuery('.signup-step--step-'+n).addClass('signup-step--active');
    
    if (n == "aktivierung"){
        jQuery('#code').focus();
    }
    
    if (n == "informationen"){
        target = jQuery('.signup-step--user-'+user_type+'.signup-step--step-'+n);
    }else{
        target = jQuery('.signup-step--step-'+n);
    }

    jQuery('html, body').animate({ scrollTop: (target.position().top - 66)+"px" }, 1000);
}

function signUpRegister(callback){
    jQuery.ajax({
        url: API_ENDPOINT+"signup",
        method: 'POST',
        data: user        
    })
    .done(function(data) {
        var d = JSON.parse(data);
        console.log("data: ", d);
        registrations_id = d.id;
        callback(d);
    });
}

function signUpActivation(callback){
    jQuery.ajax({
        url: API_ENDPOINT+"signup/activation",
        method: 'POST',
        data:{
            email: user.email,
            code: jQuery('.signup-step--step-aktivierung #code').val(),
            debug: DEBUG
        }               
    })
    .done(function(data) {
        console.log("data: ", data, "regid: ", registrations_id);
        callback(JSON.parse(data));
    });
}

function signUpPassword(callback){
    
    console.log(user.user_type);
    
    if (user.user_type == "ressource"){
        
        ressource.email = user.email;
        ressource.vorname = user.vorname;
        ressource.nachname = user.nachname;
        ressource.telefon = user.telefon;
        ressource.passwort = passwort;
        ressource.registrations_id = registrations_id;
        
        jQuery.ajax({
            url: API_ENDPOINT+"ressources",
            method: 'POST',
            data: ressource               
        })
        .done(function(data) {
            console.log("data: ", data);
            var d = JSON.parse(data);
            ressource.id = d.id;
            callback(d);
        });
        
    } else if (user.user_type == "dienstleister"){
        
        dienstleister.firmenwortlaut = user.firmenwortlaut;
        dienstleister.email = user.email;
        dienstleister.ansprechpartner_vorname = user.vorname;
        dienstleister.ansprechpartner_nachname = user.nachname;
        dienstleister.ansprechpartner_telefon = user.telefon;
        dienstleister.passwort = passwort;
        dienstleister.registrations_id = registrations_id;
        
        jQuery('.signup-step--user-dienstleister #firmenwortlaut').val(dienstleister.firmenwortlaut);
        jQuery('.signup-step--user-dienstleister #ansprechpartner_vorname').val(dienstleister.ansprechpartner_vorname);
        jQuery('.signup-step--user-dienstleister #ansprechpartner_nachname').val(dienstleister.ansprechpartner_nachname);
        
        console.log("dl", dienstleister);
        
        jQuery.ajax({
            url: API_ENDPOINT+"dienstleister",
            method: 'POST',
            data: dienstleister               
        })
        .done(function(data) {
            console.log("data: ", data);
            var d = JSON.parse(data);
            dienstleister.id = d.id;
            callback(d);
        });
    
    } else if (user.user_type == "kunde"){
        
        kunde.firmenwortlaut = user.firmenwortlaut;
        kunde.email = user.email;
        kunde.ansprechpartner_vorname = user.vorname;
        kunde.ansprechpartner_nachname = user.nachname;
        kunde.ansprechpartner_telefon = user.telefon;
        kunde.passwort = passwort;
        kunde.registrations_id = registrations_id;
        
        jQuery('.signup-step--user-kunde #firmenwortlaut').val(kunde.firmenwortlaut);
        jQuery('.signup-step--user-kunde #ansprechpartner_vorname').val(kunde.ansprechpartner_vorname);
        jQuery('.signup-step--user-kunde #ansprechpartner_nachname').val(kunde.ansprechpartner_nachname);
        
        jQuery.ajax({
            url: API_ENDPOINT+"kunden",
            method: 'POST',
            data: kunde               
        })
        .done(function(data) {
            console.log("data: ", data);
            var d = JSON.parse(data);
            kunde.id = d.id;
            callback(d);
        });
    
    } else {
        hideSpinner();
        error("Kein User Type definiert!");
    }
}

function signUpInformationen(callback){
    
    console.log(user.user_type);
    
    if (user.user_type == "ressource"){
        
        ressource.berufsfelder = [];
        jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen .berufsfelder:checked').each(function() {
            ressource.berufsfelder.push(jQuery(this).val());
        });
        ressource.berufsfelder = JSON.stringify(ressource.berufsfelder);
        
        ressource.berufsgruppen = [];
        jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen .berufsgruppen:checked').each(function() {
            ressource.berufsgruppen.push(jQuery(this).val());
        });
        ressource.berufsgruppen = JSON.stringify(ressource.berufsgruppen);
        
        ressource.berufsbezeichnungen = [];
        jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen .berufsbezeichnungen:checked').each(function() {
            ressource.berufsbezeichnungen.push(jQuery(this).val());
        });
        ressource.berufsbezeichnungen = JSON.stringify(ressource.berufsbezeichnungen);
		      
        ressource.skills = [];
        jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen .selected-skills input').each(function() {
            ressource.skills.push(jQuery(this).val());
        });
        ressource.skills = JSON.stringify(ressource.skills);
        
        ressource.regionen = [];
        jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen .selected-regionen input').each(function() {
            ressource.regionen.push(jQuery(this).val());
        });
        ressource.regionen = JSON.stringify(ressource.regionen);
        
		console.log(ressource.regionen, addedRegionen, ressource.skills, addedSkills);
		
        //ressource.skills = JSON.stringify(jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #skills').val());
        //ressource.regionen = JSON.stringify(jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #regionen').val());
        ressource.dl_gecastet = JSON.stringify(jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dl_gecastet').val());
        ressource.dl_blacklist = JSON.stringify(jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dl_blacklist').val());
        ressource.skill_fuehrerschein = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #skill_fuehrerschein').is(':checked') ? 1 : 0;
        ressource.skill_berufsabschluss = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #skill_berufsabschluss').is(':checked') ? 1 : 0;
        ressource.skill_hoechster_schulabschluss = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #skill_hoechster_schulabschluss').val();
        ressource.skill_pkw = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #skill_pkw').is(':checked') ? 1 : 0;
        ressource.skill_eu_buerger = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #skill_eu_buerger').is(':checked') ? 1 : 0;
        ressource.skill_rwr_karte = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #skill_rwr_karte').is(':checked') ? 1 : 0;
        
        console.log("ressource Push", ressource);
        console.log("ressource lengths", (JSON.parse(ressource.berufsfelder)).length, (JSON.parse(ressource.berufsgruppen)).length, (JSON.parse(ressource.skills)).length, (JSON.parse(ressource.regionen)).length);
            
        if (((JSON.parse(ressource.berufsfelder)).length > 0) && ((JSON.parse(ressource.berufsgruppen)).length > 0)){
            if (((JSON.parse(ressource.skills)).length > 0) && ((JSON.parse(ressource.regionen)).length > 0)){
                if (ressource.skill_eu_buerger || ressource.skill_rwr_karte){

                    jQuery.ajax({
                        url: API_ENDPOINT+"ressources/"+ressource.id,
                        method: 'PUT',
                        data: ressource
                    })
                    .done(function(data) {
                        console.log("data: ", data, "res-id", ressource.id);
                        callback(JSON.parse(data));
                    });

                }else{
                    hideSpinner();
                    error('Als Nicht-EU-Bürger/in oder Angehörige/r eines Drittstaates ohne RWR-Karte ist eine legale Beschäftigung bei einer Zeitarbeitsfirma derzeit leider nicht möglich. Sollten Sie jedoch eine Rot-Weiß-Rot-Karte haben, bestätigen sie das Feld RWR-Karte! <br><br>Wir danken für Ihr Interesse.');
                }
            }else{
                hideSpinner();
                error("Es muss mindestends ein Skill und eine Region (Bezirk) ausgewählt werden!");
            }
        }else{
            hideSpinner();
            error("Es muss mindestends ein Berufsfeld und eine Berufsgruppe ausgewählt werden!");
        }
		
		jQuery('#agb-link').attr('href', '/agb-datenschutzerklaerung?acceptmode=1&user_type=ressource&user_id='+ressource.id);
        
    } else if (user.user_type == "dienstleister"){
        
        dienstleister.firmenwortlaut = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #firmenwortlaut').val();
        dienstleister.ansprechpartner_vorname = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_vorname').val();
        dienstleister.ansprechpartner_nachname = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_nachname').val();
        
        dienstleister.gesellschaftsform = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #gesellschaftsform').val();
        dienstleister.ansprechpartner_anrede = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_anrede').val();
        dienstleister.ansprechpartner_titel = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_titel').val();
        dienstleister.ansprechpartner_position = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_position').val();
        dienstleister.uid = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #uid').val();
        dienstleister.fn = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #fn').val();
        dienstleister.website = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #website').val();
        dienstleister.firmensitz_plz = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #firmensitz_plz').val();
        dienstleister.firmensitz_adresse = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #firmensitz_adresse').val();
        dienstleister.firmensitz_ort = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #firmensitz_ort').val();
        
        //dienstleister.berufsfelder = JSON.stringify(jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #berufsfelder').val());
        dienstleister.berufsfelder = [];
        jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen .berufsfelder:checked').each(function() {
            dienstleister.berufsfelder.push(jQuery(this).val());
        });
        dienstleister.berufsfelder = JSON.stringify(dienstleister.berufsfelder);
        console.log("dienstleister.berufsfelder", dienstleister.berufsfelder);
        dienstleister.filialen = [];
        var filialen = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen input.filialen');
        console.log("filialen", filialen);
        dienstleister.filialen = [];
        for (i=0;i<filialen.length;i++){
            dienstleister.filialen.push(jQuery(filialen[i]).val());
        }
        dienstleister.filialen = JSON.stringify(dienstleister.filialen);
        
        console.log("DL Push", dienstleister);
        
        if ((JSON.parse(dienstleister.berufsfelder)).length > 0){
            if ((dienstleister.gesellschaftsform != "") && (dienstleister.ansprechpartner_position != "") && (dienstleister.firmensitz_plz != "") && (dienstleister.firmensitz_adresse != "") && (dienstleister.firmensitz_ort != "") && (dienstleister.website != "") && (dienstleister.fn != "") && (dienstleister.firmenwortlaut != "") && (dienstleister.ansprechpartner_vorname != "") && (dienstleister.ansprechpartner_nachname != "")){
                if ((dienstleister.uid != "")){
                    if((dienstleister.uid.toUpperCase()).indexOf("AT") == 0){
                        jQuery.ajax({
                            url: API_ENDPOINT+"dienstleister/"+dienstleister.id,
                            method: 'PUT',
                            data: dienstleister               
                        })
                        .done(function(data) {
                            console.log("data: ", data, "dienstleister-id", dienstleister.id);
                            callback(JSON.parse(data));
                        });
                        
                    }else{
                        hideSpinner();
                        error('Für Zeitarbeitsfirmen ohne österreichische UID-Nummer ist derzeit eine Zusammenarbeit mit staqq leider nicht möglich. Wir bedanken uns bei Ihnen für Ihr Interesse.');
                    }
                    
                }else{
                    hideSpinner();
                    error('Ohne gültiger UID-Nummer ist aus steuerrechtlichen Gründen eine Zusammenarbeit derzeit leider nicht möglich. Wir bedanken uns bei Ihnen für Ihr Interesse.');
                }
                
            }else{
                hideSpinner();
                error("Bitte füllen Sie alle Pflichtfelder aus!");
            }
            
        }else{
            hideSpinner();
            error("Es muss mindestends ein Berufsfeld ausgewählt werden!");
        }
		
		jQuery('#agb-link').attr('href', '/agb-datenschutzerklaerung?acceptmode=1&user_type=dienstleister&user_id='+dienstleister.id);
                    
        
    } else if (user.user_type == "kunde"){
        
        kunde.firmenwortlaut = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #firmenwortlaut').val();
        kunde.ansprechpartner_vorname = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_vorname').val();
        kunde.ansprechpartner_nachname = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_nachname').val();
        
        kunde.gesellschaftsform = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #gesellschaftsform').val();
        kunde.ansprechpartner_anrede = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_anrede').val();
        kunde.ansprechpartner_titel = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_titel').val();
        //kunde.ansprechpartner_position = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #ansprechpartner_position').val();
        //kunde.uid = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #uid').val();
        //kunde.fn = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #fn').val();
        //kunde.website = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #website').val();
        //kunde.firmensitz_plz = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #firmensitz_plz').val();
        //kunde.firmensitz_adresse = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #firmensitz_adresse').val();
        //kunde.firmensitz_ort = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #firmensitz_ort').val();
		
        kunde.dl_anforderung_bool = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dl_anforderung_bool').val();
        kunde.dl_anforderung_name = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dl_anforderung_name').val();
        kunde.dl_anforderung_ansprechpartner_titel = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dl_anforderung_ansprechpartner_titel').val();
        kunde.dl_anforderung_ansprechpartner_vorname = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dl_anforderung_ansprechpartner_vorname').val();
        kunde.dl_anforderung_ansprechpartner_nachname = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dl_anforderung_ansprechpartner_nachname').val();
        kunde.dl_anforderung_ansprechpartner_email = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dl_anforderung_ansprechpartner_email').val();
		
        kunde.dienstleister = JSON.stringify(jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen #dienstleister').val());
        
        var arbeitsstaetten = jQuery('.signup-step--user-'+user_type+'.signup-step--step-informationen input.arbeitsstaetten');
        kunde.arbeitsstaetten = [];
        for (i=0;i<arbeitsstaetten.length;i++){
            kunde.arbeitsstaetten.push(jQuery(arbeitsstaetten[i]).val());
        }
        kunde.arbeitsstaetten = JSON.stringify(kunde.arbeitsstaetten);
        
        console.log("KU Push", kunde);
        
        if ((kunde.gesellschaftsform != "") && (kunde.firmenwortlaut != "") && (kunde.ansprechpartner_vorname != "") && (kunde.ansprechpartner_nachname != "")){
                    
            jQuery.ajax({
                url: API_ENDPOINT+"kunden/"+kunde.id,
                method: 'PUT',
                data: kunde               
            })
            .done(function(data) {
                console.log("data: ", data, "kunde-id", kunde.id);
                callback(JSON.parse(data));
            });

        }else{
            hideSpinner();
            error("Bitte füllen Sie alle Pflichtfelder aus!");
        }
        
		jQuery('#agb-link').attr('href', '/agb-datenschutzerklaerung?acceptmode=1&user_type=kunde&user_id='+kunde.id);
        
        
        
    
    } else {
        hideSpinner();
        error("Kein User Type definiert!");
    }
}


function acceptAGB(){
	
	if (jQuery('#accept-checkbox').is(":checked")){
    
		if (user.user_type == "ressource"){

			showSpinner();
			jQuery.ajax({
				url: API_ENDPOINT+"ressources/"+ressource.id+"/acceptAGB",
				method: 'PUT',
				data: ressource
			})
			.done(function(data) {
				console.log("data: ", data);
				var d = JSON.parse(data);
				if (d.status) {
					window.location.href = "/app/?signup=true";
				}else{
					hideSpinner();
					error(d.msg);
				}
			});

		} else if (user.user_type == "dienstleister"){

			showSpinner();
			jQuery.ajax({
				url: API_ENDPOINT+"dienstleister/"+dienstleister.id+"/acceptAGB",
				method: 'PUT',
				data: ressource
			})
			.done(function(data) {
				console.log("data: ", data);
				var d = JSON.parse(data);
				if (d.status) {
					window.location.href = "/app/?signup=true";
				}else{
					hideSpinner();
					error(d.msg);
				}
			});

		} else if (user.user_type == "kunde"){

			showSpinner();
			jQuery.ajax({
				url: API_ENDPOINT+"kunden/"+kunde.id+"/acceptAGB",
				method: 'PUT',
				data: ressource
			})
			.done(function(data) {
				console.log("data: ", data);
				var d = JSON.parse(data);
				if (d.status) {
					window.location.href = "/app/?signup=true";
				}else{
					hideSpinner();
					error(d.msg);
				}
			});

		} else {
			hideSpinner();
			error("Kein User Type definiert!");
		}
	}else{
		error("Sie müssen die Datenschutzerklärung und den Ethikkodex akzeptieren!");
	}
}