// import { useRouter } from 'next/navigation'
import { useEffect } from 'react'
import { useQuery } from 'react-query'

import { useFetch, useAppContext, useMessage, useError } from '@/hooks'

import { RegisterUserFormData } from '../adicionar-cliente/formSchema'

interface Customer {
  data: Array<{
    id: number
    user_id: number
    name: string
    birth_date: string
    cpf: string
    rg: string
    phone: string
  }>
}

export default function CustomerIDService(id: number) {
  const { get, post } = useFetch()
  const { setIsLoading } = useAppContext()
  const { setMessage } = useMessage()
  const { setError } = useError()
  // const router = useRouter()

  const { data, isLoading, error } = useQuery<Customer>(
    'customer_id',
    async () => await get(`/customer/${id}`),
    {
      refetchOnWindowFocus: false,
    },
  )

  useEffect(() => {
    setIsLoading(isLoading)
  }, [isLoading, setIsLoading])

  const handleUpdateCustomer = async (formData: RegisterUserFormData) => {
    setIsLoading(true)

    try {
      const response = await post(`/customer/${id}`, formData)

      setMessage({
        description: response.message,
        status: 'success',
      })

      setIsLoading(false)
    } catch (error: any) {
      setIsLoading(false)
      setError(error)
    }
  }

  return { data: data?.data, error, handleUpdateCustomer }
}
