import React, { Component } from 'react'
import classNames from 'classnames'

interface ButtonProps {
  children: React.ReactNode
  className?: string
  type: 'button' | 'submit' | 'reset'
  disabled?: boolean
  onClick?: (event: React.MouseEvent<HTMLButtonElement>) => void
  icon?: string
}

class Button extends Component<ButtonProps> {
  public render(): JSX.Element {
    return (
      <button
        className={classNames('button', this.props.className)}
        type={this.props.type}
        disabled={this.props.disabled}
        onClick={this.props.onClick}
      >
        {this.props.icon ? <i className={classNames('icon', this.props.icon)} /> : null}

        {this.props.children}
      </button>
    )
  }
}

export default Button
