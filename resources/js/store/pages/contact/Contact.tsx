import Card from '@/common/component/Card'
import ErrorHandler from '@/common/component/form/ErrorHandler'
import Input from '@/common/component/form/Input'
import Textarea from '@/common/component/form/Textarea'
import { RootState } from '@/store/redux'
import { GlobalState, setCurrentRouteName } from '@/store/redux/modules/global'
import React from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { connect } from 'react-redux'
import { CombinedState } from 'redux'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global
const mapDispatchToProps = { setCurrentRouteName }

type ContactProps = ReturnType<typeof mapStateToProps> &
  typeof mapDispatchToProps &
  I18nextProviderProps

interface ContactState {
  email: string
  name: string
  subject: string
  message: string
  errors?: {
    [key: string]: string[]
  }
}

class Contact extends React.Component<ContactProps, ContactState> {
  public state: ContactState = {
    email: '',
    name: '',
    subject: '',
    message: '',
  }

  public componentDidMount(): void {
    this.props.setCurrentRouteName(this.props.i18n.t('store:routes.contact'))
  }
  public render(): JSX.Element {
    const i18n = this.props.i18n
    return (
      <div id="contact-us">
        <form onSubmit={() => null} className="container">
          <Card>
            <Card.Header>
              <Card.Title>{i18n.t('store:pages.contact.title')}</Card.Title>
            </Card.Header>
            <Card.Body>
              <Card.Text>
                <label htmlFor="email" className="label">
                  {i18n.t('store:pages.contact.email')}
                </label>
                <ErrorHandler errors={this.state.errors?.email}>
                  <Input
                    id="email"
                    name="email"
                    type="email"
                    placeholder={i18n.t('store:pages.contact.email')}
                    icon="fas fa-at"
                    value={this.state.email}
                    onChange={(event) => this.setState({ email: event.target.value })}
                  />
                </ErrorHandler>

                <label htmlFor="name" className="label">
                  {i18n.t('store:pages.contact.name')}
                </label>
                <ErrorHandler errors={this.state.errors?.email}>
                  <Input
                    id="name"
                    name="name"
                    type="text"
                    placeholder={i18n.t('store:pages.contact.name')}
                    icon="fas fa-user"
                    value={this.state.name}
                    onChange={(event) => this.setState({ name: event.target.value })}
                  />
                </ErrorHandler>

                <label htmlFor="subject" className="label">
                  {i18n.t('store:pages.contact.subject')}
                </label>
                <ErrorHandler errors={this.state.errors?.subject}>
                  <Input
                    id="suject"
                    name="subject"
                    type="text"
                    placeholder={i18n.t('store:pages.contact.subject')}
                    icon="fas fa-comment"
                    value={this.state.subject}
                    onChange={(event) => this.setState({ subject: event.target.value })}
                  />
                </ErrorHandler>

                <label htmlFor="message" className="label">
                  {i18n.t('store:pages.contact.message')}
                </label>
                <ErrorHandler errors={this.state.errors?.message}>
                  <Textarea
                    id="message"
                    name="message"
                    placeholder={i18n.t('store:pages.contact.messagePlaceholder')}
                    icon="fas fa-comments"
                    value={this.state.message}
                    onChange={(event) => this.setState({ message: event.target.value })}
                    autosize
                  />
                </ErrorHandler>
              </Card.Text>
            </Card.Body>
            <Card.Footer aligment="center">
              <button type="submit" className="button">
                {i18n.t('store:pages.contact.send')}
              </button>
            </Card.Footer>
          </Card>
        </form>
      </div>
    )
  }
}

export default withTranslation('store')(connect(mapStateToProps, mapDispatchToProps)(Contact))
