'use client'

import { useEffect, useState } from 'react'

import CardForm from '@/app/(customer)/components/card-form'
import TextField from '@/components/form/components/text-field'
import { Card } from '@/components/ui/card'

import { formSchema } from '../../adicionar-cliente/formSchema'
import CustomerIDService from '../CustomerIDService'

interface VerifyEmailProps {
  params: {
    id: number
  }
}

export default function ShowCliente({ params }: VerifyEmailProps) {
  const [isUpdate, setIsUpdate] = useState()
  const [value, setValue] = useState()
  const { handleUpdateCustomer, data } = CustomerIDService(params.id)

  useEffect(() => {
    setValue(data)
  }, [data])

  return (
    <div className="flex flex-col items-center">
      <Card className="min-[450px]:w-[450px]">
        <CardForm
          title={`Cliente: #${params.id}`}
          textButton="Editar"
          formSchema={formSchema}
          onSubmit={handleUpdateCustomer}
          defaultValues={{
            name: value?.name,
            birth_date: value?.birth_date,
            cpf: value?.cpf,
            rg: value?.rg,
            phone: value?.phone,
          }}
        >
          <TextField
            name="name"
            label="Nome"
            placeholder="Nome completo do cliente"
            disabled={!isUpdate}
          />
          <TextField
            name="birth_date"
            type="date"
            label="Data de Nascimento"
            disabled={!isUpdate}
          />
          <TextField
            name="cpf"
            label="CPF"
            placeholder="Ex: 999.999.999-99"
            disabled={!isUpdate}
          />
          <TextField
            name="rg"
            label="RG"
            placeholder="Ex: 00.000.000-0"
            disabled={!isUpdate}
          />
          <TextField
            name="phone"
            label="Telefone"
            placeholder="Ex: (19) 99999-9999"
            disabled={!isUpdate}
          />
        </CardForm>
      </Card>
    </div>
  )
}
