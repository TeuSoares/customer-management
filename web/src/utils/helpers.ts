export const builderQueryParams = (data: { [attr: string]: any }) =>
  new URLSearchParams(data).toString()

export const setHours = (hours: number) => {
  const date = new Date()
  date.setHours(date.getHours() + hours)
  date.toLocaleDateString('pt-br')

  return date
}

export const convertDataToBR = (data: string): string => {
  const dataObj = new Date(data)

  return dataObj.toLocaleString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}
