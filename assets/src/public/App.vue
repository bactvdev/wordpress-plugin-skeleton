<script setup>
import { onMounted, ref } from 'vue';
import BMIForm from './components/BMIForm.vue';
import BMIResult from './components/BMIResult.vue';
import BMIPopupResult from './components/BMIPopupResult.vue';
import { useI18n } from 'vue-i18n';
import { getConfig } from './apis';

const { locale } = useI18n()

const btnLoading = ref(false)
const result = ref(-1)

const isShowPopupResult = ref(false)
const isPopupResult = ref(false)

const getResult = (rs) => {
  result.value = rs
  if (isPopupResult.value) {
    isShowPopupResult.value = true
  }
}

const loadingPage = ref(true)
onMounted(async () => {
  const config = await getConfig()

  locale.value = config.lang ?? 'en'
  if (config.show_result_type === 'popup') {
    isPopupResult.value = true
  }

  loadingPage.value = false
})

</script>

<template>
  <div class="healthcheck-bmi-box" v-loading="loadingPage">
    <h1 class="bmi-title">{{ $t('title') }}</h1>
    <div class="healthcheck-bmi-form">
      <BMIForm :loading="btnLoading" @on-result="getResult" />
    </div>
    <div class="healthcheck-bmi-result" v-if="!loadingPage">
      <BMIPopupResult v-if="isPopupResult" v-model="isShowPopupResult" :result="result" />
      <BMIResult v-else :result="result" />
    </div>
  </div>
</template>

<style>
@import 'element-plus/dist/index.css';
</style>
<style scoped>
.healthcheck-bmi-form {
  width: 50%;
  margin: 0 auto;
  margin-bottom: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
}

.bmi-title {
  text-align: center;
  font-size: 1.4rem;
  font-weight: bold;
  margin-bottom: 24px;
}

@media only screen and (max-width: 767px) {
  .healthcheck-bmi-form {
    width: 100%;
  }
}
</style>
