// src/app/(marketing)/page.tsx
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { cn } from "@/lib/utils"
import Link from "next/link"
import { PawPrint, Heart, Users } from "lucide-react"

export default function Home() {
  return (
    <div className="flex flex-col min-h-screen">
      {/* Hero Section */}
      <section className="relative py-20 md:py-32 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 overflow-hidden">
        <div className="absolute inset-0 opacity-10 pointer-events-none">
          <div className="absolute inset-0 bg-[radial-gradient(circle_at_20%_30%,_#c084fc_0%,_transparent_50%)]" />
          <div className="absolute inset-0 bg-[radial-gradient(circle_at_80%_70%,_#a5b4fc_0%,_transparent_50%)]" />
        </div>

        <div className="container relative z-10 px-4 md:px-6 text-center">
          <h1 className="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
            Find Your Forever Friend
          </h1>

          <p className="text-xl md:text-2xl text-gray-700 max-w-3xl mx-auto mb-10 leading-relaxed">
            Join hundreds of happy adopters in Nairobi who have given loving homes to rescued cats and kittens.
            Start browsing today — your perfect companion is waiting.
          </p>

          <div className="flex flex-col sm:flex-row gap-5 justify-center items-center">
            <Button asChild size="lg" className="text-lg px-10 py-7 rounded-xl shadow-lg hover:shadow-xl transition-all">
              <Link href="/cats">
                <PawPrint className="mr-2 h-6 w-6" />
                Browse Available Cats
              </Link>
            </Button>

            <Button asChild variant="outline" size="lg" className="text-lg px-10 py-7 rounded-xl border-2">
              <Link href="/auth/register">
                Create Free Account
              </Link>
            </Button>
          </div>
        </div>
      </section>

      {/* Features / Stats Section */}
      <section className="py-20 bg-white">
        <div className="container px-4 md:px-6">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Why Families Choose CatAdopt</h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              We're more than an adoption platform — we're a community dedicated to responsible pet ownership.
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <Card className="border-none shadow-lg hover:shadow-xl transition-all">
              <CardHeader className="text-center pb-2">
                <div className="mx-auto bg-indigo-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                  <Heart className="h-8 w-8 text-indigo-600" />
                </div>
                <CardTitle className="text-2xl">Health & Care</CardTitle>
              </CardHeader>
              <CardContent className="text-center">
                <CardDescription className="text-base">
                  All cats are vaccinated, dewormed, and spayed/neutered before adoption.
                </CardDescription>
              </CardContent>
            </Card>

            <Card className="border-none shadow-lg hover:shadow-xl transition-all">
              <CardHeader className="text-center pb-2">
                <div className="mx-auto bg-purple-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                  <Users className="h-8 w-8 text-purple-600" />
                </div>
                <CardTitle className="text-2xl">Community Support</CardTitle>
              </CardHeader>
              <CardContent className="text-center">
                <CardDescription className="text-base">
                  Join our adopter community for advice, events, and lifelong support.
                </CardDescription>
              </CardContent>
            </Card>

            <Card className="border-none shadow-lg hover:shadow-xl transition-all">
              <CardHeader className="text-center pb-2">
                <div className="mx-auto bg-pink-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                  <PawPrint className="h-8 w-8 text-pink-600" />
                </div>
                <CardTitle className="text-2xl">Matching Process</CardTitle>
              </CardHeader>
              <CardContent className="text-center">
                <CardDescription className="text-base">
                  Personalized matching to find the perfect cat for your lifestyle and home.
                </CardDescription>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      {/* Final CTA */}
      <section className="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div className="container px-4 md:px-6 text-center">
          <h2 className="text-4xl md:text-5xl font-bold mb-6">
            Ready to Change a Life?
          </h2>
          <p className="text-xl md:text-2xl mb-10 max-w-3xl mx-auto opacity-90">
            Browse our cats today and start the adoption journey that will bring joy to your home.
          </p>
          <Button asChild size="lg" variant="secondary" className="text-lg px-10 py-7">
            <Link href="/cats">
              See Available Cats Now →
            </Link>
          </Button>
        </div>
      </section>
    </div>
  )
}