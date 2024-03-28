'use client'

import TextField from '@/components/form/components/text-field'
import CardForm from '@/components/layout/card-form'
import { Card } from '@/components/ui/card'

import CustomerAddressService from '../CustomerAddressService'
import { formSchema } from './formSchema'

export default function RegisterAddress({
  params,
}: {
  params: { id: number }
}) {
  const { handleRegister } = CustomerAddressService(params.id)

  return (
    <div className="flex justify-center items-center">
      <Card className="min-[450px]:w-[450px]">
        <CardForm
          title={`Adicionar endereço para: # ${params.id}`}
          textButton="Adicionar endereço"
          formSchema={formSchema}
          onSubmit={handleRegister}
          defaultValues={{
            street_address: '',
            neighborhood: '',
            number: '',
            city: '',
            state: '',
          }}
        >
          <TextField
            name="street_address"
            label="Rua/Avenida"
            placeholder="Ex: Rua ou avenida"
          />
          <TextField
            name="neighborhood"
            label="Bairro"
            placeholder="Ex: Centro"
          />
          <TextField
            name="number"
            label="Número"
            placeholder="Somente números inteiros"
          />
          <TextField name="city" label="Cidade" placeholder="Limeira" />
          <TextField name="state" label="Estado" placeholder="Ex: São Paulo" />
        </CardForm>
      </Card>
    </div>
  )
}
