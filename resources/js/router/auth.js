import helpers from '~/utils/helpers'

export default [
  { path: '/login', name: 'login', component: helpers.page('auth/login.vue') },
  { path: '/register', name: 'register', component: helpers.page('auth/register.vue') },
  { path: '/terms', name: 'terms', component: helpers.page('legal/terms.vue') },
  { path: '/password/reset', name: 'password.request', component: helpers.page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: helpers.page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: helpers.page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: helpers.page('auth/verification/resend.vue') },

  { path: '/settings',
    component: helpers.page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: helpers.page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: helpers.page('settings/password.vue') }
    ] },

  { path: '/404', alias: '*', name: '404', component: helpers.page('errors/404.vue') }
]
