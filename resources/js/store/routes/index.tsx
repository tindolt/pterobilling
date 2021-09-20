import React from 'react'
import { connect } from 'react-redux'
import { Route, RouteComponentProps, Switch } from 'react-router-dom'
import { CombinedState } from 'redux'
import { RootState } from '../redux'
import { GlobalState } from '../redux/modules/global'
import { withPlugins, WithPluginsProps } from 'react-pluggable'
import { PluginCustomRoute } from '@/typings'

/*
 * Routes
 */
import Home from '../pages/home/Home'
import Contact from '../pages/contact/Contact'
import Login from '../pages/login/Login'
import Register from '../pages/register/Register'
import ForgotPassword from '../pages/forgotPassword/ForgotPassword'
import ResetPassword from '../pages/mail/resetPassword/ResetPassword'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global

const mapDispatchToProps = {}

type AppRouterProps = ReturnType<typeof mapStateToProps> &
  typeof mapDispatchToProps &
  WithPluginsProps

class AppRouter extends React.Component<AppRouterProps & RouteComponentProps> {
  private customRoutes: PluginCustomRoute[] = []

  public componentDidMount(): void {
    this.customRoutes = this.props.pluginStore.executeFunction('plugins:custom-routes')
  }

  public render(): JSX.Element {
    return (
      <Switch>
        <Route exact path="/" component={Home} />
        <Route exact path="/contact" component={Contact} />
        <Route exact path="/login" component={Login} />
        <Route exact path="/register" component={Register} />
        <Route exact path="/forgot-password" component={ForgotPassword} />
        <Route exact path="/mail/reset-password" component={ResetPassword} />
        {this.customRoutes.map((route: PluginCustomRoute, index) => {
          const component = route.component()

          return <Route exact={route.exact} path={route.path} component={component} key={index} />
        })}
        {/*this.customRoutes.map((route: PluginCustomRoute, index) => {
          console.log(Login)
          console.log(route)
          return (
            <Route
              exact={route.exact}
              path={route.path}
              component={route.component()}
              key={index}
            />
          )
        })*/}
        <Route path="*" component={undefined} />
      </Switch>
    )
  }
}

export default connect(mapStateToProps, mapDispatchToProps)(withPlugins(AppRouter))
