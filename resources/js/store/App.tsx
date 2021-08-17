import React from 'react'
import { Route } from 'react-router-dom'
import Footer from './components/Footer/Footer'
import Navbar from './components/NavBar'
import MainRoutes from './routes'

export default class App extends React.Component {
  public render(): JSX.Element {
    return (
      <>
        <Navbar />
        <div className="container">
          <Route component={MainRoutes} />
        </div>
        <Footer />
      </>
    )
  }
}
