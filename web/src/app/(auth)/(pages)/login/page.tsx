'use client'

import CardFooterLink from '../../../../components/layout/card-footer-link'
import TextField from '@/components/form/components/text-field'
import CardForm from '@/components/layout/card-form'

import { formSchema } from '../login/formSchema'
import LoginService from '../login/LoginService'

export default function Login() {
  const { handleLogin } = LoginService()

  return (
    <>
      <CardForm
        title="Faça Login"
        description="Faça login para acessar o painel administrativo."
        textButton="Entrar"
        formSchema={formSchema}
        onSubmit={handleLogin}
        defaultValues={{
          email: '',
          password: '',
        }}
      >
        <TextField
          name="email"
          type="email"
          label="E-mail"
          placeholder="Insira seu e-mail"
        />
        <TextField
          name="password"
          type="password"
          label="Senha"
          placeholder="Insira sua senha"
        />
      </CardForm>
      <CardFooterLink
        description="Ainda não é cadastrado?"
        textLink="Criar uma conta"
        href="register"
      />
    </>
  )
}
