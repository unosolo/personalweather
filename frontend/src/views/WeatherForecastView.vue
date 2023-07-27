<script setup lang="ts">
import WeatherForecast from "@/components/WeatherForecast.vue";

import { useWeatherForecastStore } from "@/stores/useWeatherForecastStore";

const weatherForecastStore = useWeatherForecastStore();

const user = weatherForecastStore.selectedUser;

</script>

<template>
  <main role="main" class="container">
    <div class="content">
      <div class="row">
        <div class="col-2">&nbsp;</div>
        <div class="col-8">
          <h3>{{ user.name }} - Weather Forecast</h3>

          <weather-forecast></weather-forecast>
        </div>
        <div class="col-2">&nbsp;</div>
      </div>
    </div>
  </main>
</template>
