import React from 'react'
import Navbar from './components/NavBar'

export default class App extends React.Component {
  public render(): JSX.Element {
    return (
      <>
        <Navbar />
        <h1 className="text-blue-500">Hello ReactJS</h1>
      </>
    )
  }
}
