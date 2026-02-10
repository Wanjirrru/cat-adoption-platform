import Link from 'next/link';

export default function Home() {
  return (
    <main className="flex min-h-screen flex-col items-center justify-center p-8 bg-gradient-to-b from-blue-50 to-white">
      <h1 className="text-5xl font-bold mb-6 text-indigo-700">Cat Adoption Platform</h1>
      <p className="text-xl mb-8 text-gray-700 max-w-2xl text-center">
        A modern full-stack app to help cats find loving homes. Built with Laravel API + Next.js.
      </p>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-4xl">
        <Link href="/cats" className="bg-indigo-600 text-white py-6 px-8 rounded-xl shadow-lg hover:bg-indigo-700 transition text-center text-xl font-medium">
          View Available Cats
        </Link>
        <Link href="/auth/login" className="bg-green-600 text-white py-6 px-8 rounded-xl shadow-lg hover:bg-green-700 transition text-center text-xl font-medium">
          Login / Register
        </Link>
      </div>

      <p className="mt-12 text-gray-500">
        Dockerized & DevOps-ready • Running on localhost:3000
      </p>
    </main>
  );
}