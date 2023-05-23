(function(){
	jQuery.ajax({
    	url: ObjFat.ajaxFat,
    	dataType: 'json',
    	success: function(data){
    		DataLength = data.length;
    		mesesArr = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    		valores = new Array();
    		meses = new Array();
    		for(i=0; i<DataLength; i++){
    			valores[i] = data[i][0];
    			meses[i] = mesesArr[data[i][1]-1];
    		}
    		CriaGrafico(valores, meses);
    	}
   });
})();

CriaGrafico = function(valores, meses){
	var options = {
		responsive:true
	};
	var data = {
        labels: meses,
        datasets: [
            {
                label: "Dados em Colunas",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: valores
            }
        ]
    };
    var ctx = document.getElementById("GraficoBarra").getContext("2d");
    var BarChart = new Chart(ctx).Bar(data, options);
};

jQuery(document).ready(function($){
	$( "#calendario-init" ).datepicker({
		changeMonth: true,
        changeYear: true,
		onClose: function( selectedDate ) {
			$( "#calendario-finish" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	
	$( "#calendario-finish" ).datepicker({
		changeMonth: true,
        changeYear: true,
		onClose: function( selectedDate ) {
			$( "#calendario-init" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
