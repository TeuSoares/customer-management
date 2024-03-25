import { useMessage } from './useMessage'

interface Params {
  response: {
    data: {
      validations: { [x: string]: string }
      message: string
    }
  }
}

export const useError = () => {
  const { setMessage } = useMessage()

  const setError = (instance: Params, keys: Array<string> = []) => {
    if (
      !instance.response.data.validations &&
      !instance.response.data.message
    ) {
      setMessage({
        description:
          'Houve algum erro ao processar sua solicitação. Tente novamente mais tarde.',
        status: 'error',
      })
      return
    }

    if (instance.response.data.message) {
      setMessage({
        description: instance.response.data.message,
        status: 'error',
      })
      return
    }

    const errors = instance.response.data.validations

    for (const key of keys) {
      if (errors[key]) {
        setMessage({ description: errors[key], status: 'error' })
        return
      }
    }

    setMessage({ description: errors[0] as string, status: 'error' })
  }

  return { setError }
}
