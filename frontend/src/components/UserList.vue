<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

import type { UserDto } from "@/dto/UserDto";

import { useUserListStore } from "@/stores/useUserListStore";
import { useWeatherForecastStore } from "@/stores/useWeatherForecastStore";

const router = useRouter();
const userListStore = useUserListStore();
const weatherForecastStore = useWeatherForecastStore();

const people = ref<UserDto[]>([]);

onMounted(async () => {
  people.value = await userListStore.fetchUsers();
});

function showWeather(person) {
  weatherForecastStore.setSelectedUser(person);
  router.push({ name: "weather-forecast" });
}
</script>

<template>
  <table class="table table-striped table-hover">
    <thead class="table-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col" class="d-none">Latitude</th>
        <th scope="col" class="d-none">Longitude</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="person in people" :key="person.id">
        <th scope="col">{{ person.id }}</th>
        <th scope="col">{{ person.name }}</th>
        <th scope="col" class="d-none">{{ person.latitude }}</th>
        <th scope="col" class="d-none">{{ person.longitude }}</th>
        <th scope="col">
          <button
            type="button"
            class="btn btn-success"
            @click="showWeather(person)"
          >
            <i class="bi-cloud-sun"></i>
          </button>
        </th>
      </tr>
    </tbody>
  </table>
</template>
