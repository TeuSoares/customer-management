'use client'

import { useAppContext } from '@/hooks'

import { convertDataToBR } from '@/utils/helpers'

import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

import CustomerService from '../CustomerService'

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
          </TableRow>
        ))}
      </TableBody>
    </Table>
  )
}

export default TableCustomers
