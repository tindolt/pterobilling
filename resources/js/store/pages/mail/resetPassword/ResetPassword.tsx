import React from 'react'
import { setCurrentRouteName } from '@/store/redux/modules/global'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { RouteComponentProps, withRouter } from 'react-router'
import Card from '@/common/component/Card'
import API from '@/common/utils/API'
import { connect } from 'react-redux'
import { AxiosError } from 'axios'
import ErrorHandler from '@/common/component/form/ErrorHandler'
import Input from '@/common/component/form/Input'

const mapDispatchToProps = { setCurrentRouteName }
type ResetPasswordProps = typeof mapDispatchToProps & I18nextProviderProps & RouteComponentProps

interface ResetState {
  token: string
  email: string
  password: string
  password_confirmation: string
  errors?: {
    [key: string]: string[]
  }
}

class ResetPassword extends React.Component<ResetPasswordProps, ResetState> {
  public state: ResetState = {
    token: '',
    email: '',
    password: '',
    password_confirmation: '',
  }

  public constructor(props: ResetPasswordProps) {
    super(props)
    this.resetSubmit = this.resetSubmit.bind(this)
  }

  public componentDidMount(): void {
    const params = new URLSearchParams(this.props.location.search)
    if (params.get('token')?.length === 0 || params.get('email')?.length === 0) {
      this.props.history.push('/')
      return
    }

    this.setState({
      token: params.get('token') || '',
      email: params.get('email') || '',
    })

    this.props.setCurrentRouteName(this.props.i18n.t('store:routes.reset-password'))
  }

  private resetSubmit(event: React.FormEvent): void {
    event.preventDefault()

    API.post('/user/reset-password', this.state)
      .then(() => {
        this.props.history.push('/login')
      })
      .catch((error: AxiosError) => {
        if (error.response) {
          const data = error.response.data

          if (data.errors) {
            this.setState({
              errors: data.errors,
            })
          } else {
            console.error(error)
          }
        }
      })
  }

  public render(): JSX.Element {
    const i18n = this.props.i18n

    return (
      <div id="reset">
        <form onSubmit={this.resetSubmit} className="container">
          <Card>
            <Card.Header>
              <Card.Title>{i18n.t('store:pages.reset.title')}</Card.Title>
            </Card.Header>
            <Card.Body>
              <Card.Text>
                <label htmlFor="email" className="label">
                  {i18n.t('store:pages.reset.emailLabel')}
                </label>
                <ErrorHandler errors={this.state.errors?.email}>
                  <Input
                    id="email"
                    name="email"
                    type="email"
                    placeholder={i18n.t('store:pages.reset.emailLabel')}
                    icon="fas fa-at"
                    value={this.state.email}
                    onChange={(event) => this.setState({ email: event.target.value })}
                  />
                </ErrorHandler>

                <label htmlFor="password" className="label">
                  {i18n.t('store:pages.register.passwordLabel')}
                </label>
                <ErrorHandler errors={this.state.errors?.password}>
                  <Input
                    id="password"
                    name="password"
                    type="password"
                    placeholder={i18n.t('store:pages.register.passwordLabel')}
                    icon="fas fa-lock"
                    value={this.state.password}
                    onChange={(event) => this.setState({ password: event.target.value })}
                  />
                </ErrorHandler>

                <label htmlFor="password_confirmation" className="label">
                  {i18n.t('store:pages.register.confirmPasswordLabel')}
                </label>
                <ErrorHandler errors={this.state.errors?.password_confirmation}>
                  <Input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder={i18n.t('store:pages.register.confirmPasswordLabel')}
                    icon="fas fa-lock"
                    value={this.state.password_confirmation}
                    onChange={(event) =>
                      this.setState({ password_confirmation: event.target.value })
                    }
                  />
                </ErrorHandler>
              </Card.Text>
            </Card.Body>
            <Card.Footer aligment="center">
              <button type="submit" className="button">
                {i18n.t('store:pages.reset.reset')}
              </button>
            </Card.Footer>
          </Card>
        </form>
      </div>
    )
  }
}

export default withTranslation('store')(
  connect(undefined, mapDispatchToProps)(withRouter(ResetPassword))
)
