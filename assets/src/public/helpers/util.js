export function centimetToMeter(value) {
  return value / 100
}

export function inchToMeter(value) {
  return 0.0254 * value
}

export function lbsToKg(value) {
  return value * 0.45359237
}

export function calculateBMI(height, heightUnit = 'cm', weight, weightUnit = 'kg', age, gender) {
  if (heightUnit.toLowerCase() === 'inch') {
    height = inchToMeter(height)
  } else {
    height = centimetToMeter(height)
  }

  if (weightUnit.toLowerCase() === 'lbs') {
    weight = lbsToKg(weight)
  }

  if (height === 0) {
    return 0
  }

  return (weight / Math.pow(height, 2)).toFixed(1)
}
