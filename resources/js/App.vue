<template>
  <div>
       <Map/>
  </div>
</template>

<script>
import Map from './components/Map/Map.vue';

window.axios = require('axios');

export default {
  name: 'App',
  components: {
    Map
  }
}
</script>

<style>
</style>
