<script setup>
import { ElButton, ElForm, ElFormItem, ElMessage, ElNotification, ElOption, ElSelect } from 'element-plus';
import { onMounted, reactive } from 'vue';
import { supportLanguages } from '../data/const';
import ResultNormalType from '../assets/images/bmi-type-1.png';
import ResultPopupType from '../assets/images/bmi-type-2.png';
import { getConfig, updateConfig } from '../apis';

const form = reactive({
  lang: 'en',
  show_result_type: 'normal'
})

onMounted(async () => {
  try {
    const config = await getConfig()
    if (config.lang) {
      form.lang = config.lang
    }
    if (config.show_result_type) {
      form.show_result_type = config.show_result_type
    }
  } catch (e) {
    console.log(e)
  }
})

const onSave = async () => {
  try {
    await updateConfig(form)
    ElNotification.success({
      title: 'Success',
      message: 'Save successfully',
      position: 'bottom-right',
    })
  } catch (e) {
    ElNotification.error({
      title: 'Opps!',
      message: 'An error occurred, please try again.',
      position: 'bottom-right',
    })
  }
}

</script>

<template>
  <ElForm :model="form" label-position="left" label-width="150px">
    <ElFormItem label="Language:">
      <ElSelect v-model="form.lang" style="width: 250px;">
        <ElOption v-for="lang in supportLanguages" :key="lang.key" :value="lang.key" :label="lang.label" />
      </ElSelect>
    </ElFormItem>

    <ElFormItem label="Display result type:">
    </ElFormItem>
    <div style="display: flex;gap: 20px;">
      <div @click="form.show_result_type = 'normal'" class="display-type-item" title="Normal"
        :class="form.show_result_type === 'normal' ? 'active' : ''">
        <img alt="Normal" :src="ResultNormalType" style="width: 100%;" />
      </div>
      <div @click="form.show_result_type = 'popup'" class="display-type-item" title="Popup"
        :class="form.show_result_type === 'popup' ? 'active' : ''">
        <img alt="Popup" :src="ResultPopupType" style="width: 100%;" />
      </div>
    </div>
    <div style="margin-top: 32px;">
      <ElButton @click.prevent="onSave" type="primary" size="large">Save</ElButton>
    </div>
  </ElForm>
</template>

<style scoped>
.display-type-item {
  cursor: pointer;
  border: 3px solid transparent;
  width: 360px;
}

.display-type-item:hover {
  border: 3px solid green;
}

.display-type-item.active {
  border: 3px solid green;
}
</style>
