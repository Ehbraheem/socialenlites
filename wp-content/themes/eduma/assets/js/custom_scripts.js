jQuery(document).ready(function(){
	 //jQuery("#test-script").html("jQuery says Hello World");
        jQuery('select[multiple]').multiselect( {columns: 4,
    placeholder: 'Select Categories',
		search: true});   		
});
function testCall()
 {
	 alert("Function Called");	        
 }
