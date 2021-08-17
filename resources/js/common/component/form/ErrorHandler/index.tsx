import classNames from 'classnames'
import React, { Component } from 'react'

interface ErrorHandlerProps {
  errors?: string[]
}

class ErrorHandler extends Component<ErrorHandlerProps> {
  private showErrors(): JSX.Element[] | undefined {
    if (this.props.errors) {
      return this.props.errors.map((item, index) => {
        return (
          <span className="error-msg" key={index}>
            {item}
          </span>
        )
      })
    }
  }

  public render(): JSX.Element {
    return (
      <div className={classNames('error-handler', this.props.errors?.length ? 'error' : '')}>
        {this.props.children}
        {this.showErrors()}
      </div>
    )
  }
}

export default ErrorHandler
