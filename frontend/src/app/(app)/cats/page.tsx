'use client'

import { useQuery } from '@tanstack/react-query'
import { useState } from 'react'
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Input } from '@/components/ui/input'
import { 
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { PawPrint, Loader2, AlertCircle, Search } from 'lucide-react'
import Image from 'next/image'
import Link from 'next/link'
import { cn } from '@/lib/utils'
import api from '@/lib/api'

interface Cat {
  id: number
  name: string
  breed: string
  age: number
  gender: 'Male' | 'Female'
  image?: string
  status: 'available' | 'pending' | 'adopted'
  description?: string
}

async function fetchCats(): Promise<Cat[]> {
  const response = await api.get<Cat[]>('/cats')
  return response.data
}

export default function CatsPage() {
  const [searchTerm, setSearchTerm] = useState('')
  const [genderFilter, setGenderFilter] = useState('all')
  const [statusFilter, setStatusFilter] = useState('all')

  const {
    data: allCats = [],
    isLoading,
    error,
  } = useQuery<Cat[], Error>({
    queryKey: ['cats'],
    queryFn: fetchCats,
  })

  // Client-side filtering
  const filteredCats = allCats.filter(cat => {
    const matchesSearch =
      searchTerm === '' ||
      cat.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      cat.breed.toLowerCase().includes(searchTerm.toLowerCase())

    const matchesGender = genderFilter === 'all' || cat.gender === genderFilter
    const matchesStatus = statusFilter === 'all' || cat.status === statusFilter

    return matchesSearch && matchesGender && matchesStatus
  })

  if (isLoading) {
    return (
      <div className="flex flex-col items-center justify-center min-h-[60vh] gap-4">
        <Loader2 className="h-12 w-12 animate-spin text-indigo-600" />
        <p className="text-lg text-gray-600">Finding adorable cats for you...</p>
      </div>
    )
  }

  if (error) {
    return (
      <div className="flex flex-col items-center justify-center min-h-[60vh] gap-4 text-center">
        <AlertCircle className="h-12 w-12 text-red-500" />
        <h2 className="text-2xl font-semibold text-red-600">Something went wrong</h2>
        <p className="text-gray-600 max-w-md">{error.message}</p>
        <Button variant="outline" onClick={() => window.location.reload()}>
          Try Again
        </Button>
      </div>
    )
  }

  return (
    <div className="space-y-10">
      {/* Header + Filters */}
      <div className="space-y-6">
        <div className="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
          <div>
            <h1 className="text-3xl md:text-4xl font-bold text-gray-900">Available Cats</h1>
            <p className="text-lg text-gray-600 mt-2">
              {filteredCats.length} loving companions waiting for their forever home 🐾
            </p>
          </div>

          <div className="flex flex-col sm:flex-row gap-4">
            {/* Search */}
            <div className="relative w-full sm:w-64">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
              <Input
                placeholder="Search by name or breed..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="pl-10"
              />
            </div>

            {/* Gender filter */}
            <Select value={genderFilter} onValueChange={setGenderFilter}>
              <SelectTrigger className="w-full sm:w-40">
                <SelectValue placeholder="Gender" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Genders</SelectItem>
                <SelectItem value="Male">Male</SelectItem>
                <SelectItem value="Female">Female</SelectItem>
              </SelectContent>
            </Select>

            {/* Status filter */}
            <Select value={statusFilter} onValueChange={setStatusFilter}>
              <SelectTrigger className="w-full sm:w-40">
                <SelectValue placeholder="Status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Status</SelectItem>
                <SelectItem value="available">Available</SelectItem>
                <SelectItem value="pending">Pending</SelectItem>
                <SelectItem value="adopted">Adopted</SelectItem>
              </SelectContent>
            </Select>
          </div>
        </div>
      </div>

      {/* Results */}
      {filteredCats.length === 0 ? (
        <div className="text-center py-20 bg-gray-50 rounded-xl border border-gray-200">
          <PawPrint className="h-16 w-16 mx-auto text-gray-400 mb-4" />
          <h2 className="text-2xl font-semibold text-gray-700 mb-2">No matching cats found</h2>
          <p className="text-gray-600 mb-6">Try adjusting your filters or search term</p>
          <Button variant="outline" onClick={() => {
            setSearchTerm('')
            setGenderFilter('all')
            setStatusFilter('all')
          }}>
            Reset Filters
          </Button>
        </div>
      ) : (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
          {filteredCats.map((cat) => (
            <Card
              key={cat.id}
              className={cn(
                'overflow-hidden border border-gray-200 hover:border-indigo-300 transition-all duration-300 hover:shadow-xl group',
                cat.status === 'adopted' && 'opacity-75'
              )}
            >
              <div className="relative aspect-[4/3] bg-gray-100 overflow-hidden">
                {cat.image ? (
                  <Image
                    src={cat.image.startsWith('http') ? cat.image : `/storage/${cat.image}`}
                    alt={cat.name}
                    fill
                    className="object-cover group-hover:scale-105 transition-transform duration-500"
                    sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                  />
                ) : (
                  <div className="absolute inset-0 flex items-center justify-center bg-gray-200">
                    <PawPrint className="h-20 w-20 text-gray-300" />
                  </div>
                )}

                <div className="absolute top-3 right-3">
                  <Badge
                    variant={
                      cat.status === 'available'
                        ? 'default'
                        : cat.status === 'pending'
                        ? 'secondary'
                        : 'destructive'
                    }
                    className="text-xs font-medium px-3 py-1"
                  >
                    {cat.status.charAt(0).toUpperCase() + cat.status.slice(1)}
                  </Badge>
                </div>
              </div>

              <CardHeader className="pb-2">
                <CardTitle className="text-xl font-semibold line-clamp-1">{cat.name}</CardTitle>
                <p className="text-sm text-gray-600">{cat.breed}</p>
              </CardHeader>

              <CardContent className="pb-3 space-y-2 text-sm text-gray-700">
                <div className="flex justify-between">
                  <span>Age:</span>
                  <span className="font-medium">{cat.age} {cat.age === 1 ? 'year' : 'years'}</span>
                </div>
                <div className="flex justify-between">
                  <span>Gender:</span>
                  <span className="font-medium">{cat.gender}</span>
                </div>
              </CardContent>

              <CardFooter className="pt-1">
                {cat.status === 'available' ? (
                  <Button asChild className="w-full">
                    <Link href={`/cats/${cat.id}`}>
                      View Details & Adopt
                    </Link>
                  </Button>
                ) : (
                  <Button variant="secondary" disabled className="w-full">
                    {cat.status === 'pending' ? 'Adoption Pending' : 'Already Adopted'}
                  </Button>
                )}
              </CardFooter>
            </Card>
          ))}
        </div>
      )}
    </div>
  )
}