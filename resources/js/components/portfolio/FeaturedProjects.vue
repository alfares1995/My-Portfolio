<script setup>
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Code2 } from 'lucide-vue-next';
import { show } from '@/routes/projects';

defineProps({ projects: { type: Array, default: () => [] } });
</script>

<template>
  <section id="projects" class="mx-auto max-w-7xl px-6 py-16">
    <div class="mb-8 flex items-end justify-between">
      <div>
        <span class="text-sm font-semibold uppercase tracking-wider text-violet-400">My Work</span>
        <h2 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Featured Projects</h2>
      </div>
      <a href="/projects" class="hidden text-sm font-medium text-violet-400 hover:text-violet-300 sm:block">
        View All Projects →
      </a>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <article
        v-for="project in projects"
        :key="project.id"
        class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-violet-300 hover:shadow-lg dark:border-white/10 dark:bg-white/[0.03] dark:hover:border-violet-400/50"
      >
        <Link :href="show(project.slug)" class="block">
          <div class="aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-white/5">
            <img v-if="project.thumbnailUrl" :src="project.thumbnailUrl" :alt="project.title" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
            <div v-else class="grid h-full place-items-center text-slate-400 dark:text-slate-500"><Code2 class="size-10" /></div>
          </div>
          <div class="p-5">
            <div class="flex flex-wrap gap-2">
              <span v-for="technology in project.technologies" :key="technology.id" class="rounded-md px-2 py-1 text-xs font-medium" :style="technology.color ? { backgroundColor: `${technology.color}20`, color: technology.color } : undefined">{{ technology.name }}</span>
            </div>
            <h3 class="mt-4 text-xl font-semibold text-slate-950 dark:text-white">{{ project.title }}</h3>
            <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ project.shortDescription }}</p>
            <span class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-violet-600 dark:text-violet-400">View project <ArrowRight class="size-4 transition group-hover:translate-x-1" /></span>
          </div>
        </Link>
      </article>
    </div>
  </section>
</template>
