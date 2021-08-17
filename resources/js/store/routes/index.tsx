import React from 'react'
import { connect } from 'react-redux'
import { Route, RouteComponentProps, Switch } from 'react-router-dom'
import { CombinedState } from 'redux'
import { RootState } from '../redux'
import { GlobalState } from '../redux/modules/global'

/*
 * Routes
 */
import Home from '../pages/home/Home'
import Contact from '../pages/contact/Contact'
import Login from '../pages/login/Login'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global

const mapDispatchToProps = {}

type AppRouterProps = ReturnType<typeof mapStateToProps> & typeof mapDispatchToProps

class AppRouter extends React.Component<AppRouterProps & RouteComponentProps> {
  public render(): JSX.Element {
    return (
      <Switch>
        <Route exact path="/" component={Home} />
        <Route exact path="/contact" component={Contact} />
        <Route exact path="/login" component={Login} />
        <Route path="*" component={undefined} />
      </Switch>
    )
  }
}

export default connect(mapStateToProps, mapDispatchToProps)(AppRouter)
