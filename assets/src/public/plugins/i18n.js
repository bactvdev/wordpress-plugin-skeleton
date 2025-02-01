import {createI18n} from "vue-i18n";

const messages = ['en', 'vi'];

const getMessagesLocale = async () => {
  const locales = {};
  for (const lang of messages) {
    locales[lang] = await import(`../locales/${lang}.json`);
  }
  return locales;
};

const setupI18n = async () => {
  const messages = await getMessagesLocale();

  return createI18n({
    locale: "en",
    fallbackLocale: "en",
    messages,
  });
};

export default setupI18n;
