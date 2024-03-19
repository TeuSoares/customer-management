'use client'

import CardFooterLink from '../../components/card-footer-link'
import CardForm from '@/app/(auth)/components/card-form'
import TextField from '@/components/form/components/text-field'

import { formSchema } from './formSchema'
import RegisterService from './RegisterService'

export default function RegisterUser() {
  const { handleRegister } = RegisterService()

  return (
    <>
      <CardForm
        title="Cadastre-se"
        description="Cadastra-se para gerenciar seus clientes."
        textButton="Cadastrar"
        formSchema={formSchema}
        onSubmit={handleRegister}
        defaultValues={{
          name: '',
          email: '',
          password: '',
        }}
      >
        <TextField name="name" label="Nome" placeholder="Seu nome completo" />
        <TextField
          name="email"
          type="email"
          label="E-mail"
          placeholder="Insira seu E-mail"
        />
        <TextField
          name="password"
          type="password"
          label="Senha"
          placeholder="Insira uma senha entre 6 a 12 caracteres"
        />
      </CardForm>
      <CardFooterLink
        description="Já possui uma conta?"
        textLink="Clique aqui para fazer login"
        href="login"
      />
    </>
  )
}
