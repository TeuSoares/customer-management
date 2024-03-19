import { z } from 'zod'

export const formSchema = z.object({
  name: z
    .string()
    .max(50)
    .regex(
      new RegExp('[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$'),
      'O campo nome só pode conter letras',
    )
    .transform((name) => {
      return name
        .trim()
        .split(' ')
        .map((word) => {
          return word[0].toLocaleUpperCase().concat(word.substring(1))
        })
        .join(' ')
    }),
  email: z.string().email('E-mail inválido').max(50),
  password: z
    .string()
    .min(6, 'A senha deve conter pelo menos 6 caracteres.')
    .max(12, 'A senha só deve conter no máximo 12 caracteres.'),
})

export type CreateUserFormData = z.infer<typeof formSchema>
