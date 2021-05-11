<template>
  <div class="w-full min-h-screen">
    <Navbar />
    <child />
    <Footer />
  </div>
</template>

<script>
import Navbar from '~/components/front/Navbar'
import Footer from '~/components/Footer'

export default {
  name: 'BasicLayout',
  components: {
    Navbar,
    Footer
  }
}
</script>
