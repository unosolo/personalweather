import { createApp } from "vue";
import { createPinia } from "pinia";

import { BootstrapVueNext } from "bootstrap-vue-next";

import App from "./App.vue";
import router from "./router";

// Import Bootstrap and BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-vue-next/dist/bootstrap-vue-next.css";
import "bootstrap-icons/font/bootstrap-icons.min.css";

import "./assets/main.css";

const app = createApp(App);

// Make BootstrapVue available throughout your project
app.use(BootstrapVueNext);
// Optionally install the BootstrapVue icon components plugin
//app.use(BootstrapVueNextIcons);

app.config.globalProperties.msg = "Hello";

app.use(createPinia());
app.use(router);

app.mount("#app");
