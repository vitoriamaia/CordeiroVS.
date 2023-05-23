jQuery(window).load(function ($) {

    var address = document.querySelector('.address-invoke');
    if (address == null) return false;

    var map;
    var map_render = document.querySelector('#address');

    (function ($) {
        $.ajax({
            dataType: "json",
            url: 'https://maps.google.com/maps/api/geocode/json?address=' + address.innerHTML + '&sensor=false',
            success: function (data) {

                if(data.results){

                    var cep = data.results[0].address_components;
                    var cep_lenght = cep.length - 1;
                    cep = cep[cep_lenght].long_name;

                    if(cep.length == 5) cep = cep + '-000';

                    document.querySelector('.cep').innerHTML = cep;

                    var geometry = data.results[0].geometry.location;
                    var lat = geometry.lat;
                    var lng = geometry.lng;

                    execMap(lat, lng);

                }

            }
        });
    })(jQuery);

    function execMap(lat, lng) {
        // Cria Mapa
        var latlng = new google.maps.LatLng(lat, lng);

        var options = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(map_render, options);

        // Adiciona Marcacao (Ponto) no Mapa
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map
        });
    }

});