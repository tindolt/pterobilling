import classNames from 'classnames'
import React, { Component } from 'react'

/**
 * Main component for the card
 */
interface CardProps {
  children?: React.ReactNode
  body?: boolean
}

class Card extends Component<CardProps> {
  public render(): JSX.Element {
    return <div className="card">{this.props.body ? null : this.props.children}</div>
  }
}

/**
 * Card title component
 */
interface CardTitleProps {
  children?: React.ReactNode
  subtitle?: boolean
}
function CardTitleComponent(props: CardTitleProps): JSX.Element {
  return props.subtitle ? (
    <h6 className="card-subtitle">{props.children}</h6>
  ) : (
    <h5 className="card-title">{props.children}</h5>
  )
}

/**
 * Card header component
 */
interface CardHeaderProps {
  children?: React.ReactNode
}

function CardHeaderComponent(props: CardHeaderProps): JSX.Element {
  return <div className="card-header">{props.children}</div>
}

/**
 * Card body component
 */
interface CardBodyProps {
  children?: React.ReactNode
}

function CardBodyComponent(props: CardBodyProps): JSX.Element {
  return <div className="card-body">{props.children}</div>
}

/**
 * Card footer component
 */
interface CardFooterProps {
  children?: React.ReactNode
  aligment?: 'left' | 'center' | 'right'
}

function CardFooterComponent(props: CardFooterProps): JSX.Element {
  return <div className={classNames('card-footer', props.aligment)}>{props.children}</div>
}

/**
 * Card Text component
 */
interface CardTextProps {
  children?: React.ReactNode
}

function CardTextComponent(props: CardTextProps): JSX.Element {
  return <div className="card-text">{props.children}</div>
}

export default Object.assign(Card, {
  Title: CardTitleComponent,
  Body: CardBodyComponent,
  Text: CardTextComponent,
  Footer: CardFooterComponent,
  Header: CardHeaderComponent,
})
