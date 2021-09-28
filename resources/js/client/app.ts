import React from 'react'
import { Route } from 'react-router-dom'
import Footer from './components/Footer/Footer'
import Navbar from './components/NavBar'
import MainRoutes from './routes'
import API from '@/common/utils/API'
import { UserInfo } from '@/typings'
import { login } from './redux/modules/user'
import { connect } from 'react-redux'
import { GlobalState, setGlobal } from './redux/modules/global'

const mapDispatchToProps = { login, setGlobal }

type AppProps = typeof mapDispatchToProps

class App extends React.Component<AppProps> {
  public componentDidMount(): void {
    API.get<{ user: UserInfo }>('/user')
      .then((response) => {
        if (response.data.user) {
          this.props.login(response.data.user)
        }
      })
      .catch((error) => console.error(error))

    API.get<GlobalState>('/')
      .then((response) => {
        this.props.setGlobal(response.data)
      })
      .catch((error) => console.error(error))
  }

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

export default connect(undefined, mapDispatchToProps)(App)