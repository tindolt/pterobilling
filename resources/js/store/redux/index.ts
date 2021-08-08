import { applyMiddleware, combineReducers, createStore, compose } from 'redux'
import * as global from './modules/global'
import thunk from 'redux-thunk'
import { createLogger } from 'redux-logger'

// Creating the Redux logger
const logger = createLogger()

// Applying modules
export const rootReducer = combineReducers({
  global: global.useReducer,
})

/*
 * Setup the compose enhancer:
 * - if we are in production mode, use the redux composer
 * - else, use the redux devtool composer if present
 */
declare global {
  interface Window {
    __REDUX_DEVTOOLS_EXTENSION_COMPOSE__?: typeof compose
  }
}

let composeEnhancer: typeof compose
if (process.env.NODE_ENV === 'production' && window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__) {
  composeEnhancer = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__
} else {
  composeEnhancer = compose
}

export type RootState = ReturnType<typeof rootReducer>

// Configure redux midlewares depending on the NODE_ENV
const middlewares = process.env.NODE_ENV !== 'development' ? [thunk] : [thunk, logger]

// Create the store and export it
const store = createStore(rootReducer, composeEnhancer(applyMiddleware(...middlewares)))
export default store
