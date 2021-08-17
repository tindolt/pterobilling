import Axios, { AxiosInstance } from 'axios'

const instance: AxiosInstance = Axios.create({
  timeout: 200000,
  baseURL: '/api',
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-Token': (window.X_CSRF_TOKEN as string) || '',
  },
})

export default instance
