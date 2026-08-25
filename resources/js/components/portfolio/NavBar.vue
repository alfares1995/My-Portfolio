<script setup>
import { ref } from 'vue';
import { Sun, Moon } from 'lucide-vue-next';

const links = ['Home', 'About', 'Projects', 'Blog', 'Skills', 'Testimonials'];
const dark = ref(true);
</script>

<template>
  <header class="sticky top-0 z-50 border-b border-white/5 bg-slate-950/80 backdrop-blur">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
      <a href="/" class="text-lg font-semibold text-white">
        Dev<span class="text-violet-500">Folio</span>.
      </a>

      <ul class="hidden items-center gap-8 text-sm text-slate-300 md:flex">
        <li v-for="(link, i) in links" :key="link">
          <a
            href="#"
            class="transition hover:text-white"
            :class="i === 0 ? 'text-violet-400' : ''"
          >
            {{ link }}
          </a>
        </li>
      </ul>

      <div class="flex items-center gap-3">
        <a
          href="#contact"
          class="rounded-lg bg-gradient-to-r from-violet-600 to-indigo-500 px-4 py-2 text-sm font-medium text-white shadow-lg shadow-violet-600/20 transition hover:opacity-90"
        >
          Contact Me
        </a>
        <button
          type="button"
          class="grid h-9 w-9 place-items-center rounded-full bg-white/5 text-slate-300 hover:text-white"
          @click="dark = !dark"
        >
          <Sun v-if="dark" class="h-4 w-4" />
          <Moon v-else class="h-4 w-4" />
        </button>
      </div>
    </nav>
  </header>
</template>
