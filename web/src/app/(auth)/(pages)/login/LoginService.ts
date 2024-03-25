import { useRouter } from 'next/navigation'

import { useError, useFetch, useMessage, useAppContext } from '@/hooks'

import { setHours } from '@/utils/helpers'

import { LoginFormData } from './formSchema'

import { setCookie } from 'cookies-next'

export default function LoginService() {
  const { setMessage } = useMessage()
  const { setError } = useError()
  const { post } = useFetch()
  const { setIsLoading } = useAppContext()
  const router = useRouter()

  const handleLogin = async (formData: LoginFormData) => {
    setIsLoading(true)

    try {
      const response = await post('login', formData)

      setIsLoading(false)

      setMessage({
        title: response.message,
        description: 'Agora você pode gerenciar seus clientes',
        status: 'success',
      })

      setCookie('token', response.data.token, {
        expires: setHours(22),
      })

      router.push('/')
    } catch (error: any) {
      setIsLoading(false)
      setError(error, ['required', 'user'])
    }
  }

  return { handleLogin }
}
