// src/app/(marketing)/layout.tsx
import type { ReactNode } from 'react'
import Link from 'next/link'
import { PawPrint } from 'lucide-react'

export default function MarketingLayout({ children }: { children: ReactNode }) {
  return (
    <div className="min-h-screen bg-gradient-to-b from-indigo-50 to-white">
      {/* Simple marketing header */}
      <header className="py-6 px-8 bg-white/80 backdrop-blur-sm border-b">
        <div className="max-w-7xl mx-auto flex justify-between items-center">
          <Link href="/" className="flex items-center gap-2.5 transition-transform hover:scale-105">
            <PawPrint className="h-9 w-9 text-indigo-600 dark:text-indigo-400 transition-colors hover:text-indigo-800" strokeWidth={2} fill="currentColor" />
            <span className="text-2xl md:text-3xl font-bold text-indigo-700 hidden sm:inline">
             CatAdopt
            </span>
          </Link>
          <nav className="space-x-6">
            <a href="/cats" className="hover:text-indigo-600">Cats</a>
            <a href="/auth/login" className="hover:text-indigo-600">Login</a>
          </nav>
        </div>
      </header>

      <main>{children}</main>

      {/* Simple footer */}
      <footer className="py-8 bg-indigo-900 text-white text-center">
        <p>© {new Date().getFullYear()} CatAdopt – Made with ❤️ in Nairobi</p>
      </footer>
    </div>
  )
}