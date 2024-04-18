'use client'

import { QueryClient, QueryClientProvider } from 'react-query'

import Header from '@/components/header'
import Container from '@/components/layout/container'
import Loading from '@/components/layout/loading'
import { Toaster } from '@/components/ui/toaster'

const queryClient = new QueryClient()

export default function RootLayoutCustomer({
  children,
}: Readonly<{
  children: React.ReactNode
}>) {
  return (
    <>
      <Toaster />
      <Loading />
      <QueryClientProvider client={queryClient}>
        <Header />
        <main className="flex flex-col h-full">
          <Container>{children}</Container>
        </main>
      </QueryClientProvider>
    </>
  )
}
