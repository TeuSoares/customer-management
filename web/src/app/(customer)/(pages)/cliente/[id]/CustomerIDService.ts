import { useRouter } from 'next/navigation'
import { useEffect } from 'react'
import { useQuery } from 'react-query'

import { useFetch, useAppContext, useMessage, useError } from '@/hooks'

import { RegisterUserFormData } from '../adicionar/formSchema'

interface Customer {
  data: {
    id: number
    user_id: number
    name: string
    birth_date: string
    cpf: string
    rg: string
    phone: string
  }
}

const initialData: Customer = {
  data: {
    id: 0,
    user_id: 0,
    name: '',
    birth_date: '',
    cpf: '',
    rg: '',
    phone: '',
  },
}

export default function CustomerIDService(id: number) {
  const { get, destroy, put } = useFetch()
  const { setIsLoading } = useAppContext()
  const { setMessage } = useMessage()
  const { setError } = useError()
  const router = useRouter()

  const { data, isLoading, error } = useQuery<Customer>(
    'customer_id',
    async () => await get(`/customer/${id}`),
    {
      refetchOnWindowFocus: false,
      initialData,
    },
  )

  useEffect(() => {
    setIsLoading(isLoading)
  }, [isLoading, setIsLoading])

  const handleUpdate = async (formData: RegisterUserFormData) => {
    setIsLoading(true)

    try {
      const response = await put(`/customer/${id}`, formData)

      setMessage({
        description: response.message,
        status: 'success',
      })

      setIsLoading(false)
      router.push(`/cliente/${id}`)
    } catch (error: any) {
      setIsLoading(false)
      setError(error)
    }
  }

  const handleDelete = async () => {
    setIsLoading(true)

    try {
      const response = await destroy(`/customer/${id}`)

      setMessage({
        description: response.message,
        status: 'success',
      })

      setIsLoading(false)
      router.push('/')
    } catch (error: any) {
      setIsLoading(false)
      setError(error)
    }
  }

  return { data: data?.data, error, handleUpdate, handleDelete }
}
