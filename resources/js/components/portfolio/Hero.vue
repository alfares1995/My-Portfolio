<script setup>
import { Github, Linkedin, Twitter, Mail, Code2 } from 'lucide-vue-next';

defineProps({ profile: Object });

const iconMap = { github: Github, linkedin: Linkedin, twitter: Twitter, mail: Mail };
</script>

<template>
  <section class="mx-auto grid max-w-7xl gap-12 px-6 py-20 md:grid-cols-2 md:items-center">
    <div>
      <span class="inline-flex items-center gap-2 rounded-full bg-white/5 px-4 py-1.5 text-sm text-slate-300">
        👋 Hi, I'm
      </span>

      <h1 class="mt-6 text-5xl font-bold leading-tight text-white md:text-6xl">
        {{ profile.firstName }}
        <span class="bg-gradient-to-r from-violet-500 to-indigo-400 bg-clip-text text-transparent">
          {{ profile.lastName }}
        </span>
      </h1>

      <p class="mt-3 text-2xl font-medium text-slate-200">
        {{ profile.role }} <span class="animate-pulse text-violet-400">|</span>
      </p>

      <p class="mt-4 max-w-md text-slate-400">
        {{ profile.tagline }}
      </p>

      <div class="mt-8 flex flex-wrap gap-4">
        <a
          href="#projects"
          class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-violet-600 to-indigo-500 px-6 py-3 font-medium text-white shadow-lg shadow-violet-600/20 transition hover:opacity-90"
        >
          View My Work →
        </a>
        <a
          href="/cv.pdf"
          class="inline-flex items-center gap-2 rounded-lg border border-white/10 px-6 py-3 font-medium text-white transition hover:bg-white/5"
        >
          Download CV ↓
        </a>
      </div>

      <div class="mt-10">
        <p class="text-xs font-medium uppercase tracking-wider text-slate-500">Connect with me</p>
        <div class="mt-3 flex gap-4">
          <a
            v-for="s in profile.social"
            :key="s.icon"
            :href="s.url"
            class="grid h-10 w-10 place-items-center rounded-full bg-white/5 text-slate-300 transition hover:bg-white/10 hover:text-white"
          >
            <component :is="iconMap[s.icon]" class="h-4 w-4" />
          </a>
        </div>
      </div>
    </div>

    <div class="relative mx-auto flex h-80 w-80 items-center justify-center md:h-96 md:w-96">
      <div class="absolute inset-0 rounded-full border border-violet-500/40 shadow-[0_0_80px_20px_rgba(139,92,246,0.15)]"></div>
      <img
        :src="profile.avatar"
        alt="Profile photo"
        class="h-[85%] w-[85%] rounded-full object-cover"
      />
      <div class="absolute left-0 top-6 grid h-10 w-10 place-items-center rounded-xl bg-slate-800 text-violet-400">
        <Code2 class="h-5 w-5" />
      </div>
      <div class="absolute right-0 top-16 grid h-9 w-9 place-items-center rounded-lg bg-yellow-400 text-xs font-bold text-slate-900">
        JS
      </div>
      <div class="absolute bottom-16 left-2 grid h-9 w-9 place-items-center rounded-lg bg-emerald-500/20 text-sm font-bold text-emerald-400">
        V
      </div>
    </div>
  </section>
</template>
