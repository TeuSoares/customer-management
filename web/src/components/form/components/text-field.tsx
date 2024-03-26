import { ChangeEvent, ReactNode } from 'react'
import { useFormContext } from 'react-hook-form'

import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'

interface TextFieldProps {
  name: string
  label?: string
  type?: string
  placeholder?: string
  description?: string | ReactNode
  disabled?: boolean
  className?: string
  onChange?: (event: ChangeEvent<HTMLInputElement>) => void
}

const TextField = ({
  name,
  label,
  placeholder,
  description,
  className,
  onChange,
  type = 'text',
  disabled = false,
}: TextFieldProps) => {
  const { control } = useFormContext()

  return (
    <FormField
      control={control}
      name={name}
      disabled={disabled}
      render={({ field }) => (
        <FormItem className={className}>
          {label && <FormLabel>{label}</FormLabel>}
          <FormControl>
            <Input
              type={type}
              placeholder={placeholder}
              onChangeCapture={onChange}
              {...field}
            />
          </FormControl>
          {description && <FormDescription>{description}</FormDescription>}
          <FormMessage />
        </FormItem>
      )}
    />
  )
}

export default TextField
