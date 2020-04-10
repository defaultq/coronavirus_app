<template>
  <ul style="height: 1000px; width: 100%">
    <l-map v-if="showMap" :zoom="zoom" :center="center" :options="mapOptions" :max-bounds="maxBounds" :bounds="bounds" style="height: 500px; width:100%"
      @update:center="centerUpdate" @update:zoom="zoomUpdate">
      <l-tile-layer :url="url" :attribution="attribution" />
      <!-- <l-circle :lat-lng="withTooltip" :radius="100000" /> -->

      <l-circle v-for="d in data" v-bind:key="d.index" :lat-lng="d.latLng" :radius="100000" />
    </l-map>
    <!-- <ul>
      <li v-for="d in data" v-bind:key="d">{{d.Latitude}}</li>
    </ul> -->
  </ul>

</template>

<script>
  import {
    latLng,
    latLngBounds
  } from "leaflet";
  import {
    LMap,
    LTileLayer,
    LCircle
  } from "vue2-leaflet";

  export default {
    name: "Example",
    components: {
      LMap,
      LTileLayer,
      LCircle
    },
    data() {
      return {
        zoom: 3,
        center: latLng(0, -1.219482),
        url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
          bounds: latLngBounds([
        [40.70081290280357, -74.26963806152345],
        [40.82991732677597, -74.08716201782228]
      ]),
         maxBounds: latLngBounds([
        [186.4765625, 85.8095114039649],
        [-169.1015625, -67.06743335108297]
      ]),
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
      this.fetchData('https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/03-15-2020.csv',this.setData);
    },
    methods: {
      fetchData(url,callback) {
        this.$papa.parse(
          url, {
            header: true,
            download: true,
            dynamicTyping: true,
            complete: function (results) {

              callback(results.data);

            }
          }
        );
        
        this.renderMap(true);

      },

      setData(data) {

        this.data = data;
         this.data.forEach(element => {

            element.latLng = latLng(element.Latitude , element.Longitude);

        });
        console.log(this.data);

      },
      
      renderMap(state){

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