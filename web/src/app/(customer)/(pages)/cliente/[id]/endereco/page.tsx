import TableAdresses from './components/table-adresses'
import LinkButton from '@/components/layout/link-button'

export default function Adresses({ params }: { params: { id: number } }) {
  return (
    <>
      <div className="flex justify-between items-center mb-4">
        <h1 className="text-white font-bold mb-3">
          Endereços cadastrados do cliente # {params.id}
        </h1>
        <LinkButton
          className="bg-[#BC2627] hover:bg-[#9e3535] hover:text-white"
          href={`/cliente/${params.id}/endereco/adicionar`}
          label="Adicionar"
        />
      </div>
      <TableAdresses customerId={params.id} />
    </>
  )
}
