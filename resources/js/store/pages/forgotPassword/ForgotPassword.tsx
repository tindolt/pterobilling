import Card from '@/common/component/Card'
import Input from '@/common/component/form/Input'
import ErrorHandler from '@/common/component/form/ErrorHandler'
import { forgot_password } from '@/store/redux/modules/user'
import React from 'react'
import { RootState } from '@/store/redux'
import { CombinedState } from 'redux'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { setCurrentRouteName } from '@/store/redux/modules/global'
import { Link, RouteComponentProps, withRouter } from 'react-router-dom'
import API from '@/common/utils/API'
import { UserInfo } from '@/typings'

const mapStateToProps = (state: RootState): CombinedState<RootState> => state
const mapDispatchToProps = { forgot_password, setCurrentRouteName }
type ForgotPasswordProps = ReturnType<typeof mapStateToProps> &
  I18nextProviderProps &
  RouteComponentProps &
  typeof mapDispatchToProps

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


