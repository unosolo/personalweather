import { ref } from "vue";
import { defineStore } from "pinia";
import { useConfigStore } from "@/stores/configStore";
import type { WeatherForecastDto } from "@/dto/WeatherForecastDto";

export const useWeatherForecastStore = defineStore("weatherForecast", () => {
  const { api } = useConfigStore();

  const selectedUser = ref<UserDto>({} as UserDto);

  const weatherForecastCache: WeatherForecastDto[] = [];

  async function fetchWeatherForecastByCoordinates(): Promise<void> {
    return await (
      await fetch(
        `${api}/weather/point/${selectedUser.value.latitude}/${selectedUser.value.longitude}`
      )
    ).json();
  }

  function setSelectedUser(person: UserDto) {
    selectedUser.value = person;
  }

  async function getWeatherForecast() {
    if (!selectedUser.value) {
      return {};
    }

    const update_at = new Date();
    update_at.setMinutes(update_at.getMinutes() + 60);

    if (
      !weatherForecastCache[`${selectedUser.value.id}`] ||
      weatherForecastCache[`${selectedUser.value.id}`].expire_at < new Date()
    ) {
      weatherForecastCache[`${selectedUser.value.id}`] = {
        data: await fetchWeatherForecastByCoordinates(),
        expire_at: update_at,
      };
    }

    return weatherForecastCache[`${selectedUser.value.id}`].data;
  }

  return {
    selectedUser,
    getWeatherForecast,
    setSelectedUser,
  };
});
