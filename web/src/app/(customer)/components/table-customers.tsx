'use client'

import { useAppContext } from '@/hooks'

import { convertDataToBR } from '@/utils/helpers'

import LinkButton from '@/components/layout/link-button'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

import CustomerService from '../(pages)/CustomerService'

const TableCustomers = () => {
  const { data } = CustomerService()
  const { isLoading } = useAppContext()

  return (
    <Table className="w-ful text-center">
      {!isLoading && !data?.length && (
        <TableCaption className="text-white">
          Parece que você ainda não possui clientes para gerenciar.
        </TableCaption>
      )}
      <TableHeader className="bg-[#BC2627]">
        <TableRow>
          <TableHead className="text-white text-center">Nome</TableHead>
          <TableHead className="text-white text-center">
            Data de Nascimento
          </TableHead>
          <TableHead className="text-white text-center">CPF</TableHead>
          <TableHead className="text-center text-white">RG</TableHead>
          <TableHead className="text-center text-white">Telefone</TableHead>
          <TableHead className="text-center text-white">#</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody className="bg-[#111111] text-white">
        {data?.map((customer) => (
          <TableRow key={customer.id}>
            <TableCell>{customer.name}</TableCell>
            <TableCell>{convertDataToBR(customer.birth_date)}</TableCell>
            <TableCell>{customer.cpf}</TableCell>
            <TableCell>{customer.rg}</TableCell>
            <TableCell>{customer.phone}</TableCell>
            <TableCell>
              <LinkButton
                href={`/cliente/${customer.id}`}
                label="Visualizar"
                className="bg-[#BC2627] hover:bg-[#9e3535] hover:text-white"
              />
            </TableCell>
          </TableRow>
        ))}
      </TableBody>
    </Table>
  )
}

export default TableCustomers
