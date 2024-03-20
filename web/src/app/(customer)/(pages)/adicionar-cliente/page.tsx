'use client'

import CardForm from '../../components/card-form'
import TextField from '@/components/form/components/text-field'
import { Card } from '@/components/ui/card'

import CustomerService from '../../CustomerService'
import { formSchema } from './formSchema'

export default function AdicionarCliente() {
  const { handleRegisterCustomer } = CustomerService()

  return (
    <div className="flex justify-center items-center">
      <Card className="min-[450px]:w-[450px]">
        <CardForm
          title="Adicionar Cliente"
          textButton="Adicionar"
          formSchema={formSchema}
          onSubmit={handleRegisterCustomer}
          defaultValues={{
            name: '',
            birth_date: '',
            cpf: '',
            rg: '',
            phone: '',
          }}
        >
          <TextField
            name="name"
            label="Nome"
            placeholder="Nome completo do cliente"
          />
          <TextField name="birth_date" type="date" label="Data de Nascimento" />
          <TextField name="cpf" label="CPF" placeholder="Ex: 999.999.999-99" />
          <TextField name="rg" label="RG" placeholder="Ex: 00.000.000-0" />
          <TextField
            name="phone"
            label="Telefone"
            placeholder="Ex: (19) 99999-9999"
          />
        </CardForm>
      </Card>
    </div>
  )
}
