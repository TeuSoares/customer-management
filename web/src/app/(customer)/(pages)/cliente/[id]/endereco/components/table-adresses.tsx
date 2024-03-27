'use client'

import { useAppContext } from '@/hooks'

import { Button } from '@/components/ui/button'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

import CustomerAddressService from '../CustomerAddressService'

import { Trash2 } from 'lucide-react'

const TableAdresses = ({ customerId }: { customerId: number }) => {
  const { data, handleDelete } = CustomerAddressService(customerId)
  const { isLoading } = useAppContext()

  return (
    <Table className="w-ful text-center">
      {!isLoading && !data?.length && (
        <TableCaption className="text-white">
          Parece que esse cliente ainda não possui endereços cadastrados.
        </TableCaption>
      )}
      <TableHeader className="bg-[#BC2627]">
        <TableRow>
          <TableHead className="text-white text-center">Endereço</TableHead>
          <TableHead className="text-white text-center">Número</TableHead>
          <TableHead className="text-white text-center">Cidade</TableHead>
          <TableHead className="text-center text-white">Estado</TableHead>
          <TableHead className="text-center text-white">#</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody className="bg-[#111111] text-white">
        {data?.map((address) => (
          <TableRow key={address.id}>
            <TableCell>{address.address}</TableCell>
            <TableCell>{address.number}</TableCell>
            <TableCell>{address.city}</TableCell>
            <TableCell>{address.state}</TableCell>
            <TableCell>
              <Button
                variant="outline"
                className="bg-[#1E1E20] hover:bg-[#262627] hover:text-white border-none"
                size="icon"
                onClick={() => handleDelete(address.id)}
              >
                <Trash2 className="h-5 w-5" />
              </Button>
            </TableCell>
          </TableRow>
        ))}
      </TableBody>
    </Table>
  )
}

export default TableAdresses
