<script setup>
import { ElButton, ElDialog } from 'element-plus';
import BMIResult from './BMIResult.vue';

const dialogVisible = defineModel()

const props = defineProps({
  result: {
    type: Number,
    default: 0
  }
})

</script>

<template>
  <ElDialog v-model="dialogVisible" title="" modal-class="bmi-popup-result" append-to-body :show-close="false">
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
</style>
