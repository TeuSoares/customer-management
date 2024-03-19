import { NextResponse } from 'next/server'
import type { NextRequest } from 'next/server'

export function middleware(request: NextRequest) {
  if (!request.cookies.has('token') && request.nextUrl.pathname == '/') {
    request.cookies.delete('token')
    return NextResponse.redirect(new URL('/login', request.url))
  }
  if (
    request.cookies.has('token') &&
    (request.nextUrl.pathname == '/login' ||
      request.nextUrl.pathname == '/register')
  ) {
    return NextResponse.redirect(new URL('/', request.url))
  }
}
