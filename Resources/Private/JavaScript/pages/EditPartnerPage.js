

/**
 * 
 */
mahupartners.EditPartnerPage = class extends mahupartners.AbstractPage {
	
	render() {
		
	}
	
	addListeners() {
		super.addListeners();

		let cuid = $("article.partnerPageContent").attr("data-cuid");

		// handle type selection (adapt visibility of input elements; change some labels)
		$("#"+cuid+"-form-type").change(function(ev){
			if (ev.target.selectedIndex === 1){ // company
				$('#researchDetails').hide()
				$('#companyDetails').show();
				$("label[for$='form-name']").html(mahupartners.Localization.getString("partnerpage.new.name.1")+" <span class=\"required\">*</span>");
				$("input[id$='form-name']").siblings("span.help-block").hide();
			} else if (ev.target.selectedIndex === 2) { // research
				$('#researchDetails').show()
				$('#companyDetails').hide();
				$("label[for$='form-name']").html(mahupartners.Localization.getString("partnerpage.new.name.2")+" <span class=\"required\">*</span>");
				$("input[id$='form-name']").siblings("span.help-block").show();
			} else {
				$('#researchDetails').hide();
				$('#companyDetails').hide();
				$("label[for$='form-name']").html(mahupartners.Localization.getString("partnerpage.new.name.1")+" <span class=\"required\">*</span>");
				$("input[id$='form-name']").siblings("span.help-block").hide();
			}
		});
		
		// initialize jQuery chosen for the research institutes list
		$("#"+cuid+"-form-superordinate").chosen({width:"100%", search_contains:true});
		
		// preview images that are about to be uploaded
		let imgInput = $("input[name='logofile']")[0];
		if (imgInput) {
			let preview = $(".previewcontainer img")[0];
			if (preview) {
				imgInput.onchange = function(evt) {
				  	let files = imgInput.files;
				  	if (files && files.length == 1) {
				    	preview.src = URL.createObjectURL(files[0]);
						$(preview).show();
						$(".previewcontainer span").hide();
				  	}
				}
			}
		}
		
		const getNextFieldSetID = function(fieldsets){
			let id = -1;
			
			fieldsets.each(function(index, fs){
				let lid= $(fs).attr("data-id");
				id = Math.max(id, lid);
			});
			
			return id+1;
		};
		
		$(".editform #abort").click(function(ev){
			ev.preventDefault();
			ev.stopPropagation();
			
			let u= $(this).attr("data-url");
			if (u) {
				window.location = u;
			}
		});
		
		$(".addContactBtn").on("click keyup", function(event){
			if (event.type === "keyup" && event.keyCode != 13) {
				return;
			}
			let container = $("div#contactFieldsets");			
			let id = getNextFieldSetID($("div#contactFieldsets fieldset"));
			
			let l = mahupartners.Localization;
			
			let html = `
			<fieldset data-id="${id}">
				<legend class="control-label">${l.getString("Kontakt")}
				<a class="deleteContactBtn" tabindex="0" title="${l.getString("Entfernen")}">
					<i class="fas fa-trash-alt smallicon" aria-hidden="true"></i>
				</a></legend>
				<div class="form-group">
					<div class="repeatable-container">
						<div class="form-group">
							<label class="control-label" for="${cuid}-form-contacts_${id}_surname">${l.getString("Vorname")}</label>

							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-contacts_${id}_surname"
									type="text"
									name="tx_mahupartners_mahupartners[company][contacts][${id}][surname]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-contacts_${id}_familyname">${l.getString("Nachname")}</label>

							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-contacts_${id}_familyname"
									type="text"
									name="tx_mahupartners_mahupartners[company][contacts][${id}][familyname]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-contacts_${id}_title">${l.getString("Titel")}</label>

							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-contacts_${id}_title"
									type="text"
									name="tx_mahupartners_mahupartners[company][contacts][${id}][title]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-contacts_${id}_position">${l.getString("Position")}</label>

							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-contacts_${id}_position"
									type="text"
									name="tx_mahupartners_mahupartners[company][contacts][${id}][position]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-contacts_${id}_email">${l.getString("E-Mail")}
								<span class="required">*</span>
							</label>

							<div class="input">
								<input required="required"
									class=" form-control"
									id="${cuid}-form-contacts_${id}_email"
									type="email"
									name="tx_mahupartners_mahupartners[company][contacts][${id}][email]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-contacts_${id}_phone">${l.getString("Telefon")}</label>

							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-contacts_${id}_phone"
									type="tel"
									name="tx_mahupartners_mahupartners[company][contacts][${id}][phone]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-contacts_${id}_fax">${l.getString("Fax")}</label>

							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-contacts_${id}_fax"
									type="tel"
									name="tx_mahupartners_mahupartners[company][contacts][${id}][fax]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-contacts_${id}_material_classes">${l.getString("Materialklassen")}</label>
							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-contacts_${id}_material_classes"
									type="text"
									name="tx_mahupartners_mahupartners[company][contacts][${id}][material_classes]">
								<span class="help-block">${l.getString("Materialklassen.contact.help")}</span>
							</div>
						</div>
					</div>
				</div>
			</fieldset>`;

			container.append(html);
			
			let newFieldSet = container.find("fieldset[data-id='"+id+"']");
			
			$(".deleteContactBtn", newFieldSet).on("click keyup", function(event){
				if (event.type === "keyup" && event.keyCode != 13) {
					return;
				}
				// remove the fieldset element from DOM
				let target= $(event.target);
				target.parents("fieldset").remove();
			});
			
			// scroll to new field set
			$("html,body").animate({
				scrollTop: newFieldSet.offset().top
			}, 1050, "easeInOutExpo");
		});
		
		$(".addExpertiseBtn").on("click keyup", function(event){
			if (event.type === "keyup" && event.keyCode != 13) {
				return;
			}
			let container = $("div#expertisesFieldsets");
			let id = getNextFieldSetID($("div#expertisesFieldsets fieldset"));
			
			let l = mahupartners.Localization;

			let html = `
			<fieldset data-id="${id}">
				<legend class="control-label">${l.getString("Expertise")}
					<a class="deleteExpertiseBtn" tabindex="0" title="${l.getString("Entfernen")}">
						<i class="fas fa-trash-alt smallicon" aria-hidden="true"></i>
					</a>
				</legend>
					
				<div class="form-group">
					<div class="repeatable-container">
						<div class="form-group">
							<label class="control-label" for="${cuid}-form-expertises_${id}_type">${l.getString("Typ")} <span class="required">*</span></label>
							<div class="input">
								<select required="required"
									class=" form-control"
									id="${cuid}-form-expertises_${id}_type"
									name="tx_mahupartners_mahupartners[company][expertises][${id}][type]">
									<option	value="0">${l.getString("Typ.0")}</option>
									<option value="1">${l.getString("Typ.1")}</option>
									<option value="2">${l.getString("Typ.2")}</option>
									<option value="3">${l.getString("Typ.3")}</option>
									<option value="4">${l.getString("Typ.4")}</option>
									<option value="5">${l.getString("Typ.5")}</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-expertises_${id}_name">${l.getString("Bezeichnung")}</label>
							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-expertises_${id}_name"
									type="text"
									name="tx_mahupartners_mahupartners[company][expertises][${id}][name]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-expertises_${id}_description">${l.getString("Beschreibung")}</label>
							<div class="input">
								<textarea
									class="xxlarge form-control"
									id="${cuid}-form-expertises_${id}_description"
									name="tx_mahupartners_mahupartners[company][expertises][${id}][description]"></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-expertises_${id}_purpose">${l.getString("Zweck")}</label>
							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-expertises_${id}_purpose"
									type="text"
									name="tx_mahupartners_mahupartners[company][expertises][${id}][purpose]">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-expertises_${id}_quantities">${l.getString("Abnahmemenge")}</label>
							<div class="input">
								<input class=" form-control"
									id="${cuid}-form-expertises_${id}_quantities"
									type="text"
									name="tx_mahupartners_mahupartners[company][expertises][${id}][quantities]">
							</div>
						</div>

						<div class="form-group">
							<div class="input checkbox">
								<div class="form-check">
									<label class="add-on form-check-label" for="${cuid}-form-expertises_${id}_customization">
									<input id="${cuid}-form-expertises_${id}_customization"
										type="checkbox"
										name="tx_mahupartners_mahupartners[company][expertises][${id}][customization]"
										value="1"> <span>${l.getString("Eingehen auf Kundenwünsche")}</span>
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-expertises_${id}_material_classes">${l.getString("Materialklassen")}</label>
							<div class="input">
								<input  class=" form-control"
									id="${cuid}-form-expertises_${id}_material_classes"
									type="text"
									name="tx_mahupartners_mahupartners[company][expertises][${id}][material_classes]">
								<span class="help-block">${l.getString("Materialklassen.expertise.help")}</span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="${cuid}-form-expertises_${id}_regulations">${l.getString("Regularien")}</label>
							<div class="input expertises-list">
								<span class="help-block">${l.getString("Regularien.help")}</span>
							</div>
						</div>
					</div>
				</div>
			</fieldset>`;

			container.append(html);
			
			let clone = $("#"+cuid+"-form-expertises_template").clone();
			clone.attr("name", clone.attr("name").replace("_temp_",id));
			clone.attr("id", cuid+"-form-expertises_"+id+"_regulations");
			
			container.find("fieldset[data-id='"+id+"'] .expertises-list").prepend(clone);
			
			let newFieldSet = container.find("fieldset[data-id='"+id+"']");
			
			$(".deleteExpertiseBtn", newFieldSet).on("click keyup", function(event){
				if (event.type === "keyup" && event.keyCode != 13) {
					return;
				}
				// remove the fieldset element from DOM
				let target= $(event.target);
				target.parents("fieldset").remove();
			});
			
			// scroll to new field set
			$("html,body").animate({
				scrollTop: newFieldSet.offset().top
			}, 1050, "easeInOutExpo");
		});
		
		// add delete button listeners for buttons that are already in the DOM (only relevant for Partner.editAction)
		$(".deleteContactBtn", $("div#contactFieldsets")).on("click keyup", function(event){
			if (event.type === "keyup" && event.keyCode != 13) {
				return;
			}
			// remove the fieldset element from DOM
			let target= $(event.target);
			target.parents("fieldset").remove();
		});
		$(".deleteExpertiseBtn", $("div#expertisesFieldsets")).on("click keyup", function(event){
			if (event.type === "keyup" && event.keyCode != 13) {
				return;
			}
			// remove the fieldset element from DOM
			let target= $(event.target);
			target.parents("fieldset").remove();
		});
	}
	
	
}