import Card from '@/common/component/Card'
import Checkbox from '@/common/component/form/Checkbox'
import ErrorHandler from '@/common/component/form/ErrorHandler'
import Input from '@/common/component/form/Input'
import { RootState } from '@/store/redux'
import { login, UserState } from '@/store/redux/modules/user'
import { setCurrentRouteName } from '@/store/redux/modules/global'
import React, { Component } from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { connect } from 'react-redux'
import { Link, RouteComponentProps, withRouter } from 'react-router-dom'
import { CombinedState } from 'redux'
import API from '@/common/utils/API'
import { UserInfo } from '@/typings'

const mapStateToProps = (state: RootState): CombinedState<UserState> => state.user
const mapDispatchToProps = { login, setCurrentRouteName }
type RegisterProps = ReturnType<typeof mapStateToProps> &
  I18nextProviderProps &
  RouteComponentProps &
  typeof mapDispatchToProps

interface RegisterState {
  email: string
  password: string
  password_confirmation: string
  agreement: boolean
  errors?: {
    [key: string]: string[]
  }
}

class Register extends Component<RegisterProps, RegisterState> {
  public state: RegisterState = {
    email: '',
    password: '',
    password_confirmation: '',
    agreement: false,
  }

  public constructor(props: RegisterProps) {
    super(props)

    this.isFormValid = this.isFormValid.bind(this)
    this.submitRegister = this.submitRegister.bind(this)
  }

  public componentDidMount(): void {
    this.props.setCurrentRouteName(this.props.i18n.t('store:routes.login'))
  }

  private submitRegister(event: React.FormEvent): void {
    event.preventDefault()

    API.post<{ user: UserInfo }>('/user/register', {
      email: this.state.email,
      password: this.state.password,
      password_confirmation: this.state.password_confirmation,
      agreement: this.state.agreement,
    })
      .then((response) => {
        this.props.login(response.data.user)
        this.props.history.push('/')
      })
      .catch((error) => {
        this.setState({ errors: error.response.data })
      })
  }

  private isFormValid(): boolean {
    return (
      this.state.agreement &&
      this.state.email.length > 0 &&
      this.state.password.length > 0 &&
      this.state.password_confirmation.length > 0
    )
  }

  public render(): JSX.Element {
    const i18n = this.props.i18n
    return (
      <div id="register">
        <form className="container" onSubmit={this.submitRegister}>
          <Card>
            <Card.Header>
              <Card.Title>{i18n.t('store:pages.register.title')}</Card.Title>
            </Card.Header>
            <Card.Body>
              <Card.Text>
                <label htmlFor="email" className="label">
                  {i18n.t('store:pages.register.emailLabel')}
                </label>
                <ErrorHandler errors={this.state.errors?.email}>
                  <Input
                    id="email"
                    name="email"
                    type="email"
                    placeholder={i18n.t('store:pages.register.emailLabel')}
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

                <div className="agreements-container">
                  <Checkbox
                    id="agreement"
                    name="agreement"
                    label={i18n.t('store:pages.register.agreementLabel')}
                    checked={this.state.agreement}
                    onChange={(event) => this.setState({ agreement: event.target.checked })}
                  />
                </div>

                <p>
                  <Link to="/login">{i18n.t('store:pages.register.login')}</Link>
                </p>
              </Card.Text>
            </Card.Body>
            <Card.Footer aligment="center">
              <button type="submit" className="button" disabled={!this.isFormValid()}>
                {i18n.t('store:pages.register.register')}
              </button>
            </Card.Footer>
          </Card>
        </form>
      </div>
    )
  }
}

export default withTranslation('store')(
  connect(mapStateToProps, mapDispatchToProps)(withRouter(Register))
)
