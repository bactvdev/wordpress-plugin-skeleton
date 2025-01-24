<script setup>
import { ElButton, ElDialog } from 'element-plus';
import BMIResult from './BMIResult.vue';
import { nextTick, onMounted, ref } from 'vue';

const dialogVisible = defineModel()

const props = defineProps({
  result: {
    type: Number,
    default: 0
  }
})

</script>

<template>
  <ElDialog v-model="dialogVisible" title="" modal-class="bmi-popup-result" :show-close="false">
    <BMIResult :result="props.result" />

    <template #footer>
      <ElButton @click="dialogVisible = false" type="primary">OK</ElButton>
    </template>
  </ElDialog>
</template>

<style>
.bmi-popup-result .el-dialog {
  width: 680px;
}

@media only screen and (max-width: 767px) {
  .bmi-popup-result .el-dialog {
    width: 98%;
  }
}

@media only screen and (max-width: 360px) {
  .bmi-popup-result .el-dialog {
    width: 352.8px;
  }
}
</style>
