<template>
  <div style="height: 400px;">
    <l-map
      style="height: 450%; width: 100%"
      :zoom="zoom"
      :center="center"
      :max-bounds="maxBounds"
      @update:zoom="zoomUpdated"
      @update:center="centerUpdated"
      @update:bounds="boundsUpdated"
    >
      <!-- <l-control>
        <div>
          <button id="graph" @click.prevent="show">Graphical Representation</button>
          <modal name="Graphical">Graphical</modal>
        </div>
      </l-control>-->

      <!-- <l-control position="upper">
        <div class="sidebar">
          <button class="btn total">Total cases</button>
          <button class="btn activec">Active cases</button>
          <button class="btn recovered">Recovered</button>
          <button class="btn deaths">Deaths</button>
          <input type="text" class="search" placeholder="Search" />
        </div>
      </l-control> -->
      <l-tile-layer :url="url" :attribution="attribution" />

      <!-- <l-marker :lat-lng="markerLatLng">
        <l-popup></l-popup>
      </l-marker> -->
    </l-map>
  </div>
</template>

<script>
import axios from "axios";
import { latLngBounds } from "leaflet";
import { LMap, LTileLayer, LPopup, LControl, LMarker } from "vue2-leaflet";

export default {
  components: {
    LMap,
    LTileLayer,
    LPopup,
    LControl,
    LMarker
  },
  data() {
    return {
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
      zoom: 3,
      center: [0, 0],
      bounds: latLngBounds([
        [-526.640625, 83.02621885344846],
        [-164.53125, -52.482780222078205]
      ]),
      maxBounds: latLngBounds([
        [-198.6328125, 84.05256097843035],
        [234.84375000000003, -24.846565348219734]
      ]),

      markerLatLng: [47.31322, -1.319482],
      koroni: [],
      mode: "dark"
    };
  },
  methods: {
    // getKoroni() {
    //   fetch("https://pomber.github.io/covid19/timeseries.json")
    //     .then(responce => responce.json())
    //     .then(data => (this.koroni = data));
    //   axios
    //     .get("https://pomber.github.io/covid19/timeseries.json")
    //     .then(response => (this.koroni = response.data));
    // },

    zoomUpdated(zoom) {
      this.zoom = zoom;
    },
    centerUpdated(center) {
      this.center = center;
    },
    boundsUpdated(bounds) {
      this.bounds = bounds;
    },
    show() {
      this.$modal.show("Graphical");
    },
    hide() {
      this.$modal.hide("Graphical");
    }
  }
};
</script>

<style scoped>
.sidebar {
  position: fixed;
  width: 300px;
  top: 0;
  right: 0;
  bottom: 0;
  background: whitesmoke;
}

.search {
  position: fixed;
  width: 235px;
  height: 30px;
  font-size: 20px;
  border-radius: 8px;
  border: solid deepskyblue;
  right: 50px;
  top: 220px;
  display: inline-block;
}

.btn {
  height: 90px;
  width: 135px;
  border-radius: 12px;
  margin: 10px 5px 5px 5px;
  font-size: 20px;
}
.total {
  border: solid deepskyblue;
  background: deepskyblue;
  color: #004d66;
}

.activec {
  border: solid red;
  background: red;
  color: #800000;
}

.recovered {
  border: solid green;
  background: green;
  color: #043102;
}

.deaths {
  border: solid grey;
  background: grey;
  color: #404040;
}

#graph {
  position: fixed;
  right: 0px;
  top: 850px;
  height: 80px;
  width: 250px;
  border-radius: 18px;
  font-size: 20px;
  color: black;
}
</style>
