/** @type {import('next').NextConfig} */
const nextConfig = {
  async rewrites() {
    return [
      {
        source: '/api/:path*',
        destination: 'http://127.0.0.1:8001/api/:path*', // Laravel port 8001
      },
      // Optional: also proxy Sanctum CSRF if needed later
      {
        source: '/sanctum/csrf-cookie',
        destination: 'http://127.0.0.1:8001/sanctum/csrf-cookie',
      },
    ]
  },

  // improve image handling if using next/image
  images: {
    remotePatterns: [
      {
        protocol: 'http',
        hostname: '127.0.0.1',
        port: '8001',
        pathname: '/storage/**',
      },
      {
        protocol: 'http',
        hostname: 'localhost',
        port: '8001',
        pathname: '/storage/**',
      },
    ],
  },
}

export default nextConfig