'use client'

import {
  convertDataToBR,
  formatCPF,
  formatPhoneNumber,
  formatRG,
} from '@/utils/helpers'

import InfoBox from '@/components/layout/info-box'
import LinkButton from '@/components/layout/link-button'
import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

import CustomerIDService from './CustomerIDService'

export default function ShowCustomer({ params }: { params: { id: number } }) {
  const { data, handleDelete } = CustomerIDService(params.id)

  return (
    <div className="flex flex-col justify-center items-center">
      <Card className="min-[600px]:w-[600px]">
        <CardHeader>
          <CardTitle>Cliente: # {params.id}</CardTitle>
          <CardDescription>
            Esses são os dados do cliente selecionado.
          </CardDescription>
        </CardHeader>
        <CardContent className="grid gap-4">
          <div className=" flex items-center space-x-4 rounded-md">
            <LinkButton
              className="bg-[#BC2627] hover:bg-[#9e3535] hover:text-white"
              href={`/cliente/${data!.id}/editar`}
              label="Editar"
            />
            <Button
              className="font-bold bg-[#BC2627] hover:bg-[#9e3535]"
              onClick={handleDelete}
            >
              Deletar
            </Button>
            <LinkButton
              className="bg-[#BC2627] hover:bg-[#9e3535] hover:text-white"
              href={`/cliente/${data!.id}/endereco`}
              label="Endereços cadastrados"
            />
          </div>
          <InfoBox title="Nome completo:" description={data!.name} />
          <InfoBox
            title="Data de nascimento:"
            description={convertDataToBR(data!.birth_date)}
          />
          <InfoBox title="CPF:" description={formatCPF(data!.cpf)} />
          <InfoBox title="RG:" description={formatRG(data!.rg)} />
          <InfoBox
            title="Telefone:"
            description={formatPhoneNumber(data!.phone)}
          />
        </CardContent>
      </Card>
    </div>
  )
}
