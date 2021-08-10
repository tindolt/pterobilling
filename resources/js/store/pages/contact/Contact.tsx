import { RootState } from '@/store/redux'
import { GlobalState, setCurrentRouteName } from '@/store/redux/modules/global'
import React, { Component } from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { connect } from 'react-redux'
import { CombinedState } from 'redux'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global
const mapDispatchToProps = { setCurrentRouteName }

type ContactProps = ReturnType<typeof mapStateToProps> &
  typeof mapDispatchToProps &
  I18nextProviderProps

class Contact extends Component<ContactProps> {
  public componentDidMount(): void {
    this.props.setCurrentRouteName(this.props.i18n.t('store:routes.contact'))
  }
  public render(): JSX.Element {
    return <div id="contac-us"></div>
  }
}

export default withTranslation('store')(connect(mapStateToProps, mapDispatchToProps)(Contact))
