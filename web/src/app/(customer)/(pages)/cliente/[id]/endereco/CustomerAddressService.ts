import { useRouter } from 'next/navigation'
import { useEffect } from 'react'
import { useQuery } from 'react-query'

import { useFetch, useAppContext, useMessage, useError } from '@/hooks'

import { RegisterAddressFormData } from './adicionar/formSchema'

interface Customer {
  data: Array<{
    id: number
    customer_id: number
    address: string
    number: number
    city: string
    state: string
  }>
}

const initialData: Customer = {
  data: [
    {
      id: 0,
      customer_id: 0,
      address: '',
      number: 0,
      city: '',
      state: '',
    },
  ],
}

export default function CustomerAddressService(id: number) {
  const { get, post, destroy } = useFetch()
  const { setIsLoading } = useAppContext()
  const { setMessage } = useMessage()
  const { setError } = useError()
  const router = useRouter()

  const { data, isLoading, error, refetch } = useQuery<Customer>(
    'customer_id_address',
    async () => await get(`/customer/address/${id}`),
    {
      refetchOnWindowFocus: false,
      initialData,
      onError: (error: any) => setError(error),
    },
  )

  useEffect(() => {
    setIsLoading(isLoading)
  }, [isLoading, setIsLoading])

  const handleRegister = async (formData: RegisterAddressFormData) => {
    setIsLoading(true)

    try {
      const response = await post(`/customer/address/${id}`, formData)

      setMessage({
        description: response.message,
        status: 'success',
      })

      setIsLoading(false)
      router.push(`/cliente/${id}/endereco`)
    } catch (error: any) {
      setIsLoading(false)
      setError(error, ['address', 'number', 'city', 'state'])
    }
  }

  const handleDelete = async (idAddress: number) => {
    setIsLoading(true)

    try {
      const response = await destroy(`/customer/address/${idAddress}`)

      setMessage({
        description: response.message,
        status: 'success',
      })

      setIsLoading(false)
      refetch()
    } catch (error: any) {
      setIsLoading(false)
      setError(error)
    }
  }

  return { data: data?.data, error, handleDelete, handleRegister }
}
