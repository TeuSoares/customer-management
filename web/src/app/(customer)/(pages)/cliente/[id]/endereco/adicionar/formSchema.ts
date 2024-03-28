import { z } from 'zod'

export const formSchema = z.object({
  street_address: z
    .string()
    .min(1, { message: 'Você precisa inserir uma rua ou avenida.' })
    .max(80)
    .regex(/^[a-zA-Z0-9\s]*$/, {
      message: 'O campo logradouro só pode conter letras e números',
    })
    .refine((value) => value.trim().length > 0, {
      message: 'O campo rua/avenida não pode conter apenas espaços',
    }),
  neighborhood: z
    .string()
    .min(1, { message: 'O bairro é obrigatório.' })
    .max(80)
    .regex(/^[a-zA-Z0-9\s]*$/, {
      message: 'O campo bairro só pode conter letras e números',
    })
    .refine((value) => value.trim().length > 0, {
      message: 'O campo bairro não pode conter apenas espaços',
    }),
  number: z
    .string()
    .min(1, { message: 'O número é obrigatório.' })
    .regex(/^\d+$/, {
      message: 'O campo número só pode conter números inteiros e positivos.',
    }),
  city: z
    .string()
    .min(1, { message: 'A cidade é obrigatória.' })
    .regex(
      new RegExp('[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$'),
      'O campo cidade só pode conter letras',
    )
    .refine((value) => value.trim().length > 0, {
      message: 'O campo cidade não pode conter apenas espaços',
    }),
  state: z
    .string()
    .min(1, { message: 'O estado é obrigatório.' })
    .regex(
      new RegExp('[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$'),
      'O campo estado só pode conter letras',
    )
    .refine((value) => value.trim().length > 0, {
      message: 'O campo estado não pode conter apenas espaços',
    }),
})

export type RegisterAddressFormData = z.infer<typeof formSchema>
