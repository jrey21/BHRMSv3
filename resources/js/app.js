import './bootstrap'; 
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Layout from './Layouts/Layout.vue';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
// import { Link } from '@inertiajs/inertia-vue3';
// import axios from 'axios';

// Set Axios base URL
// axios.defaults.baseURL = 'http://localhost:8000';

// Optional: You can attach Axios globally to Vue for easier access
// app.config.globalProperties.$axios = axios;

createInertiaApp({
  title: (title) => `BHRMS ${title}`,

  // Use for default layouts
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    let page = pages[`./Pages/${name}.vue`];
    page.default.layout = page.default.layout || Layout;
    return page;
  },

  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component('Head', Head)
      .component('Link', Link);

    app.config.globalProperties.$inertia.on('start', () => NProgress.start());
    app.config.globalProperties.$inertia.on('finish', () => NProgress.done());

    app.mount(el);
  },
  progress: {
    // The color of the progress bar...
    color: '#29d',
    // Whether to include the default NProgress styles...
    includeCSS: true,
  },
});

const toggleButton = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');

function toggleSidebar() {
  sidebar.classList.toggle('close');
  toggleButton.classList.toggle('rotate');

  closeAllSubMenus();
}

function toggleSubMenu(button) {
  if (!button.nextElementSibling.classList.contains('show')) {
    closeAllSubMenus();
  }

  button.nextElementSibling.classList.toggle('show');
  button.classList.toggle('rotate');

  if (sidebar.classList.contains('close')) {
    sidebar.classList.toggle('close');
    toggleButton.classList.toggle('rotate');
  }
}

function closeAllSubMenus() {
  Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
    ul.classList.remove('show');
    ul.previousElementSibling.classList.remove('rotate');
  });
}
