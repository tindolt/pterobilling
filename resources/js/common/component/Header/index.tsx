import { RootState } from '@/store/redux'
import { GlobalState } from '@/store/redux/modules/global'
import React from 'react'
import { connect } from 'react-redux'
import { NavLink } from 'react-router-dom'
import { CombinedState } from 'redux'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global
type HeaderProps = ReturnType<typeof mapStateToProps> & {
  title: string
  icon?: string
}

class Header extends React.Component<HeaderProps> {
  private showIcon(): JSX.Element | undefined {
    if (this.props.icon) {
      return (
        <span className="icon is-small">
          <i className={this.props.icon}></i>
        </span>
      )
    }
  }
  public render(): JSX.Element {
    return (
      <header className="page-header">
        <div className="left">
          <h1 className="title is-1">{this.props.title}</h1>
        </div>
        <div className="right">
          <div className="breadcrumb is-right">
            <ul>
              <li>
                <NavLink to="/">{this.props.appName}</NavLink>
              </li>
              <li className="is-active">
                <a href="#">
                  {this.showIcon()}
                  <span>{this.props.title}</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </header>
    )
  }
}

export default connect(mapStateToProps)(Header)
