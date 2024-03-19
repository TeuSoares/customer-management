'use client'

import { useLogout } from '@/hooks'

import { Button } from '@/components/ui/button'

import LinkButton from './layout/link-button'

const Header = () => {
  const { handleLogout } = useLogout()

  return (
    <header className="p-4 text-center bg-[#111111]">
      <LinkButton label="Dashboard" href="/" />
      <Button
        className="bg-transparent hover:bg-transparent text-white font-bold hover:text-[#BC2627]"
        onClick={handleLogout}
      >
        Logout
      </Button>
    </header>
  )
}

export default Header
