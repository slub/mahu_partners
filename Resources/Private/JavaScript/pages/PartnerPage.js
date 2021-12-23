/**
 * 
 */
mahupartners.PartnerPage = class extends mahupartners.AbstractPage {
	
	render() {}
	
	addListeners() {
		this.initTabs();
		
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
	
	initTabs() {
		$(".tabs").each(function(idx, tabsContainer) {
			let tabs = $(tabsContainer).find(".tab");
			if (tabs.length > 1) {
				
				tabs.each(function(idx, elem){
					/* click handler for tabs */
					$(elem).find("a").on("click keyup", function(event){
						if (event.type === "keyup" && event.originalEvent.keyCode != 13) {
							return true;
						}
						
						// ignore clicks on the currently active tab
						let isCurrentTab = event.target.parentElement.classList.contains("currentTab");
						if (isCurrentTab) 
							return;
						
						// ignore clicks on tabs without attribute "data-cid"
						let tid = event.target.getAttribute("data-cid");
						if (!tid) return;
						
						// the clicked anchor element as jQuery object
						let tab = $(event.target.parentElement);
						
						// get the corresponding element with class tabContent and hide all elements except that referred to in the clicked tab
						let tabContent = tab.parents(".tabs").siblings(".tabContent");
						tabContent.children().hide();
						let tEl = tabContent.find("."+tid);
						tEl.show();
						
						// mark the clicked tab as the active one and all others as deactive
						tab.addClass("currentTab");
						tab.siblings(".tab").removeClass("currentTab");
					});
				});
			}
		});
	}
}