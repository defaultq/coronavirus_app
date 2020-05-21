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
            <l-circle
                v-for="country in globallyLatest"
                :key="country.$index"
                :lat-lng="[country.latitude, country.longitude]"
                :radius="200000"
            >
                <l-popup v-on:mouseover="active = !active">
                    Country: {{ country.country }}
                    <br />
                    Confirmed: {{ country.confirmed }}
                    <br />
                    Recovered: {{ country.recovered }}
                    <br />

                    Deaths: {{ country.deaths }}
                </l-popup>
            </l-circle>
            <l-control class="sidebar">
                <div>
                    <button class="btn total">
                        Total cases {{ globallyNum.confirmed }}
                    </button>
                    <button class="btn activec">
                        Active cases {{ globallyNum.active_cases }}
                    </button>
                    <button class="btn recovered">
                        Recovered {{ globallyNum.recovered }}
                    </button>
                    <button class="btn deaths">
                        Deaths {{ globallyNum.deaths }}
                    </button>
                </div>

                <vue-fuse
                    
                    :eventName="fuseResultsUpdated"
                    :keys="[
                        globallyLatest.country,
                        globallyLatest.confirmed,
                        globallyLatest.active_cases,
                        globallyLatest.recovered,
                        globallyLatest.deaths
                    ]"
                    :defaultAll="false"
                    @fuseResultsUpdated="results($event)"
                >
                </vue-fuse>

                <ul v-for="country in result" :key="country.$index">
                    <li>Country: {{ country.country }}</li>
                    <li>Confirmed: {{ country.confirmed }}</li>
                    <li>Active: {{ country.active_cases }}</li>
                    <li>Recovered: {{ country.recovered }}</li>
                    <li>Deaths: {{ country.deaths }}</li>
                </ul>

                <div>
                    <button @click.prevent="show" class="graph">
                        Graphical representation
                    </button>
                    <modal name="graphicalView">
                        heljo there *.*
                        <button @click.prevent="hide" class="close-btn">
                            X
                        </button>
                    </modal>
                </div>
            </l-control>
            <l-tile-layer :url="url" :attribution="attribution" />
        </l-map>
    </div>
</template>

<script>
import axios from "axios";
import { latLngBounds } from "leaflet";
import { LMap, LTileLayer, LPopup, LControl, LCircle } from "vue2-leaflet";

export default {
    components: {
        LMap,
        LTileLayer,
        LPopup,
        LControl,
        LCircle
    },
    data() {
        return {
            url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            attribution:
                '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
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
            active: false,

            globallyNum: "",
            globallyLatest: ""
        };
    },
    mounted() {
        axios
            .all([
                axios.get("/globally_latest"),
                axios.get("/globally_latest_number")
            ])
            .then(
                axios.spread((latestRes, numRes) => {
                    this.globallyLatest = latestRes.data;
                    this.globallyNum = numRes.data;
                })
            );
    },
    methods: {
        results(results) {
            this.result = results;
        },
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
            this.$modal.show("graphicalView");
        },
        hide() {
            this.$modal.hide("graphicalView");
        }
    }
};
</script>

<style scoped>
.sidebar {
    position: fixed;
    width: 300px;
    top: 70px;
    right: 0;
    background: whitesmoke;
    bottom: 0;
    margin-right: 0px;
}

.search {
    position: fixed;
    width: 250px;
    height: 50px;
    font-size: 20px;
    border-radius: 10px;
    border: solid deepskyblue;
    border-width: 4px;
    right: 40px;
    top: 300px;
    display: inline-block;
    background: transparent;
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

.graph {
    position: fixed;
    right: 40px;
    top: 360px;
    height: 60px;
    width: 250px;
    border-radius: 8px;
    font-size: 20px;
    color: grey;
    background: transparent;
    border-color: deepskyblue;
    border-width: 4px;
}

.close-btn {
    background: #ff4d4d;
    position: fixed;
    right: 130px;
    width: 60px;
    height: 30px;
    border-radius: 12px;
}
</style>
