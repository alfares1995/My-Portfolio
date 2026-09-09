<script setup>
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Sun, Moon, Menu, X } from 'lucide-vue-next';
import { useAppearance } from '@/composables/useAppearance';

const links = [
  { label: 'Home', href: '/' },
  { label: 'About', href: '/about' },
  { label: 'Projects', href: '/projects' },
  { label: 'Blog', href: '/blog' },
  { label: 'Skills', href: '/skills' },
  { label: 'Testimonials', href: '/testimonials' },
];
const mobileMenuOpen = ref(false);
const hasMounted = ref(false);
const page = usePage();
const { resolvedAppearance, updateAppearance } = useAppearance();
const displayedAppearance = computed(() => hasMounted.value ? resolvedAppearance.value : 'light');
const currentPath = computed(() => page.url.split(/[?#]/)[0]);

const isActiveLink = (href) => {
  const linkPath = href.split('#')[0];

  return linkPath === '/'
    ? currentPath.value === '/'
    : currentPath.value === linkPath || currentPath.value.startsWith(`${linkPath}/`);
};

onMounted(() => {
  hasMounted.value = true;
});

const toggleAppearance = () => {
  updateAppearance(resolvedAppearance.value === 'dark' ? 'light' : 'dark');
};
</script>

<template>
  <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/80 backdrop-blur dark:border-white/5 dark:bg-slate-950/80">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
      <a href="/" class="text-lg font-semibold text-slate-900 dark:text-white">
        Dev<span class="text-violet-500">Folio</span>.
      </a>

      <ul class="hidden items-center gap-8 text-sm text-slate-600 dark:text-slate-300 md:flex">
        <li v-for="link in links" :key="link.label">
          <a
            :href="link.href"
            class="transition hover:text-slate-950 dark:hover:text-white"
            :class="isActiveLink(link.href) ? 'font-medium text-violet-500 dark:text-violet-400' : ''"
            :aria-current="isActiveLink(link.href) ? 'page' : undefined"
          >
            {{ link.label }}
          </a>
        </li>
      </ul>

      <div class="flex items-center gap-3">
        <a
          href="#contact"
          class="hidden rounded-lg bg-gradient-to-r from-violet-600 to-indigo-500 px-4 py-2 text-sm font-medium text-white shadow-lg shadow-violet-600/20 transition hover:opacity-90 sm:inline-flex"
        >
          Contact Me
        </a>
        <button
          type="button"
          class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 transition hover:text-slate-950 dark:bg-white/5 dark:text-slate-300 dark:hover:text-white"
          :aria-label="displayedAppearance === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
          @click="toggleAppearance"
        >
          <Sun v-if="displayedAppearance === 'dark'" class="h-4 w-4" />
          <Moon v-else class="h-4 w-4" />
        </button>
        <button
          type="button"
          class="grid h-9 w-9 place-items-center rounded-md bg-slate-100 text-slate-600 transition hover:text-slate-950 dark:bg-white/5 dark:text-slate-300 dark:hover:text-white md:hidden"
          :aria-expanded="mobileMenuOpen"
          aria-controls="mobile-navigation"
          aria-label="Toggle navigation menu"
          @click="mobileMenuOpen = !mobileMenuOpen"
        >
          <X v-if="mobileMenuOpen" class="h-5 w-5" />
          <Menu v-else class="h-5 w-5" />
        </button>
      </div>
    </nav>

    <div v-show="mobileMenuOpen" id="mobile-navigation" class="border-t border-slate-200 bg-white dark:border-white/5 dark:bg-slate-950 md:hidden">
      <ul class="mx-auto max-w-7xl space-y-1 px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
        <li v-for="link in links" :key="link.label">
          <a
            :href="link.href"
            class="block rounded-md px-3 py-2.5 transition hover:bg-slate-100 hover:text-slate-950 dark:hover:bg-white/5 dark:hover:text-white"
            :class="isActiveLink(link.href) ? 'bg-violet-50 font-medium text-violet-600 dark:bg-violet-500/10 dark:text-violet-400' : ''"
            :aria-current="isActiveLink(link.href) ? 'page' : undefined"
            @click="mobileMenuOpen = false"
          >
            {{ link.label }}
          </a>
        </li>
        <li class="pt-2 sm:hidden">
          <a
            href="#contact"
            class="block rounded-md bg-gradient-to-r from-violet-600 to-indigo-500 px-3 py-2.5 text-center font-medium text-white shadow-lg shadow-violet-600/20 transition hover:opacity-90"
            @click="mobileMenuOpen = false"
          >
            Contact Me
          </a>
        </li>
      </ul>
    </div>
  </header>
</template>
