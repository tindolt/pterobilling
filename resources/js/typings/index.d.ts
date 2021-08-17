import 'react-i18next'
import _default from '../locales/default/en.json'
import store from '../locales/store/en.json'
import admin from '../locales/admin/en.json'
import client from '../locales/client/en.json'

declare module 'react-i18next' {
  // and extend them!
  interface CustomTypeOptions {
    // custom namespace type if you changed it
    defaultNS: 'default'
    // custom resources type
    resources: {
      default: typeof _default
      store: typeof store
      admin: typeof admin
      client: typeof client
    }
  }
}

declare global {
  interface Window {
    X_CSRF_TOKEN: string
  }
}

export interface UserInfo {
  id: number
  email: string
  email_verified_at: Date
  language: string
  is_admin: boolean
}
