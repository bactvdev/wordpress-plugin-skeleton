<script setup>
import { ElTabPane, ElTabs } from 'element-plus';
import { ref } from 'vue';
import Settings from '../components/Settings.vue';

const activeTab = ref('settings');

</script>

<template>
  <div>
    <h1>BMI Calculator</h1>
    <ElTabs v-model="activeTab">
      <ElTabPane label="Settings" name="settings">
        <Settings />
      </ElTabPane>
    </ElTabs>
  </div>
</template>

<style scoped>
h1 {
  color: green;
  font-size: 1.4rem;
  margin-top: 0;
  margin-bottom: 32px;
}
</style>
