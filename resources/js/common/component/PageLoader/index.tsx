import classNames from 'classnames'
import React from 'react'

interface PreloaderState {
  loading: boolean
  appName: string
}

export default class PageLoader extends React.Component<unknown, PreloaderState> {
  public state: PreloaderState = {
    loading: false,
    appName: '',
  }

  public componentDidMount(): void {
    this.setState({
      appName: document.body.dataset['compagny'] || 'test',
    })

    document.onreadystatechange = () => {
      console.log('test')
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
          active: this.state.loading,
        })}
      >
        <img className="preloader-logo" src="/images/icon.png" alt={`${this.state.appName} Logo`} />
        <p className="preloader-brand">{this.state.appName}</p>
      </div>
    )
  }
}
