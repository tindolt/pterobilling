import React, { ChangeEventHandler, Component } from 'react'
import classNames from 'classnames'
import autosize from 'autosize'

interface TextareaProps {
  id: string
  name: string
  rows?: number
  cols?: number
  placeholder?: string
  className?: string
  icon?: string
  onChange?: ChangeEventHandler<HTMLTextAreaElement>
  disabled?: boolean
  value?: string
  autosize?: boolean
}

class Textarea extends Component<TextareaProps> {
  private textareaRef: React.RefObject<HTMLTextAreaElement>

  public constructor(props: TextareaProps) {
    super(props)
    this.textareaRef = React.createRef()
  }

  private showIcon(): JSX.Element | undefined {
    if (this.props.icon) {
      return (
        <span className="textarea-icon">
          <i className={this.props.icon} />
        </span>
      )
    }
  }

  public componentDidMount(): void {
    if (this.props.autosize && this.textareaRef.current) {
      autosize(this.textareaRef.current)
    }
  }

  public render(): JSX.Element {
    return (
      <div
        className={classNames('textarea-field', this.props.className, {
          'with-icon': this.props.icon != undefined,
        })}
      >
        {this.showIcon()}

        <textarea
          id={this.props.id}
          className="textarea"
          name={this.props.name}
          placeholder={this.props.placeholder}
          onChange={this.props.onChange}
          disabled={this.props.disabled}
          cols={this.props.cols || 30}
          rows={this.props.rows || 5}
          ref={this.textareaRef}
        />
      </div>
    )
  }
}

export default Textarea
