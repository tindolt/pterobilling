import Card from '@/common/component/Card'
import Input from '@/common/component/form/Input'
import React from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { RouteComponentProps, withRouter } from 'react-router-dom'
import API from '@/common/utils/API'
import { setCurrentRouteName } from '@/store/redux/modules/global'
import { AxiosError } from 'axios'
import ErrorHandler from '@/common/component/form/ErrorHandler'

const mapDispatchToProps = { setCurrentRouteName }
type ForgotPasswordProps = I18nextProviderProps & RouteComponentProps & typeof mapDispatchToProps

interface AxiosInvalidEmailError {
  message: string
  errors: {
    [key: string]: string[]
  }
}

/**
 * Interface of Forgot Password
 */
interface ForgotPasswordState {
  email: string
  error?: string
}

/**
 * Class with ForgotPassState and ForgotPassProps
 */
class ForgotPassword extends React.Component<ForgotPasswordProps, ForgotPasswordState> {
  public state: ForgotPasswordState = {
    email: '',
  }

  /**
   * Constructor
   */
  public constructor(props: ForgotPasswordProps) {
    super(props)
    this.forgotPasswordSubmit = this.forgotPasswordSubmit.bind(this)
  }

  public componentDisMount(): void {
    this.props.setCurrentRouteName(this.props.i18n.t('store:routes.forgotpassword'))
  }

  private forgotPasswordSubmit(e: React.FormEvent): void {
    e.preventDefault()

    API.post('/user/forgot-password', {
      email: this.state.email,
    })
      .then(() => {
        this.setState({ error: undefined })
      })
      .catch((err: AxiosError<AxiosInvalidEmailError>) => {
        if (err.response?.status === 400) {
          this.setState({
            error: this.props.i18n.t('store:pages.forgot-password.messages.invalidEmail'),
          })
        }
      })
  }
  public render(): JSX.Element {
    const i18n = this.props.i18n
    return (
      <div id="forgot-password">
        <form className="container" onSubmit={this.forgotPasswordSubmit}>
          <Card>
            <Card.Header>
              <Card.Title>{i18n.t('store:pages.forgot-password.title')}</Card.Title>
            </Card.Header>
            <Card.Body>
              <Card.Text>
                <label htmlFor="email" className="label">
                  {i18n.t('store:pages.forgot-password.emailLabel')}
                </label>
                <ErrorHandler errors={this.state.error ? [this.state.error] : []}>
                  <Input
                    id="email"
                    name="email"
                    type="text"
                    placeholder={i18n.t('store:pages.forgot-password.emailLabel')}
                    icon={'fas fa-at'}
                    value={this.state.email}
                    onChange={(e) => this.setState({ email: e.target.value })}
                  />
                </ErrorHandler>
              </Card.Text>
            </Card.Body>
            <Card.Footer aligment="center">
              <button type="submit" className="button">
                {i18n.t('store:pages.forgot-password.forgotpassword')}
              </button>
            </Card.Footer>
          </Card>
        </form>
      </div>
    )
  }
}
export default withTranslation('store')(withRouter(ForgotPassword))
