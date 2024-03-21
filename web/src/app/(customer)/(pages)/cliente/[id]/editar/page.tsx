'use client'

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
            cpf: data!.cpf,
            rg: data!.rg,
            phone: data!.phone,
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
