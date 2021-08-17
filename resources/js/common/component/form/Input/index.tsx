import React, { ChangeEventHandler, Component } from 'react'
import classNames from 'classnames'

interface InputProps {
  id: string
  name: string
  type?: 'text' | 'number' | 'email' | 'password'
  placeholder?: string
  className?: string
  icon?: string
  onChange?: ChangeEventHandler<HTMLInputElement>
  disabled?: boolean
  value?: string
}

class Input extends Component<InputProps> {
  private showIcon(): JSX.Element | undefined {
    if (this.props.icon) {
      return (
        <span className="input-icon">
          <i className={this.props.icon} />
        </span>
      )
    }
  }

  public render(): JSX.Element {
    return (
      <div
        className={classNames('input-field', this.props.className, {
          'with-icon': this.props.icon != undefined,
        })}
      >
        {this.showIcon()}

        <input
          id={this.props.id}
          className="input"
          name={this.props.name}
          placeholder={this.props.placeholder}
          onChange={this.props.onChange}
          disabled={this.props.disabled}
          type={this.props.type || 'text'}
        />
      </div>
    )
  }
}

export default Input
