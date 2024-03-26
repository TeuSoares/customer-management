'use client'

import {
  handleCPFInputChange,
  handlePhoneInputChange,
  handleRGInputChange,
} from '@/utils/helpers'

import CardForm from '../../../../../components/layout/card-form'
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
          <TextField
            name="cpf"
            label="CPF"
            placeholder="99999999999"
            onChange={handleCPFInputChange}
          />
          <TextField
            name="rg"
            label="RG"
            placeholder="000000000"
            onChange={handleRGInputChange}
          />
          <TextField
            name="phone"
            label="Telefone"
            placeholder="19999999999"
            onChange={handlePhoneInputChange}
          />
        </CardForm>
      </Card>
    </div>
  )
}
