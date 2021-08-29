import Card from '@/common/component/Card'
import Input from '@/common/component/form/Input'
import React from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { Link, RouteComponentProps, withRouter } from 'react-router-dom'
import API from '@/common/utils/API'
import { UserInfo } from '@/typings'
import { connect } from 'tls'

type ForgotPasswordProps = I18nextProviderProps &
  RouteComponentProps 

/**
 * Interface of Forgot Password
 */
interface ForgotPasswordState {
  email: string
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
    super(props);
    this.forgotPasswordSubmit = this.forgotPasswordSubmit.bind(this)
  }

  public componentDisMount(): void {
    this.props.setCurrentRouteName(this.props.i18n.t('store:routes.forgotpassword'))
  }

  private forgotPasswordSubmit(e: React.FromEvent): void {
    e.preventDefault()

    API.post<{ user: UserInfo }>('user/forgotpassword', {
      email: this.state.email
    })

      .then((response) => {
        // TODO Email Action
        this.props.history.push('/user/login')
      })
  }

  public render(): JSX.Element {
    const i18n = this.props.i18n
    return (
      <div id="forgotpassword">
        <from className="container" onSubmit={this.forgotPasswordSubmit}>
          <Card>
            <Card.Header>
              <Card.Title>{i18n.t('store:pages.forgot-password.title')}</Card.Title>
            </Card.Header>
            <Card.Body>
              <Card.Text>
                <label htmlFor="email" className="label">
                  {i18n.t('store:pages.forgot-password.emailLabel')}
                </label>
                <Input id="email" name="email" type="text" placeholder={i18n.t('store:pages.forgot-password.emailLabel')} icon={"fas fa-at"} value={this.state.email} onChange={(e) => this.setState({ email: e.tar})}/>
              </Card.Text>
            </Card.Body>
          </Card>
        </from>
      </div>
    )
  }
}

export default withTranslation('store') (
  withRouter(ForgotPassword)
)
