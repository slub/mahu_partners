/**
 * 
 */

mahupartners.FilePage = class extends mahupartners.AbstractPage {

	render() {}
	
	showBusyIndicator(){
		let target= $(".companyfiles");
		target.append('<div style="width:100%;height:100%;position:absolute;text-align:center;background:gray;opacity:0.6;top:0"><p style="position: absolute;top: calc(50% - 14px);right: calc(50% - 14px);"><i class="fas fa-spinner fa-spin fa-2x"></i></p></div>');
	}
	
	addListeners() {
		let me = this;
		const registerRemoveButtonClickHandler = function(){
			$(".companyfiles a.remove").click(function(ev){
				ev.stopPropagation();
				ev.preventDefault();
				
				let url = ev.delegateTarget.href;
				url += "&tx_mahupartners_mahupartners[format]=part&type=1369315262";
	
				// add loading indicator
				me.showBusyIndicator();
				
				// call backend method and render response
				$.ajax(
					url,
					{
						async: true,
						dataType: "text"
					}).done(function(html){
						$(".companyfiles").html(html);
						registerRemoveButtonClickHandler();
					});
			});
		};
		
		registerRemoveButtonClickHandler();
		
		$('.fileuploadform input[type="submit"]').on('click', function (ev) {
			ev.stopPropagation();
			ev.preventDefault();
			
			let form = $("form.fileuploadform")[0];
			let action = form.action + "&tx_mahupartners_mahupartners[format]=part&type=1369315262";
			
			me.showBusyIndicator();
			
			$.ajax({
				// Your server script to process the upload
				url: action,
				type: 'POST',

				// Form data
				data: new FormData(form),

				// Tell jQuery not to process data or worry about content-type
				// You *must* include these options!
				cache: false,
				contentType: false,
				processData: false
			}).done(function(html){
					$(".companyfiles").html(html);
					registerRemoveButtonClickHandler();
			});
		});
	}
}