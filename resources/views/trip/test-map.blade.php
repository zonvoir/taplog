<!DOCTYPE html>
<html>
<head>
  <title>Sites Map</title>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_aaYKAvDUt155kQaWXYqx0PUSXk5EEk4&callback=initMap&libraries=&v=weekly"
  defer
  ></script>
  <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
      * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
  </style>
</head>
<body>
  <input type="hidden" id="csrf-token" value="{{csrf_token()}}">
  <input type="hidden" id="tripId" value="{{$tripId}}">
  <div id="map"></div>
</body>
<script>
  function initMap() {
    let tripId = document.getElementById("tripId").value;
    var csrfToken = document.getElementById("csrf-token").value;
    var xmlHttp = new XMLHttpRequest();
    var url = "{{route('lat-long',$tripId)}}";
    xmlHttp.onreadystatechange = function()
    {
      if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
      {
        var locations = JSON.parse(xmlHttp.responseText);
        console.log(locations);

        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer({suppressMarkers: true});
        var haight = new google.maps.LatLng(locations[0].lat, locations[0].lng);

        var oceanBeach = new google.maps.LatLng(locations[1].lat, locations[1].lng);
        var markerList = [];
        var legDistanceList = [0];
        var myOptions = {
          zoom: 8,
          center: new google.maps.LatLng(locations[0].lat, locations[0].lng),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        myMap = new google.maps.Map(document.getElementById("map"), myOptions);

        var startLocation = null;
        var endLocation = null;
        var wayPts = [];
        for (var i = 0, ln = locations.length; i < ln; i += 1) {
          var tempLatLng = {lat: parseFloat(locations[i].lat), lng: parseFloat(locations[i].lng)};
          if(i == 0){
            startLocation = tempLatLng;
          }else if(i == locations.length - 1){
            endLocation = tempLatLng;
          }else{
            wayPts.push({location:tempLatLng,stopover:true});
          }
          var marker = new google.maps.Marker({
            position: tempLatLng,
            map: myMap,
            title: locations[i].site_id
          });
          markerList.push(marker);
        }

        directionsRenderer.setMap(myMap);
        var request = {
          origin: startLocation,
          destination: endLocation,
          waypoints: wayPts,
          //optimizeWaypoints: true,
          travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == 'OK') {
            var totalDistance = 0;
            for (var i = 0; i < response.routes[0].legs.length; i++) {
              legDistanceList.push(response.routes[0].legs[i].distance.text);
              totalDistance += response.routes[0].legs[i].distance.value;
            }
            directionsRenderer.setDirections(response);
            for (var i = 0; i < markerList.length; i++) {
              let currTitle = markerList[i].getTitle();
              currTitle += ' Distance : '+legDistanceList[i];
              markerList[i].setTitle(currTitle);
              if(i == markerList.length-1){
                markerList[i].setLabel('Total Distance : '+totalDistance/1000+' KM');
              }else{
                markerList[i].setLabel((i+1).toString());
              }
            }
          }
        });
      }
    }
    xmlHttp.open("get", url);
    xmlHttp.setRequestHeader("XSRF-TOKEN", csrfToken); 
    xmlHttp.send();
  }
</script>
</html>