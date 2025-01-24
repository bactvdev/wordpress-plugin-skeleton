<script setup>
import { ElIcon } from 'element-plus';
import DotIcon from '../icons/DotIcon.vue';
import { BMIAllLevels as items } from '../helpers/data';

</script>

<template>
  <div class="bmi-level-list">
    <div class="bmi-level-list-item" v-for="item in items" :key="item.key">
      <div style="display: flex;align-items: center;gap: 2px;">
        <ElIcon size="24">
          <DotIcon :style="'color: ' + item.color" />
        </ElIcon>
        <span class="bmi-label">{{ $t('bmi_levels.' + item.key) }}</span>
      </div>
      <span class="bmi-value">{{ item.value }}</span>
    </div>
  </div>
</template>

<style scoped>
.bmi-level-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
  border-radius: 8px;
  padding: 12px;
  background-color: #f9f9f9;
}

.bmi-level-list-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
  font-size: 0.9rem;
}

.bmi-value {
  font-weight: 500;
}
</style>
