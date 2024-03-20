import { ReactNode } from 'react'

const Container = ({ children }: { children: ReactNode }) => {
  return <div className="max-w-screen-xl ml-auto mr-auto">{children}</div>
}

export default Container
