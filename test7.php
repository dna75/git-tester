<!DOCTYPE html>
<html>

<head>
    <title>test</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIu3S-sFfdAQonvSzy27U8qlH7CUZB0KQ&libraries=places&ext=.js"></script>
    <script>
        var map = null;
        var marker = [];
        var autocomplete = [];

        var autocompleteOptions = {};

        $(document).ready(function() {
            var count = 1;
            $("#add").click(function() {
                count++;
                console.log('add new input field');
                $("#dynamic_field").append("<input id='waypoint" + count + "' class='autocomplete' type='text' placeholder='Adres tussenstop' /> <br />");
                // $('#dynamic_field').append('<input class="autocomplete" id="waypoint[]" name="waypoint[]" value="" onFocus="geolocate()" type="text">');



                var newInput = [];
                var newEl = document.getElementById('waypoint' + count);
                newInput.push(newEl);
                setupAutocomplete(autocomplete, newInput, 0);

                if (count === 7) {
                    $("#add").remove();
                }
            });
        });

        function setupAutocomplete(autocomplete, inputs, i) {
            console.log('setupAutocomplete...');

            $.each(autocompletesWraps, function(index, name) {


                if ($('#' + name).length == 0) {
                    return;
                }

                autocomplete[name] = new google.maps.places.Autocomplete($('#' + name + ' .autocomplete')[0], {
                    types: ['geocode']
                });

                autocomplete[name].setComponentRestrictions({
                    //     'country': ['nl','de','fr','be','bg','cz','dk','ee','ie','el','es','hr','it','cy','lv','lt','lu','hu','mt','at','pl','pt','ro','si','sk','fi','se']
                    //    'country': ['nl','de']
                    // country: ['nl', 'de', 'es', 'fr', 'be', 'dk']
                });

                // autocomplete[name].region({
                //     region:'EU'
                //     //types: ['(cities)']
                // });


                google.maps.event.addListener(autocomplete[name], 'place_changed', function() {

                    var place = autocomplete[name].getPlace();
                    var form = eval(name + '_form');

                    for (var component in form) {
                        $('#' + name + ' .' + component).val('');
                        $('#' + name + ' .' + component).attr('disabled', false);
                    }

                    for (var i = 0; i < place.address_components.length; i++) {
                        var addressType = place.address_components[i].types[0];
                        if (typeof form[addressType] !== 'undefined') {
                            var val = place.address_components[i][form[addressType]];
                            $('#' + name + ' .' + addressType).val(val);
                        }
                    }
                });
            });
        }

        function initialize() {

            var inputs = document.getElementsByClassName("autocomplete");
            for (var i = 0; i < inputs.length; i++) {
                setupAutocomplete(autocomplete, inputs, i);
            }

            // Sets a listener on a radio button to change the filter type on Places
            // Autocomplete.
            function setupClickListener(id, types) {
                var radioButton = document.getElementById(id);
                google.maps.event.addDomListener(radioButton, 'click', function() {
                    for (var i = 0; i < autocomplete.length; i++) {
                        autocomplete[i].setTypes(types);
                    }
                });
            }

            setupClickListener('changetype-all', []);
            setupClickListener('changetype-establishment', ['establishment']);
            setupClickListener('changetype-geocode', ['geocode']);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>

<body>
    <table>
        <tr>
            <td>
                <div>
                    <div id="dynamic_field">
                        <input id="waypoint[]" class="autocomplete" type="text" placeholder="Adres tussenstop" /> <br />
                    </div> <br />
                    <input id="add" type="button" value="Toevoegen tussenstop" class="styled-button-10" />

                </div>
            </td>
            <td>
                <div id="map-canvas" style="width:540px;height:380px;"></div>
            </td>
        </tr>
    </table>
</body>

</html>