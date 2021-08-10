import { RootState } from '@/store/redux'
import { GlobalState, setCurrentRouteName } from '@/store/redux/modules/global'
import React from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { connect } from 'react-redux'
import { CombinedState } from 'redux'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global
const mapDispatchToProps = { setCurrentRouteName }

type HomeProps = ReturnType<typeof mapStateToProps> &
  typeof mapDispatchToProps &
  I18nextProviderProps

class Home extends React.Component<HomeProps> {
  public componentDidMount(): void {
    this.props.setCurrentRouteName(this.props.i18n.t('store:routes.home'))
  }

  public render(): JSX.Element {
    return (
      <div>
        <h1>Home</h1>
      </div>
    )
  }
}

export default withTranslation('store')(connect(mapStateToProps, mapDispatchToProps)(Home))
