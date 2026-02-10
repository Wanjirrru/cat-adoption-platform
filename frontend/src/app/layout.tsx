// src/app/layout.tsx
import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import './globals.css'
import QueryProvider from '@/components/QueryProvider' // ← new

const inter = Inter({ subsets: ['latin'] })

export const metadata: Metadata = {
  title: 'CatAdopt – Cat Adoption Platform',
  description: 'Help cats find loving homes in Nairobi',
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en">
      <body className={inter.className}>
        <QueryProvider>{children}</QueryProvider>
      </body>
    </html>
  )
}