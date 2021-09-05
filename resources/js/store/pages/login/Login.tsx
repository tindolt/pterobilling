import Card from '@/common/component/Card'
import Input from '@/common/component/form/Input'
import { RootState } from '@/store/redux'
import { login } from '@/store/redux/modules/user'
import { setCurrentRouteName } from '@/store/redux/modules/global'
import React from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { connect } from 'react-redux'
import { CombinedState } from 'redux'
import Checkbox from '@/common/component/form/Checkbox'
import { Link, RouteComponentProps, withRouter } from 'react-router-dom'
import API from '@/common/utils/API'
import ErrorHandler from '@/common/component/form/ErrorHandler'
import { AxiosError } from 'axios'
import { UserInfo } from '@/typings'

const mapStateToProps = (state: RootState): CombinedState<RootState> => state
const mapDispatchToProps = { login, setCurrentRouteName }
type LoginProps = ReturnType<typeof mapStateToProps> &
  I18nextProviderProps &
  RouteComponentProps &
  typeof mapDispatchToProps

interface LoginState {
  email: string
  password: string
  rememberMe: boolean
  errors?: {
    [key: string]: string[]
  }
}

class Login extends React.Component<LoginProps, LoginState> {
  public state: LoginState = {
    email: '',
    password: '',
    rememberMe: false,
  }

  public constructor(props: LoginProps) {
    super(props)
    this.loginSubmit = this.loginSubmit.bind(this)
  }

  public componentDidMount(): void {
    this.props.setCurrentRouteName(this.props.i18n.t('store:routes.login'))
  }

  private loginSubmit(event: React.FormEvent): void {
    event.preventDefault()

    API.post<{ user: UserInfo }>('/user/login', {
      email: this.state.email,
      password: this.state.password,
      rememberMe: this.state.rememberMe,
    })
      .then((response) => {
        this.props.login(response.data.user)
        this.props.history.push('/')
      })
      .catch((error: AxiosError) => {
        if (error.response) {
          const data = error.response.data

          if (data.errors) {
            this.setState({
              errors: data.errors,
            })
          }
        } else {
          console.error(error)
        }
      })
  }

  public render(): JSX.Element {
    const i18n = this.props.i18n
    return (
      <div id="login">
        <form className="container" onSubmit={this.loginSubmit}>
          <Card>
            <Card.Header>
              <Card.Title>{i18n.t('store:pages.login.title')}</Card.Title>
            </Card.Header>
            <Card.Body>
              <Card.Text>
                <label htmlFor="email" className="label">
                  {i18n.t('store:pages.login.emailLabel')}
                </label>
                <ErrorHandler errors={this.state.errors?.email}>
                  <Input
                    id="email"
                    name="email"
                    type="email"
                    placeholder={i18n.t('store:pages.login.emailLabel')}
                    icon="fas fa-at"
                    value={this.state.email}
                    onChange={(event) => this.setState({ email: event.target.value })}
                  />
                </ErrorHandler>

                <label htmlFor="password" className="label">
                  {i18n.t('store:pages.login.passwordLabel')}
                </label>
                <ErrorHandler errors={this.state.errors?.password}>
                  <Input
                    id="password"
                    name="password"
                    type="password"
                    placeholder={i18n.t('store:pages.login.passwordLabel')}
                    icon="fas fa-lock"
                    value={this.state.password}
                    onChange={(event) => this.setState({ password: event.target.value })}
                  />
                </ErrorHandler>

                <div className="remember-container">
                  <Checkbox
                    id="remember"
                    name="remember"
                    label={i18n.t('store:pages.login.rememberLabel')}
                    checked={this.state.rememberMe}
                    onChange={(event) => this.setState({ rememberMe: event.target.checked })}
                  />
                </div>

                <p>
                  <Link to="/register">{i18n.t('store:pages.login.register')}</Link>
                </p>
                <p>
                  <Link to="/forgot-password">{i18n.t('store:pages.login.forgot-password')}</Link>
                </p>
              </Card.Text>
            </Card.Body>
            <Card.Footer aligment="center">
              <button type="submit" className="button">
                {i18n.t('store:pages.login.login')}
              </button>
            </Card.Footer>
          </Card>
        </form>
      </div>
    )
  }
}

export default withTranslation('store')(
  connect(mapStateToProps, mapDispatchToProps)(withRouter(Login))
)
