export const BMIAllLevels = [
  { key: 'severe_th', label: 'Severe Thinness', value: '< 16', rangeValues: [0, 16], color: '#98dcf5' },
  { key: 'moderate_th', label: 'Moderate Thinness', value: '16 - 17', rangeValues: [16, 17], color: '#98edf5' },
  { key: 'mild_th', label: 'Mild Thinness', value: '17 - 18.5', rangeValues: [17, 18.5], color: '#98f5ed' },
  { key: 'normal', label: 'Normal', value: '18.5 - 25', rangeValues: [18.5, 25], color: '#60cc1d' },
  { key: 'overweight', label: 'Overweight', value: '25 - 30', rangeValues: [25, 30], color: '#dede1f' },
  { key: 'obese_one', label: 'Obese Class I', value: '30 - 35', rangeValues: [30, 35], color: '#f2b23a' },
  { key: 'obese_two', label: 'Obese Class II', value: '35 - 40', rangeValues: [35, 40], color: '#de9b1f' },
  { key: 'obese_three', label: 'Obese Class III', value: '> 40', rangeValues: [40, null], color: '#de521f' },
]

export const BMILevelGroups = [
  { key: 'a', ranges: [0, 18.5], angles: [0, 25] },
  { key: 'b', ranges: [18.5, 25], angles: [25, 50] },
  { key: 'c', ranges: [25, 30], angles: [50, 75] },
  { key: 'd', ranges: [30, 100], angles: [75, 100] },
]
