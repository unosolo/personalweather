<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useWeatherForecastStore } from "@/stores/useWeatherForecastStore";
import type { WeatherForecastDto } from "@/dto/WeatherForecastDto";

const weatherForecastStore = useWeatherForecastStore();

const weatherForecast = ref<WeatherForecastDto>({} as WeatherForecastDto);

onMounted(async () => {
  weatherForecast.value = await weatherForecastStore.getWeatherForecast();
});
</script>

<template>
  <template v-if="!weatherForecast?.forecast">
    <h1>Not found</h1>
  </template>

  <template v-else>
    <BCarousel controls indicators class="center">
      <BCarouselSlide
        v-for="period in weatherForecast.forecast"
        :key="period.startTime.toString()"
      >
        <template #img>
          <img width="480" :src="period.icon" alt="image slot" />
        </template>
        <h1>
          {{ period.name }} ( {{ period.temperature }}
          {{ period.temperatureUnit }} )
        </h1>
        <p>{{ period.detailedForecast }}</p>
      </BCarouselSlide>
    </BCarousel>
  </template>
</template>
