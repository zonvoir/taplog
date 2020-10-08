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
    .custom-btn{
      background: #1f7cca;
      background-position: top right;
      background-color: #1f7cca;
      transition: all 0.15s ease;
      box-shadow: none;
      color: #ffffff;
      border-radius: 0;
      display: inline-block;
      padding: 10px 30px;
      font-size: 22px;
      margin: 10px;
    }
    </style>
  </head>
  <body>
    <input type="hidden" id="csrf-token" value="{{csrf_token()}}">
    <input type="hidden" id="tripId" value="{{$tripId}}">
    <a href="{{ route('trip-map-pdf',['action'=>'view_pdf','trip_id'=>$tripId]) }}" class="custom-btn" target="_blank">Print</a>
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
            //console.log(icon_url,i);
            if(i == 0){
              startLocation = tempLatLng;
            }else if(i == locations.length - 1){
              endLocation = tempLatLng;
            }else{
              wayPts.push({location:tempLatLng,stopover:true});
            }
            if(i == 0){
              var icon_url = "https://mt.google.com/vt/icon?psize=20&font=fonts/Roboto-Regular.ttf&color=ff330000&name=icons/spotlight/spotlight-waypoint-a.png&ax=44&ay=48&scale=1&text=%E2%80%A2";
            }else{
              var icon_url = "https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi-dotless2.png";
            }

            var marker = new google.maps.Marker({
              position: tempLatLng,
              map: myMap,
              icon: {
                url: icon_url,
              },
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
            //storeTotalDistance(totalDistance);
            directionsRenderer.setDirections(response);
            var c = 0;
            for (var i = 0; i < markerList.length; i++) {
              let currTitle = markerList[i].getTitle();
              currTitle += ' Distance : '+legDistanceList[i];
              markerList[i].setTitle(currTitle);
              if(i == markerList.length-1){
                c++;
                markerList[i].setLabel((c).toString());
               // markerList[i].setLabel('Total Distance : '+totalDistance/1000+' KM');
              }else{
                if(i != 0){
                  c++;
                  markerList[i].setLabel((c).toString());
                }
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