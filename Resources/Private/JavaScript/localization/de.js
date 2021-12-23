/**
 * Provdes German labels.
 * 
 * Copyright 2020 SLUB Dresden
 */
mahupartners.Localization = (function (){
	const language = "de";
	
	const localizedStrings = {
		"Materialklassen.contact.help" : "Materialklassen, für die dieser Kontakt der primäre Ansprechpartner ist (semikolon-getrennte Aufzählung).",
		"Materialklassen.expertise.help" : "Materialklassen, auf die sich die Expertise bezieht (semikolon-getrennte Aufzählung).",
		"Typ": "Art der Expertise",
		"Typ.0": "Herstellung",
		"Typ.1": "Test",
		"Typ.2": "Zertifizierung",
		"Typ.3": "Beschichtung",
		"Typ.4": "Verarbeitung",
		"Typ.5": "Konstruktion",
		"Zweck": "Zweck / Ziel",
		"Regularien.help": "Regularien, auf die sich die Expertise bezieht bzw. die für diese Expertise relevant sind, z. B. beim Testen oder Herstellen von Materialien. Mehrfachauswahl ist mit gedrückter Strg-Taste möglich.",
		"partnerpage.new.name.2":"Struktureinheit",
		"partnerpage.new.name.1":"Name"
	};
	
	return {
		getLanguage : function(){
			return language;
		},
		getString : function(key){
			return localizedStrings[key] || key;
		}
	}
})();