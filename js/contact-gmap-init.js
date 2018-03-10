function createMap(){

    var mapContainer = document.getElementById("map");
    var mapOptions = {
        center: new google.maps.LatLng(47.1739206 , 27.5752338),
        zoom: 15,
        panControl:false,
        zoomControl:true,
        scrollwheel:false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(mapContainer, mapOptions);
    var marker = new google.maps.Marker({
        position: {
            lat: 47.1739206,
            lng: 27.5752338
        },
        map: map
    });
    map.set('styles',[
        {
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#000000"
            },
            {
              "weight": 2.5
            }
          ]
        },
        {
          "featureType": "landscape.man_made",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#ffffff"
            },
            {
              "visibility": "on"
            }
          ]
        },
        {
          "featureType": "landscape.natural",
          "stylers": [
            {
              "color": "#ffffff"
            },
            {
              "visibility": "on"
            }
          ]
        },
        {
          "featureType": "poi.business",
          "elementType": "geometry.fill",
          "stylers": [
            {
              "color": "#ffffff"
            }
          ]
        },
        {
          "featureType": "poi.medical",
          "elementType": "geometry.fill",
          "stylers": [
            {
              "color": "#cfcfcf"
            }
          ]
        },
        {
          "featureType": "poi.park",
          "elementType": "geometry.fill",
          "stylers": [
            {
              "color": "#ffffff"
            }
          ]
        },
        {
          "featureType": "poi.sports_complex",
          "elementType": "geometry.fill",
          "stylers": [
            {
              "color": "#ffffff"
            }
          ]
        },
        {
          "featureType": "road",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#f4511e"
            },
            {
              "visibility": "on"
            },
            {
              "weight": 0.4
            }
          ]
        },
        {
          "featureType": "road",
          "elementType": "labels.icon",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        }
      ]);



    
    
    }
google.maps.event.addDomListener(window, 'load', createMap);