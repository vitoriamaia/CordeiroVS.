jQuery(document).ready(function($){
	$('.coupon-table').dataTable({
		"paging": false,
		"language": {
        	"url": CouponExt.url_plugin+"/html/languages/pt_BR.txt"
    	}
	});

});