import Tool from './components/Tool.vue';

Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-calendar-tool',
      path: '/nova-calendar-tool',
      component: Tool,
    },
  ]);
})
