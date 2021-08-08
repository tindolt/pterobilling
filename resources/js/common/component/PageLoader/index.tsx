import classNames from 'classnames'
import React from 'react'

interface PreloaderState {
  loading: boolean
  appName: string
}

interface PreloaderProps {
  needToLoad: boolean
}

export default class PageLoader extends React.Component<PreloaderProps, PreloaderState> {
  public state: PreloaderState = {
    loading: false,
    appName: '',
  }

  public componentDidMount(): void {
    this.setState({
      appName: document.body.dataset['compagny'] || 'test',
    })

    document.onreadystatechange = () => {
      if (document.readyState === 'complete') {
        setTimeout(() => {
          this.setState({
            loading: false,
          })
        }, 200)
      } else {
        this.setState({
          loading: true,
        })
      }
    }
  }

  public render(): JSX.Element {
    return (
      <div
        className={classNames('preloader', {
          active: this.state.loading && (this.props.needToLoad || false),
        })}
      >
        <img className="preloader-logo" src="/images/icon.png" alt={`${this.state.appName} Logo`} />
        <p className="preloader-brand">{this.state.appName}</p>
      </div>
    )
  }
}
