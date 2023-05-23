jQuery(document).ready(function($){
	
	$('.titulo-fatura').on('click', function(){
		$(this).parent().children('.body_fatura').fadeToggle();
	});
	
	$('.cadastrar').on('click', function(t){
		t.preventDefault();
		$('.form-cadastro').fadeToggle();
	});
	
	var aba = getUrlVars()["ano"];
	$('.ano'+aba).fadeIn();
	
	function getUrlVars()
	{
	    var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
	        hash = hashes[i].split('=');
	        vars.push(hash[0]);
	        vars[hash[0]] = hash[1];
	    }
	    return vars;
	}
	
	$( "#data" ).datepicker({
		changeMonth: true,
        changeYear: true,
	});
	
});


jQuery(document).ready(function($){
	$('.billing-table').dataTable({ 
		"paging": false,
		"language": {
        	"url": TaoExt.url_plugin+"/html/languages/pt_BR.txt"
    	} 
	});
});