import { useRouter } from 'next/navigation'

import { useError, useFetch, useMessage, useAppContext } from '@/hooks'

import { CreateUserFormData } from './formSchema'

export default function RegisterService() {
  const { setMessage } = useMessage()
  const { setError } = useError()
  const { post } = useFetch()
  const { setIsLoading } = useAppContext()
  const router = useRouter()

  const handleRegister = async (formData: CreateUserFormData) => {
    setIsLoading(true)

    try {
      const response = await post('register', formData)

      setMessage({
        title: response.message,
        description:
          'Seu cadastro foi realizado com sucesso. Faça login para começar a gerenciar seus clientes.',
        status: 'success',
      })

      router.push('login')
    } catch (error: any) {
      setError(error, ['name', 'email', 'password'])
    }

    setIsLoading(false)
  }

  return { handleRegister }
}
