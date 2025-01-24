<script setup>
import { ref } from 'vue';
import BMIForm from './components/BMIForm.vue';
import BMIResult from './components/BMIResult.vue';
import BMIPopupResult from './components/BMIPopupResult.vue';

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

</script>

<template>
  <div class="healthcheck-bmi-box">
    <h1 class="bmi-title">{{ $t('title') }}</h1>
    <div class="healthcheck-bmi-form">
      <BMIForm :loading="btnLoading" @on-result="getResult" />
    </div>
    <div class="healthcheck-bmi-result">
      <BMIPopupResult v-if="isPopupResult" v-model="isShowPopupResult" :result="result" />
      <BMIResult v-else :result="result" />
    </div>
  </div>
</template>

<style scoped>
.healthcheck-bmi-form {
  width: 50%;
  margin: 0 auto;
  margin-bottom: 40px;
}

.bmi-title {
  text-align: center;
  font-size: 1.4rem;
  font-weight: bold;
  margin-bottom: 32px;
}

@media only screen and (max-width: 767px) {
  .healthcheck-bmi-form {
    width: 100%;
  }
}
</style>
