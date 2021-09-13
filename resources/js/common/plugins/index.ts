import { createPluginStore } from 'react-pluggable'

const pluginStore = createPluginStore()

for (const plugin of window.plugins) {
  pluginStore.install(plugin)
}

export default pluginStore
