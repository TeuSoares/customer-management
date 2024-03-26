'use client'

import {
  formatCPF,
  formatPhoneNumber,
  formatRG,
  handleCPFInputChange,
  handlePhoneInputChange,
  handleRGInputChange,
} from '@/utils/helpers'

import TextField from '@/components/form/components/text-field'
import CardForm from '@/components/layout/card-form'
import { Card } from '@/components/ui/card'

import { formSchema } from '../../adicionar/formSchema'
import CustomerIDService from '../CustomerIDService'

export default function UpdateCustomer({ params }: { params: { id: number } }) {
  const { data, handleUpdate } = CustomerIDService(params.id)

  return (
    <div className="flex justify-center items-center">
      <Card className="min-[450px]:w-[450px]">
        <CardForm
          title={`Editando Cliente: # ${params.id}`}
          textButton="Editar"
          formSchema={formSchema}
          onSubmit={handleUpdate}
          defaultValues={{
            name: data!.name,
            birth_date: data!.birth_date,
            cpf: formatCPF(data!.cpf),
            rg: formatRG(data!.rg),
            phone: formatPhoneNumber(data!.phone),
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
