import { IPlugin } from 'react-pluggable'
import React from 'react'

declare global {
  interface Window {
    X_CSRF_TOKEN: string
    __REDUX_DEVTOOLS_EXTENSION_COMPOSE__?: typeof compose
    plugins: IPlugin[]
  }
}

export interface UserInfo {
  id: number
  email: string
  email_verified_at: Date
  language: string
  is_admin: boolean
}

export interface PluginCustomRoute {
  path: string
  exact: boolean
  component: () => React.ComponentType
}
