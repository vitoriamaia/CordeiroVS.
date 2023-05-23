jQuery(window).load(function () {

    jQuery.getJSON("http://ip-api.com/json/" + service_temperature.ip, function (data) {

        if (data.status == "success") {
            get_temperature(data.city, data.region);
        } else {
            get_temperature("Fortaleza", "CE");
        }
        
    });

    function get_temperature(city, region) {

        var url_q = "http://api.openweathermap.org/data/2.5/weather?q";
        var appid = "68f02765e53fd40d1db3e9294c6c3ca2";
        var lang = "pt-BR";
        var units = "metric";

        jQuery.getJSON(url_q + "=" + city + ",pt-BR&units=" + units + "&appid=" + appid + "&lang=" + lang, function (data) {

            var temperature = data.main.temp;
            temperature = temperature.toString();
            temperature = temperature.replace(".", ",");
            temperature = temperature.slice(0, 4);

            jQuery('.temp').html(city + ", " + region + " - " + temperature + " ºC");

        });

    }

});