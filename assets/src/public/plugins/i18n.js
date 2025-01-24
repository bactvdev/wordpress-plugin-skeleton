import { createI18n } from "vue-i18n";

const messages = ['ar', 'de', 'en', 'es', 'fr', 'ja', 'pt', 'ru', 'vi', 'zh'];

const getMessagesLocale = async () => {
  const locales = {};
  for (const lang of messages) {
    locales[lang] = await import(`../locales/${lang}.json`);
  }
  return locales;
};

const setupI18n = async () => {
  const messages = await getMessagesLocale();

  const i18n = createI18n({
    locale: "en",
    fallbackLocale: "en",
    messages,
  });

  return i18n;
};

export default setupI18n;
