import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import WeatherForecastView from "../views/WeatherForecastView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/weather-forecast",
      name: "weather-forecast",
      component: WeatherForecastView,
    },
  ],
});

export default router;
