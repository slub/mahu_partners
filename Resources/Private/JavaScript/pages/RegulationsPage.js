/**
 * 
 */
mahupartners.RegulationsPage = class extends mahupartners.AbstractPage {
	
	render() {}

	addListeners() {
		super.addListeners();
	}
	
	/* In this method we make sure that switching languge works properly. */
	handleLanguageSelection(option) {
		let mainForm = $("form.searchForm");
		
		// case one: search page
		if (mainForm.length != 0) {
			// thus, we alter the form action parameter instead
			mainForm.prop("action", option.uri);
			
			// submit the form
			mainForm[0].submit();
			
		} else {
			// case two: detail pages
			
			let id= $("article.detail div.newDataProvider").attr("id");
			
			let pos = option.uri.indexOf("?");
			if (pos!==-1){
				window.location = option.uri.substring(0, pos)+"/"+id;
			} else {
				window.location = option.uri+"/"+id;
			}
		}
		
		return false;
	}
	
	getExportData() {
		let data = [ "\ufeff" ];
		
		data.push("Anfrage: \""+mahupartners_query.q.name+"\"\n\n");
		data.push("Ergebnisse:\n");
		data.push("Name;Detailseite im Material Hub\n");
		
		// add individual material descriptions
		$(".resultList .flexResultLine").each(function(idx, el){
			let resultLine = $(el);
			
			let linkElem = resultLine.find(".baseInfo p a")[0];

			let link = linkElem.href;
			let name = linkElem.textContent.trim();
			
			data.push(name+";"+link+"\n");
		});
		
		return data;
	}
}