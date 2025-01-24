<script setup>
import { ElButton, ElForm, ElFormItem, ElInput, ElOption, ElRadio, ElRadioGroup, ElSelect } from 'element-plus';
import { reactive, ref } from 'vue';
import { calculateBMI } from '../helpers/util';

const emit = defineEmits(['onResult'])

const form = reactive({
  height: 180,
  heightUnit: 'cm',
  weight: 65,
  weightUnit: 'kg',
  gender: 'male',
  age: 25
})

const rules = {
  height: [
    { required: true, message: '', trigger: 'blur' },
  ],
  weight: [
    { required: true, message: '', trigger: 'blur' },
  ],
  age: [
    { required: true, message: '', trigger: 'blur' },
  ]
}

const formRef = ref()

const loading = ref(false)

const handleSubmit = async () => {
  if (!formRef.value) return

  await formRef.value.validate((isValid) => {
    if (!isValid) return
    loading.value = true
    setTimeout(() => {
      const bmi = calculateBMI(form.height, form.heightUnit, form.weight, form.weightUnit, form.age, form.gender)
      emit('onResult', bmi)
      loading.value = false
    }, 500)
  })
}

</script>

<template>
  <ElForm class="bmi-form" ref="formRef" :model="form" label-width="100" label-position="left" :rules="rules"
    require-asterisk-position="right">
    <ElFormItem :label="$t('form.field.height')" prop="height">
      <ElInput v-model="form.height" :placeholder="$t('form.placeholder.input_height')"
        @input="(value) => form.height = value.replace(/[^0-9.]/g, '')" clearable>
        <template #append>
          <ElSelect v-model="form.heightUnit" style="width: 75px">
            <ElOption label="cm" value="cm" />
            <ElOption label="inch" value="inch" />
          </ElSelect>
        </template>
      </ElInput>
    </ElFormItem>
    <ElFormItem :label="$t('form.field.weight')" prop="weight">
      <ElInput v-model="form.weight" :placeholder="$t('form.placeholder.input_weight')"
        @input="(value) => form.weight = value.replace(/[^0-9.]/g, '')" clearable>
        <template #append>
          <ElSelect v-model="form.weightUnit" style="width: 75px">
            <ElOption label="kg" value="kg" />
            <ElOption label="lbs" value="lbs" />
          </ElSelect>
        </template>

      </ElInput>
    </ElFormItem>
    <ElFormItem :label="$t('form.field.age')" prop="age">
      <ElInput v-model="form.age" :placeholder="$t('form.placeholder.input_age')"
        @input="(value) => form.age = value.replace(/[^0-9.]/g, '')" clearable />
    </ElFormItem>
    <ElFormItem :label="$t('form.field.gender')" prop="gender">
      <ElRadioGroup v-model="form.gender">
        <ElRadio value="male">{{ $t('form.field.male') }}</ElRadio>
        <ElRadio value="female">{{ $t('form.field.female') }}</ElRadio>
      </ElRadioGroup>
    </ElFormItem>
    <ElFormItem>
      <ElButton type="primary" :loading="loading" @click="handleSubmit">{{ $t('calculate') }}</ElButton>
    </ElFormItem>
  </ElForm>
</template>

<style>
.bmi-form {
  padding: 12px;
}

.el-select__placeholder {
  font-weight: 500;
  color: #000;
}
</style>
