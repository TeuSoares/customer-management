import { z } from 'zod'

export const formSchema = z.object({
  name: z
    .string()
    .max(50)
    .regex(
      new RegExp('[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$'),
      'O campo nome só pode conter letras',
    )
    .refine((value) => value.trim().length > 0, {
      message: 'O campo nome não pode conter apenas espaços',
    })
    .transform((name) => {
      return name
        .trim()
        .split(' ')
        .map((word) => {
          return word[0].toLocaleUpperCase().concat(word.substring(1))
        })
        .join(' ')
    }),
  birth_date: z
    .string()
    .regex(/^\d{4}-\d{2}-\d{2}$/, { message: 'Data de nascimento inválida' })
    .refine((value) => value <= new Date().toISOString().split('T')[0], {
      message: 'A data de nascimento não pode ser maior que a data atual.',
    }),
  cpf: z
    .string()
    .regex(/^\d{3}\.\d{3}\.\d{3}-\d{2}$/, { message: 'CPF inválido' }),
  rg: z
    .string()
    .regex(/^\d{2}\.\d{3}\.\d{3}-\d{1}$/, { message: 'RG inválido' }),
  phone: z
    .string()
    .regex(/^\(\d{2}\) \d{5}-\d{4}$/, { message: 'Telefone inválido' }),
})

export type RegisterUserFormData = z.infer<typeof formSchema>
