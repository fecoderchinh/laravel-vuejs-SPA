<template>
  <div id="app">
    <loading ref="loading" />

    <transition name="page" mode="out-in">
      <component :is="layout" v-if="layout" />
    </transition>
    <notifications position="bottom right"
                   animation-type="velocity"
                   :animation="animation"
                   :speed="500"
                   :max="3"
    />
  </div>
</template>

<script>
import Loading from './Loading'

// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  el: '#app',

  components: {
    Loading
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default'
  }),

  metaInfo () {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  computed: {
    animation () {
      return {
        /**
         * Animation function
         *
         * Runs before animating, so you can take the initial height, width, color, etc
         * @param  {HTMLElement}  element  The notification element
         */
        enter (element) {
          let height = element.clientHeight
          return {
            // animates from 0px to "height"
            height: [height, 0],

            // animates from 0 to random opacity (in range between 0.5 and 1)
            opacity: [Math.random() * 0.5 + 0.5, 0]
          }
        },
        leave: {
          height: 0,
          opacity: 0
        }
      }
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout (layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  }
}
</script>
