export const getConfig = async () => {
  const res = await fetch('/wp-json/healthcheck-bmi/v1/config')
  return await res.json()
}
