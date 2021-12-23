/**
 * 
 */
const mahupartners =  {};

mahupartners.AbstractPage = class {
	
	render() {}
	
	handleLanguageSelection(option) {
		return true;
	}
	
	addListeners() {
		let me = this;
		
		// hook into the language selection; the handler can will be overridden by sub classes
		if (mahu!== undefined) {
			mahu.languageSwitchHook = me.handleLanguageSelection;
		}
		
		let mainForm = $("form.searchForm")[0];
		if (mainForm && mainForm.method == "post") {
			$("#nextPage, #previousPage, .listPager li a[class$='internal']").each(function(idx, el){
				el.onclick = function(event){
					event.stopPropagation();
					event.preventDefault();
					
					let formElement = document.createElement("input");
					formElement.value = el.getAttribute("data-page");
					formElement.type = "hidden";
					formElement.name = "tx_mahupartners_mahupartners[page]";
					mainForm.appendChild(formElement);
					
					mainForm.submit();
				};
			});
		}
		
		/**
		 * Creates an in-memory file with the given name, filetype and data and opens a
		 * download dialog to make it accessible for users.
		 * 
		 */
		const save = function(filename, data, filetype) {
			// code adapted from https://stackoverflow.com/questions/3665115/create-a-file-in-memory-for-user-to-download-not-through-server
		    var blob = new Blob(data, {
		    	type: filetype || 'text/csv'
		    	});
		    if(window.navigator.msSaveOrOpenBlob) {
		        window.navigator.msSaveBlob(blob, filename);
		    }
		    else{
		        var elem = window.document.createElement('a');
		        elem.href = window.URL.createObjectURL(blob);
		        elem.download = filename;
		        document.body.appendChild(elem);
		        elem.click();
		        document.body.removeChild(elem);
		    }
		};
		
		const exportResults = function(){
			let data = me.getExportData();

			save("results.csv", data);
		};
		
		$("#modifierArea select").change(function(ev){
			event.stopPropagation();
			
			mainForm.submit();
		});
		$("#exportResults").click(function(event){
			exportResults();
		});
		$("#printResults").click(function(event){
			window.print();
		});
		
		// add click listener to search button
		$("form.searchForm input[type='submit']").click(function(event){
			let inputField = $("input[id$='name']")[0];
			// replace empty search string by wildcard
			if (inputField && (inputField.value == '' || inputField.value == '%')){
				inputField.value = "*";
			}
		});
		
		// initialize suggestions
		// Set up jQuery UI Autocomplete search fields with the autocompleteURL attribute.
		$('.searchForm .inputType-text').autocomplete({
			source: function(request, returnSuggestions) {
				var autocompleteURL = this.element.attr('autocompleteURL');
				if (autocompleteURL) {
					autocompleteURL = autocompleteURL.replace('%25%25%25%25', request.term.toLowerCase());
					jQuery.getJSON(autocompleteURL, function (data) {
						returnSuggestions(data);
					});
				}
			},
			select: function(event, ui){
				event.preventDefault();
				event.stopPropagation();
				
				this.value = ui.item.value;
				mainForm.submit();
			}
		});
	}
	
	getExportData() {}

}

/**
 * Called by links to detail view pages for which result paging is required.
 *	* passes the detail page information in GET parameters (for good URLs)
 *	* passes the query information in POST parameters
 *	* the server can then render the details page while still having information
 *		about the original query for paging
 *
 * @param {DOMElement} element receiver of the click event
 * @param {int} position number of the result to go to [optional]
 * @returns Boolean false when the POST request was submitted, true otherwise
 */
mahupartners.AbstractPage.detailViewWithPaging = function (element, position, event = window.event) {
	const URLParameterPrefix = "tx_mahupartners_mahupartners";
	/**
	 * Recursively creates input elements with values for the content of the passed object.
	 * e.g. use the object { 'top' : {'a': 'b'}, 'second': 2} to create
	 * <input name="prefix[top][a]" value="b"/>
	 * <input name="prefix[second]" value="2"/>
	 *
	 * @param {string} prefix name attribute prefix
	 * @param {object} object data to build the <input> elements from
	 * @returns array of DOMElements
	 */
	var inputsWithPrefixForObject = function (prefix, object) {
		var inputs = [];
		for (var key in object) {
			var prefixWithKey = prefix + '[' + key + ']';
			var value = object[key];
			if (typeof(value) === 'object') {
				inputs = inputs.concat(inputsWithPrefixForObject(prefixWithKey, value));
			}
			else {
				inputs.push(inputWithNameAndValue(prefixWithKey, value));
			}
		}
		return inputs;
	};


	/**
	 * Creates an <input> element for the given name and value.
	 * 
	 * @param {string} name for name property of the <input> element
	 * @param {string} value for value property of the <input> element
	 * @returns DOMElement <input> element
	 */
	var inputWithNameAndValue = function (name, value) {
		var input = document.createElement('input');
		input.name = name;
		input.value = value;
		input.type = 'hidden';
		return input;
	};


	if (mahupartners_query) {
		// Try to determine position if it is not set explicitly (we should be in the main result list).
		var jLI = jQuery(element).parents('li');
		var jOL = jLI.parents('ul.resultList');
		if (position) {
			mahupartners_query.position = position;
		}
		else if (jOL) {
			mahupartners_query.position = parseInt(jOL.attr('start')) + parseInt(jLI.index());
		}

		var form = document.createElement('form');
		var linkURL = element.getAttribute('href');
		form.action = linkURL;
		form.method = 'POST';
		form.style = 'display:none;';
		document.body.appendChild(form);

		var inputs = inputsWithPrefixForObject(URLParameterPrefix + '[underlyingQuery]', mahupartners_query);
		for (var inputIndex in inputs) {
			form.appendChild(inputs[inputIndex]);
		}
		
		if((event.which == 2) || event.ctrlKey || event.metaKey) {
			form.target = "_blank";
			event.preventDefault();
		}

		result = form.submit();
		return false;
	}

	return true;
};
