import axios from 'axios'

const isServer = typeof window === 'undefined'
const useStateful = process.env.NEXT_PUBLIC_STATEFUL_AUTH === 'true'

const api = axios.create({
  // Always use relative path → goes through Next.js proxy
  baseURL: '/api',

  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',           // ← important: forces JSON responses
  },

  // Keep this true if using Sanctum cookies in the future
  // For pure token auth you can set it to false
  withCredentials: useStateful, // only true if cookie mode
})

// Token interceptor (only used in Bearer mode)
if (!useStateful) {
  api.interceptors.request.use((config) => {
    if (!isServer) {
      const token = localStorage.getItem('token')
      if (token) {
        config.headers = config.headers ?? {}
        config.headers.Authorization = `Bearer ${token}`
      }
    }
    return config
  })
}

// 401 handler (logout)
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401 && !isServer) {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

export default api