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
import Affiliate from '../pages/affiliate/Affliate'
import Credit from '../pages/credit/Credit'
import Server from '../pages/servers/Server'
import Settings from '../pages/settings/Settings'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global

const mapDispatchToProps = {}

type AppRouterProps = ReturnType<typeof mapStateToProps> & typeof mapDispatchToProps

class AppRouter extends React.Component<AppRouterProps & RouteComponentProps> {
  public render(): JSX.Element {
    return (
      <Switch>
        <Route exact path="/" component={Home} />
        <Route exact path="/affiliate" component={Affiliate} />
        <Route exact path="/credit" component={Credit} />
        <Route exact path="/servers" component={Server} />
        <Route exact path="/settings" component={Settings} />
        <Route path="*" component={undefined} />
      </Switch>
    )
  }
}

export default connect(mapStateToProps, mapDispatchToProps)(AppRouter)
