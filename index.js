const mymap = L.map('mapid', {
    worldCopyJump: true
}).setView([0, 0], 2.5);
L.tileLayer(
    'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZGVmYXVsdHEiLCJhIjoiY2s3cDg2ZGJuMDdsNjNmcnJwcTR5YWtvbSJ9.xi1nhoP6EGWiL4BoUwoHgg', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        zoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        maxBounds: 'bounds',
        accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);

const circle = L.circle([41.1231, 20.8016], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 1000000
}).addTo(mymap);

mymap.setMaxBounds(mymap.getBounds());

var point1 = L.latLng(186.4765625, 85.8095114039649),
    point2 = L.latLng(-169.1015625, -67.06743335108297),
    bounds = L.latLngBounds(point1, point2);




let response = fetch("https://coronavirus.app/get-places");
$.ajax({
    url: 'https://coronavirus.app/get-places',
    dataType: 'jsonp',
    success: function(data) {
        // your code to handle data here
        console.log(data);
    }
});

// $.ajax({

//     // The 'type' property sets the HTTP method.
//     // A value of 'PUT' or 'DELETE' will trigger a preflight request.
//     type: 'GET',

//     // The URL to make the request to.
//     url: 'https://coronavirus.app/get-places',

//     // The 'contentType' property sets the 'Content-Type' header.
//     // The JQuery default for this property is
//     // 'application/x-www-form-urlencoded; charset=UTF-8', which does not trigger
//     // a preflight. If you set this value to anything other than
//     // application/x-www-form-urlencoded, multipart/form-data, or text/plain,
//     // you will trigger a preflight request.
//     contentType: 'text/plain',

//     xhrFields: {
//       // The 'xhrFields' property sets additional fields on the XMLHttpRequest.
//       // This can be used to set the 'withCredentials' property.
//       // Set the value to 'true' if you'd like to pass cookies to the server.
//       // If this is enabled, your server must respond with the header
//       // 'Access-Control-Allow-Credentials: true'.
//       withCredentials: false
//     },

//     headers: {
//       // Set any custom headers here.
//       // If you set any non-simple headers, your server must include these
//       // headers in the 'Access-Control-Allow-Headers' response header.
//     },

//     success: function() {
//       // Here's where you handle a successful response.
//     },

//     error: function() {
//       // Here's where you handle an error response.
//       // Note that if the error was due to a CORS issue,
//       // this function will still fire, but there won't be any additional
//       // information about the error.
//     }
//   });