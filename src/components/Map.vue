<template>
  <ul style="height: 1000px; width: 100%">
    <l-map v-if="showMap" :zoom="zoom" :center="center" :options="mapOptions" style="height: 80%"
      @update:center="centerUpdate" @update:zoom="zoomUpdate">

      <l-tile-layer :url="url" :attribution="attribution" />

      <l-circle-marker v-for="d in data" color="red" fillColor="red" v-bind:key="d.index" :lat-lng="d.latLng"
        :radius="d.radius">
        <l-popup>
          Country: {{d[0]?d[0]:d[1]}}
          <br>
          Confirmed: {{d[3]}}
          <br>
          Deaths: {{d[4]}}
          <br>
          Recovered: {{d[5]}}
        </l-popup>
      </l-circle-marker>
      <l-control-zoom position="topleft"></l-control-zoom>
    </l-map>
  </ul>

</template>

<script>
  import {
    latLng
  } from "leaflet";
  import {
    LMap,
    LTileLayer,
    LCircleMarker,
    LPopup,
    LControlZoom
  } from "vue2-leaflet";

  export default {
    name: "Example",
    components: {
      LMap,
      LTileLayer,
      LCircleMarker,
      LPopup,
      LControlZoom
    },
    data() {
      return {
        zoom: 5,
        center: latLng(41.8719, 12.5674),
        url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        withPopup: latLng(47.41322, -1.219482),
        withTooltip: latLng(47.41422, -1.250482),
        currentZoom: 11.5,
        currentCenter: latLng(47.41322, -1.219482),
        showParagraph: false,
        mapOptions: {
          zoomSnap: 0.5
        },
        showMap: false,
        data: null
      };
    },
    mounted() {
      // this.fetchData('https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/03-15-2020.csv',this.setData);
      this.fetchData(
        'https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/03-15-2020.csv',
        this.setData);
    },
    methods: {
      fetchData(url, callback) {
        this.$papa.parse(
          url, {
            header: false,
            dynamicTyping: true,
            download: true,
            complete: function (results) {

              callback(results.data);

            }
          }
        );

        this.renderMap(true);

      },

      setData(data) {

        this.data = data;
        this.data.splice(0, 1);
        this.data.forEach(element => {
          if(element[0] == 'China' && element[1] == 'China'){
            console.log(element);
            return;
          }
          element.latLng = latLng(element[6], element[7]);
          //radius is the number of infecten in this case
          element.radius = element[3] * 0.005;
       
          

        });
        console.log(this.data);
      },

      renderMap(state) {

        this.showMap = state;

      },
      zoomUpdate(zoom) {
        this.currentZoom = zoom;
      },
      centerUpdate(center) {
        this.currentCenter = center;
      },
      showLongText() {
        this.showParagraph = !this.showParagraph;
      },
      innerClick() {
        alert("Click!");
      }
    }
  };
</script>