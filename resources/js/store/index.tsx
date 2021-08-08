import '../common/bootstrap'

import React, { Suspense } from 'react'
import ReactDOM from 'react-dom'

import { BrowserRouter as Router } from 'react-router-dom'

import App from './App'
import PageLoader from '@/common/component/PageLoader'
import { Provider } from 'react-redux'
import store from './redux'
import './i18n'

ReactDOM.render(
  <React.Fragment>
    <Provider store={store}>
      <Suspense fallback="Loading">
        <Router>
          <App />
        </Router>
      </Suspense>
      <PageLoader needToLoad={true} />
    </Provider>
  </React.Fragment>,
  document.getElementById('app')
)
