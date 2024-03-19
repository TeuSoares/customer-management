import { z } from 'zod'

export const formSchema = z.object({
  email: z.string().email('E-mail inválido'),
  password: z.string().min(1, 'A senha é obrigatória'),
})

export type LoginFormData = z.infer<typeof formSchema>
