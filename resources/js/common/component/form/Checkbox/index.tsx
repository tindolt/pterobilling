import classNames from 'classnames'
import React, { ChangeEventHandler, Component } from 'react'

interface CheckboxProps {
  id: string
  label: string
  checked?: boolean
  className?: string
  name: string
  onChange?: ChangeEventHandler<HTMLInputElement>
  disabled?: boolean
}

class Checkbox extends Component<CheckboxProps> {
  public render(): JSX.Element {
    return (
      <div className={classNames('checkbox-field', this.props.className)}>
        <input
          id={this.props.id}
          type="checkbox"
          className="checkbox"
          onChange={this.props.onChange}
          disabled={this.props.disabled}
          defaultChecked={this.props.checked}
        />
        <label htmlFor={this.props.id} className="label">
          {this.props.label}
        </label>
      </div>
    )
  }
}

export default Checkbox
