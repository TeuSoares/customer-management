import { z } from 'zod'

export const formSchema = z.object({
  address: z
    .string()
    .min(1, { message: 'O endereço é obrigatório.' })
    .max(80)
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
  number: z
    .string()
    .min(1, { message: 'O número é obrigatório.' })
    .regex(/^\d+$/, {
      message: 'O campo número só pode conter números inteiros e positivos.',
    }),
  city: z.string().min(1, { message: 'A cidade é obrigatória.' }),
  state: z.string().min(1, { message: 'O estado é obrigatório.' }),
})

export type RegisterAddressFormData = z.infer<typeof formSchema>
