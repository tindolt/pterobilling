import '../common/bootstrap'

import React from 'react'
import ReactDOM from 'react-dom'

import App from './App'
import PageLoader from '@/common/component/PageLoader'

ReactDOM.render(
  <React.Fragment>
    <App />
    <PageLoader />
  </React.Fragment>,
  document.getElementById('app')
)
