<script setup>
import { Github, ExternalLink } from 'lucide-vue-next';

defineProps({ projects: { type: Array, default: () => [] } });
</script>

<template>
  <section id="projects" class="mx-auto max-w-7xl px-6 py-16">
    <div class="mb-8 flex items-end justify-between">
      <div>
        <span class="text-sm font-semibold uppercase tracking-wider text-violet-400">My Work</span>
        <h2 class="mt-2 text-3xl font-bold text-white">Featured Projects</h2>
      </div>
      <a href="/projects" class="hidden text-sm font-medium text-violet-400 hover:text-violet-300 sm:block">
        View All Projects →
      </a>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
      <article
        v-for="project in projects"
        :key="project.title"
        class="overflow-hidden rounded-2xl border border-white/5 bg-white/[0.02] transition hover:-translate-y-1 hover:border-violet-500/30"
      >
        <img :src="project.image" :alt="project.title" class="h-44 w-full object-cover" />
        <div class="p-5">
          <h3 class="font-semibold text-white">{{ project.title }}</h3>
          <p class="mt-2 text-sm text-slate-400">{{ project.description }}</p>

          <div class="mt-4 flex flex-wrap gap-2">
            <span
              v-for="tag in project.tags"
              :key="tag"
              class="rounded-md bg-white/5 px-2.5 py-1 text-xs text-slate-300"
            >
              {{ tag }}
            </span>
          </div>

          <div class="mt-5 flex gap-3">
            <a :href="project.repoUrl" class="text-slate-400 hover:text-white">
              <Github class="h-4 w-4" />
            </a>
            <a :href="project.liveUrl" class="text-slate-400 hover:text-white">
              <ExternalLink class="h-4 w-4" />
            </a>
          </div>
        </div>
      </article>
    </div>
  </section>
</template>
