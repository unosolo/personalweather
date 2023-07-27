<script setup lang="ts">
import { ref, onBeforeMount } from "vue";

const apiResponse = ref(null);

onBeforeMount(() => {
  fetchData();
});

async function fetchData() {
  const url = "http://localhost/";

  apiResponse.value = await (await fetch(url)).json();
}
</script>

<template>
  <div v-if="!apiResponse">Pinging the api...</div>

  <div v-if="apiResponse">
    The api responded with: <br />
    <code>
      {{ apiResponse }}
    </code>
  </div>
</template>
