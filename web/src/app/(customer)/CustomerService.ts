import { useRouter } from 'next/navigation'
import { useEffect } from 'react'
import { useQuery } from 'react-query'

import { useFetch, useAppContext, useMessage, useError } from '@/hooks'

import { RegisterUserFormData } from './(pages)/adicionar-cliente/formSchema'

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

export default function CustomerService() {
  const { get, post } = useFetch()
  const { setIsLoading } = useAppContext()
  const { setMessage } = useMessage()
  const { setError } = useError()
  const router = useRouter()

  const { data, isLoading, error } = useQuery<Customer>(
    'customers',
    async () => await get('/customer'),
    {
      refetchOnWindowFocus: false,
    },
  )

  useEffect(() => {
    setIsLoading(isLoading)
  }, [isLoading, setIsLoading])

  const handleRegisterCustomer = async (formData: RegisterUserFormData) => {
    setIsLoading(true)

    try {
      const response = await post('customer', formData)

      setIsLoading(false)

      setMessage({
        title: response.message,
        description: 'Pode começar a gerencia-lo.',
        status: 'success',
      })

      router.push('/')
    } catch (error: any) {
      setIsLoading(false)
      setError(error)
    }
  }

  return { data: data?.data, error, handleRegisterCustomer }
}
