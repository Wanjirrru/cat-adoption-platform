// src/app/(app)/layout.tsx
import type { ReactNode } from 'react'
import Link from 'next/link'
import { PawPrint } from 'lucide-react'

export default function AppLayout({ children }: { children: ReactNode }) {
  return (
    <div className="min-h-screen bg-gray-50">
      {/* Dashboard-style header / sidebar placeholder */}
      <header className="bg-white shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
          <Link href="/" className="flex items-center gap-2.5 transition-transform hover:scale-105">
            <PawPrint className="h-9 w-9 text-indigo-600 dark:text-indigo-400 transition-colors hover:text-indigo-800" strokeWidth={2} fill="currentColor" />
            <span className="text-2xl md:text-3xl font-bold text-indigo-700 hidden sm:inline">
             CatAdopt
            </span>
          </Link>
          <div className="space-x-4">
            <span className="text-gray-600">Welcome, User</span>
            <button className="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
              Logout
            </button>
          </div>
        </div>
      </header>

      <div className="flex">
        {/* Sidebar placeholder */}
        <aside className="w-64 bg-white shadow-sm min-h-[calc(100vh-4rem)] p-6 hidden md:block">
          <nav className="space-y-4">
            <a href="/dashboard" className="block py-2 px-4 hover:bg-indigo-50 rounded">
              Dashboard
            </a>
            <a href="/cats" className="block py-2 px-4 hover:bg-indigo-50 rounded">
              All Cats
            </a>
            <a href="/profile" className="block py-2 px-4 hover:bg-indigo-50 rounded">
              My Profile
            </a>
          </nav>
        </aside>

        <main className="flex-1 p-6 md:p-8">{children}</main>
      </div>
    </div>
  )
}