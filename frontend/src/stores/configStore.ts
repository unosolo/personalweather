import { ref } from "vue";
import { defineStore } from "pinia";

export const useConfigStore = defineStore("config", () => {
  const config = ref({
    api: "http://localhost",
  });

  return config.value;
});
