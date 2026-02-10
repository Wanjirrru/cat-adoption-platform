'use client';

import { useQuery } from '@tanstack/react-query';
import api from '@/lib/api';

interface Cat {
  id: number;
  name: string;
  breed: string;
  age: number;
  image?: string;
  description?: string;
  // add more fields from your original Cat model
}

const fetchCats = async (): Promise<Cat[]> => {
  const res = await api.get('/cats');
  return res.data;
};

export default function CatsPage() {
  const { data: cats = [], isLoading, error } = useQuery<Cat[]>({
    queryKey: ['cats'],
    queryFn: fetchCats,
  });

  if (isLoading) return <div className="p-12 text-center text-2xl">Loading adorable cats...</div>;
  if (error) return <div className="p-12 text-center text-red-600">Error: {(error as Error).message}</div>;

  return (
    <div className="p-8 max-w-7xl mx-auto">
      <h1 className="text-4xl font-bold mb-10 text-center text-indigo-800">Cats Looking for Homes</h1>
      
      {cats.length === 0 ? (
        <p className="text-center text-xl text-gray-600">No cats available right now. Check back soon! 🐱</p>
      ) : (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          {cats.map((cat) => (
            <div key={cat.id} className="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">
              {cat.image ? (
                <img 
                  src={cat.image.startsWith('http') ? cat.image : `/storage/${cat.image}`} 
                  alt={cat.name} 
                  className="w-full h-64 object-cover"
                />
              ) : (
                <div className="w-full h-64 bg-gray-200 flex items-center justify-center">
                  <span className="text-gray-500">No image</span>
                </div>
              )}
              <div className="p-6">
                <h2 className="text-2xl font-semibold mb-2">{cat.name}</h2>
                <p className="text-gray-700 mb-1"><strong>Breed:</strong> {cat.breed}</p>
                <p className="text-gray-700 mb-4"><strong>Age:</strong> {cat.age} years</p>
                <button className="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 w-full font-medium">
                  Adopt Me
                </button>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}