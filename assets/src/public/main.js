import { createApp } from "vue";
import App from './App.vue';
import setupI18n from "./plugins/i18n";

(async () => {
  const app = createApp(App);

  const i18n = await setupI18n()

  app.use(i18n);
  app.mount('#wordpress-plugin-frontend-app');
})()
