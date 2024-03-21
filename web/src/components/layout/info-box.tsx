interface Props {
  title: string
  description: string
  bgColor?: string
}

const InfoBox = ({ description, title, bgColor = '#1E1E20' }: Props) => {
  return (
    <div
      className={`bg-[${bgColor}] flex text-white items-center space-x-4 rounded-md border p-4`}
    >
      <div className="flex-1 space-y-1">
        <p className="text-sm font-medium leading-none">{title}</p>
        <p className="text-sm text-white-foreground">{description}</p>
      </div>
    </div>
  )
}

export default InfoBox
