import { useAppContext } from '@/hooks'

import FormButton from '../form/components/form-button'
import {
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

import Form, { FormProps } from '../form/form'

interface CardFormProps extends FormProps {
  title: string
  textButton: string
  description?: string
}

const CardForm = ({
  title,
  textButton,
  description,
  defaultValues,
  children,
  formSchema,
  onSubmit,
}: CardFormProps) => {
  const { isLoading } = useAppContext()

  return (
    <>
      <CardHeader>
        <CardTitle>{title}</CardTitle>
        {description && <CardDescription>{description}</CardDescription>}
      </CardHeader>
      <CardContent>
        <Form
          formSchema={formSchema}
          onSubmit={onSubmit}
          className="flex-col"
          defaultValues={defaultValues}
        >
          {children}
          <FormButton disabled={isLoading}>{textButton}</FormButton>
        </Form>
      </CardContent>
    </>
  )
}

export default CardForm
