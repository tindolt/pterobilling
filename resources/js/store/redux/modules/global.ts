/*
 * Global module store will allow us to share application data trhough the whole application
 */

interface Action<T extends string> {
  type: T
}

interface ActionWithPayload<T extends string, P extends unknown> extends Action<T> {
  payload: P
}

export function typedAction<T extends string>(type: T): { type: T }
export function typedAction<T extends string, P extends unknown>(
  type: T,
  payload: P
): { type: T; payload: P }
export function typedAction(
  type: string,
  payload?: unknown
): Action<string> | ActionWithPayload<string, unknown> {
  return { type, payload }
}

export interface GlobalState {
  appName: string
  appIcon: string
  appVersion: string
  plans: {
    id: number
    name: string
  }[]
}

const initialState: GlobalState = {
  appName: 'PteroBilling',
  appIcon: '/images/icon.png',
  appVersion: '',
  plans: [],
}

export function setGlobal(
  state: GlobalState
): ActionWithPayload<'global/SET_GLOBAL', typeof state> {
  return typedAction('global/SET_GLOBAL', state)
}

type GlobalAction = ReturnType<typeof setGlobal>

export function useReducer(state = initialState, actions: GlobalAction): GlobalState {
  switch (actions.type) {
    case 'global/SET_GLOBAL':
      return state

    default:
      return state
  }
}
