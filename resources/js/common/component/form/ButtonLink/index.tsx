import React, { Component } from 'react'
import classNames from 'classnames'
import { Link } from 'react-router-dom'

interface ButtonProps {
  children: React.ReactNode
  className?: string
  disabled?: boolean
  to: string
  icon?: string
  external?: boolean
}

class ButtonLink extends Component<ButtonProps> {
  public render(): JSX.Element {
    const cNames = classNames('button', this.props.className, { disabled: this.props.disabled })
    if (this.props.external) {
      return (
        <a href={this.props.to} className={cNames}>
          {this.props.icon ? <i className={classNames('icon', this.props.icon)} /> : null}

          {this.props.children}
        </a>
      )
    } else {
      return (
        <Link to={this.props.disabled ? '' : this.props.to} className={cNames}>
          {this.props.icon ? <i className={classNames('icon', this.props.icon)} /> : null}

          {this.props.children}
        </Link>
      )
    }
  }
}

export default ButtonLink
