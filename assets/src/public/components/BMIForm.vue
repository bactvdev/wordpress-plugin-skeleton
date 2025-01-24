<script setup>
import { ElButton, ElForm, ElFormItem, ElInput, ElOption, ElRadio, ElRadioGroup, ElSelect } from 'element-plus';
import { reactive, ref } from 'vue';
import { calculateBMI } from '../helpers/util';

const emit = defineEmits(['onResult'])

const formInit = {
  height: 180,
  heightUnit: 'cm',
  weight: 65,
  weightUnit: 'kg',
  gender: 'male',
  age: 25
}

const form = reactive({
  ...formInit
})

const rules = {
  height: [
    { required: true, message: 'Please input your height', trigger: 'blur' },
  ],
  weight: [
    { required: true, message: 'Please input your weight', trigger: 'blur' },
  ],
  age: [
    { required: true, message: 'Please input your age', trigger: 'blur' },
  ]
}

const formRef = ref()

const handleReset = () => {
  for (const key in form) {
    form[key] = formInit[key]
  }
}

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
  <ElForm ref="formRef" :model="form" label-width="80" label-position="left" :rules="rules"
    require-asterisk-position="right">
    <ElFormItem :label="'Height'" prop="height">
      <ElInput v-model="form.height" placeholder="180" @input="(value) => form.height = value.replace(/[^0-9.]/g, '')"
        clearable>
        <template #append>
          <ElSelect v-model="form.heightUnit" style="width: 75px">
            <ElOption label="cm" value="cm" />
            <ElOption label="inch" value="inch" />
          </ElSelect>
        </template>
      </ElInput>
    </ElFormItem>
    <ElFormItem :label="'Weight'" prop="weight">
      <ElInput v-model="form.weight" placeholder="65" @input="(value) => form.weight = value.replace(/[^0-9.]/g, '')"
        clearable>
        <template #append>
          <ElSelect v-model="form.weightUnit" style="width: 75px">
            <ElOption label="kg" value="kg" />
            <ElOption label="lbs" value="lbs" />
          </ElSelect>
        </template>

      </ElInput>
    </ElFormItem>
    <ElFormItem :label="'Age'" prop="age">
      <ElInput v-model="form.age" placeholder="25" @input="(value) => form.age = value.replace(/[^0-9.]/g, '')"
        clearable />
    </ElFormItem>
    <ElFormItem :label="'Gender'" prop="gender">
      <ElRadioGroup v-model="form.gender">
        <ElRadio value="male">Male</ElRadio>
        <ElRadio value="female">Female</ElRadio>
      </ElRadioGroup>
    </ElFormItem>
    <ElFormItem>
      <ElButton @click="handleReset">Reset</ElButton>
      <ElButton type="primary" :loading="loading" @click="handleSubmit">Calculate</ElButton>
    </ElFormItem>
  </ElForm>
</template>

<style>
.el-select__placeholder {
  font-weight: 500;
  color: #000;
}
</style>
