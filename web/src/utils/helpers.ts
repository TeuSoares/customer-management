import { ChangeEvent } from 'react'

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

export const formatCPF = (value: string): string => {
  return value
    .replace(/\D/g, '') // Remove caracteres não numéricos
    .slice(0, 11) // Limita a 11 caracteres
    .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona ponto após os três primeiros dígitos
    .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona outro ponto após os três próximos dígitos
    .replace(/(\d{3})(\d{1,2})$/, '$1-$2') // Adiciona hífen após os últimos três dígitos
}

export const formatRG = (value: string): string => {
  return value
    .replace(/\D/g, '') // Remove caracteres não numéricos
    .slice(0, 9) // Limita a 9 caracteres
    .replace(/(\d{2})(\d)/, '$1.$2') // Adiciona ponto após os dois primeiros dígitos
    .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona outro ponto após os três próximos dígitos
    .replace(/(\d{3})(\d{1,2})$/, '$1-$2') // Adiciona hífen após os últimos três dígitos
}

export const formatPhoneNumber = (value: string): string => {
  return value
    .replace(/\D/g, '') // Remove caracteres não numéricos
    .slice(0, 11) // Limita a 11 caracteres
    .replace(/(\d{2})(\d)/, '($1) $2') // Coloca parênteses após os dois primeiros dígitos
    .replace(/(\d{5})(\d)/, '$1-$2') // Coloca hífen após os cinco primeiros dígitos
}

export const handleCPFInputChange = (event: ChangeEvent<HTMLInputElement>) => {
  event.target.value = formatCPF(event.target.value)
}

export const handleRGInputChange = (event: ChangeEvent<HTMLInputElement>) => {
  event.target.value = formatRG(event.target.value)
}

export const handlePhoneInputChange = (
  event: ChangeEvent<HTMLInputElement>,
) => {
  event.target.value = formatPhoneNumber(event.target.value)
}
