<script setup>
import * as echarts from 'echarts';
import { nextTick, onBeforeUnmount, onMounted, reactive, ref, watch } from 'vue';
import BMILevelInfo from './BMILevelInfo.vue';
import { BMIAllLevels, BMILevelGroups } from '../helpers/data';
import { useI18n } from 'vue-i18n';

const { t } = useI18n()

const props = defineProps({
  result: {
    type: Number,
    default: -1
  }
})

const BMILevels = ref([
  { valueOriginal: 18.5, value: 25, name: t('bmi_levels.underweight'), itemStyle: { color: '#98f5ed' } },
  { valueOriginal: 24.9, value: 25, name: t('bmi_levels.normal'), itemStyle: { color: '#60cc1d' } },
  { valueOriginal: 29.9, value: 25, name: t('bmi_levels.overweight'), itemStyle: { color: '#dede1f' } },
  { valueOriginal: 30, value: 25, name: t('bmi_levels.obese'), itemStyle: { color: '#de521f' } },
])

const option = reactive({
  title: {
    text: '',
    left: 'center',
    textStyle: {
    },
    subtext: '',
    subtextStyle: {
      fontSize: 14
    }
  },
  tooltip: {
    show: false
  },
  legend: {
    show: false
  },
  yAxis: {
    show: false
  },
  series: [
    {
      name: 'BMI',
      type: 'pie',
      radius: ['40%', '70%'],
      center: ['50%', '70%'],
      startAngle: 180,
      endAngle: 360,
      label: {
        show: true,
        position: 'outside',
        fontSize: 13,
      },
      data: BMILevels.value
    },
    {
      type: 'gauge',
      z: 3,
      center: ['50%', '70%'],
      startAngle: 180,
      endAngle: 0,
      min: 0,
      max: 100,
      pointer: {
        icon: 'path://M2090.36389,615.30999 L2090.36389,615.30999 C2091.48372,615.30999 2092.40383,616.194028 2092.44859,617.312956 L2096.90698,728.755929 C2097.05155,732.369577 2094.2393,735.416212 2090.62566,735.56078 C2090.53845,735.564269 2090.45117,735.566014 2090.36389,735.566014 L2090.36389,735.566014 C2086.74736,735.566014 2083.81557,732.63423 2083.81557,729.017692 C2083.81557,728.930412 2083.81732,728.84314 2083.82081,728.755929 L2088.2792,617.312956 C2088.32396,616.194028 2089.24407,615.30999 2090.36389,615.30999 Z',
        length: '70%',
        width: 8,
      },
      axisLine: {
        show: false
      },
      axisTick: {
        show: false
      },
      splitLine: {
        show: false
      },
      axisLabel: {
        show: false
      },
      title: {
        show: false
      },
      detail: {
        show: false
      },
      data: [
        {
          value: 0
        }
      ]
    }
  ]
});

const myChart = ref()

onMounted(() => {
  const chartDom = document.getElementById('bmi-chart');
  nextTick(() => {
    myChart.value = echarts.init(chartDom);

    if (props.result === -1) {
      myChart.value.setOption(option)
      return
    }
  })

  if (props.result !== -1) {
    const opts = showResult(props.result);
    setTimeout(() => {
      myChart.value.setOption(opts)
    }, 300)
  }
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', () => resizeChart(myChart))
})

const showResult = (newValue) => {
  // get level
  let levelSelected = null
  for (const level of BMIAllLevels) {
    if (level.rangeValues[0] <= newValue && ((level.rangeValues[1] && level.rangeValues[1] > newValue) || !level.rangeValues[1])) {
      levelSelected = level
      break
    }
  }

  // cal arrow angle
  const group = BMILevelGroups.filter(it => it.ranges[0] <= newValue && it.ranges[1] > newValue)[0]
  if (!group) return
  const angle = Math.round((newValue - group.ranges[0]) * ((group.angles[1] - group.angles[0]) / (group.ranges[1] - group.ranges[0])) + group.angles[0])

  const newOptions = {
    ...option
  }
  newOptions.title.text = t('result_text', { value: newValue })
  newOptions.title.subtext = t('bmi_levels.' + levelSelected.key)
  newOptions.title.subtextStyle.color = levelSelected.color ?? ''
  newOptions.series[1].data = [{ value: angle }]
  return newOptions
}

watch(
  () => props.result,
  (newValue) => {
    const newOptions = showResult(newValue)
    if (myChart.value) {
      myChart.value.setOption(newOptions)
    }
  }
)
</script>

<template>
  <div class="result-box">
    <div style="margin: 0 auto;width: 100%;">
      <div id="bmi-chart"></div>
    </div>
    <div class="bmi-info">
      <BMILevelInfo />
    </div>
  </div>
</template>

<style scoped>
.result-box {
  display: grid;
  grid-template-columns: 60% auto;
  gap: 20px;
  width: 100%;
}

#bmi-chart {
  height: 300px;
}

@media only screen and (max-width: 767px) {
  .result-box {
    display: grid;
    grid-template-columns: auto;
    gap: 0;
  }
}

@media only screen and (max-width: 430px) {
  #bmi-chart {
    height: 240px;
  }
}
</style>
