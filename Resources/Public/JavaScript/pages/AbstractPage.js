const mahupartners={AbstractPage:class{render(){}handleLanguageSelection(e){return!0}addListeners(){let e=this;void 0!==mahu&&(mahu.languageSwitchHook=e.handleLanguageSelection);let t=$("form.searchForm")[0];t&&"post"==t.method&&$("#nextPage, #previousPage, .listPager li a[class$='internal']").each(function(e,a){a.onclick=function(e){e.stopPropagation(),e.preventDefault();let n=document.createElement("input");n.value=a.getAttribute("data-page"),n.type="hidden",n.name="tx_mahupartners_mahupartners[page]",t.appendChild(n),t.submit()}});const a=function(){!function(e,t,a){var n=new Blob(t,{type:a||"text/csv"});if(window.navigator.msSaveOrOpenBlob)window.navigator.msSaveBlob(n,e);else{var r=window.document.createElement("a");r.href=window.URL.createObjectURL(n),r.download=e,document.body.appendChild(r),r.click(),document.body.removeChild(r)}}("results.csv",e.getExportData())};$("#modifierArea select").change(function(e){event.stopPropagation(),t.submit()}),$("#exportResults").click(function(e){a()}),$("#printResults").click(function(e){window.print()}),$("form.searchForm input[type='submit']").click(function(e){let t=$("input[id$='name']")[0];!t||""!=t.value&&"%"!=t.value||(t.value="*")}),$(".searchForm .inputType-text").autocomplete({source:function(e,t){var a=this.element.attr("autocompleteURL");a&&(a=a.replace("%25%25%25%25",e.term.toLowerCase()),jQuery.getJSON(a,function(e){t(e)}))},select:function(e,a){e.preventDefault(),e.stopPropagation(),this.value=a.item.value,t.submit()}})}getExportData(){}}};mahupartners.AbstractPage.detailViewWithPaging=function(e,t,a=window.event){var n=function(e,t){var a=[];for(var o in t){var i=e+"["+o+"]",u=t[o];"object"==typeof u?a=a.concat(n(i,u)):a.push(r(i,u))}return a},r=function(e,t){var a=document.createElement("input");return a.name=e,a.value=t,a.type="hidden",a};if(mahupartners_query){var o=jQuery(e).parents("li"),i=o.parents("ul.resultList");t?mahupartners_query.position=t:i&&(mahupartners_query.position=parseInt(i.attr("start"))+parseInt(o.index()));var u=document.createElement("form"),c=e.getAttribute("href");u.action=c,u.method="POST",u.style="display:none;",document.body.appendChild(u);var s=n("tx_mahupartners_mahupartners[underlyingQuery]",mahupartners_query);for(var l in s)u.appendChild(s[l]);return(2==a.which||a.ctrlKey||a.metaKey)&&(u.target="_blank",a.preventDefault()),result=u.submit(),!1}return!0};