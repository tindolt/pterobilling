import '../common/bootstrap'

import React, { Suspense } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route } from 'react-router-dom'

import App from './App'

import PageLoader from '@/common/component/PageLoader'
import { Provider } from 'react-redux'
import store from './redux'
import './i18n'

ReactDOM.render(
  <Provider client={client}>
    <Suspense fallback="Loading">
      <BrowserRouter>
        <Route component={App} />
      </BrowserRouter>
    </Suspense>
    <PageLoader needToLoad={true} />
  </Provider>,
  document.getElementById('app')
)