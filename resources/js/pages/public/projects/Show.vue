<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { ArrowLeft, ExternalLink, Github } from 'lucide-vue-next'
import PortfolioLayout from '@/layouts/PortfolioLayout.vue'
import { index } from '@/routes/projects'

defineOptions({ layout: PortfolioLayout })

type Technology = { id: number; name: string; color: string | null }
type ProjectImage = { id: number; image_url: string | null; caption: string | null }
type Project = {
  title: string
  short_description: string
  description: string
  thumbnail_url: string | null
  github_url: string | null
  live_url: string | null
  completion_date: string | null
  completion_date_label: string | null
  technologies: Technology[]
  images: ProjectImage[]
}

defineProps<{ project: Project }>()
</script>

<template>
  <Head :title="project.title" />

  <main>
    <section class="mx-auto max-w-5xl px-6 py-10 sm:py-16">
      <Link :href="index()" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-violet-600 dark:text-slate-400 dark:hover:text-violet-400"><ArrowLeft class="size-4" /> All projects</Link>
      <div class="mt-8 max-w-3xl">
        <div class="flex flex-wrap gap-2">
          <span v-for="technology in project.technologies" :key="technology.id" class="rounded-md px-2.5 py-1 text-xs font-medium" :style="technology.color ? { backgroundColor: `${technology.color}20`, color: technology.color } : undefined">{{ technology.name }}</span>
        </div>
        <h1 class="mt-5 text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-6xl">{{ project.title }}</h1>
        <p class="mt-5 text-lg leading-8 text-slate-600 dark:text-slate-400">{{ project.short_description }}</p>
        <div v-if="project.github_url || project.live_url" class="mt-7 flex flex-wrap gap-3">
          <a v-if="project.live_url" :href="project.live_url" target="_blank" rel="noreferrer" class="inline-flex h-11 items-center gap-2 rounded-lg bg-violet-600 px-4 text-sm font-medium text-white transition hover:bg-violet-700"><ExternalLink class="size-4" /> Visit site</a>
          <a v-if="project.github_url" :href="project.github_url" target="_blank" rel="noreferrer" class="inline-flex h-11 items-center gap-2 rounded-lg border border-slate-300 px-4 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50 dark:border-white/15 dark:text-slate-200 dark:hover:bg-white/5"><Github class="size-4" /> Source code</a>
        </div>
      </div>
      <img v-if="project.thumbnail_url" :src="project.thumbnail_url" :alt="project.title" class="mt-12 aspect-[16/9] w-full rounded-lg object-cover shadow-sm">
    </section>

    <section class="border-y border-slate-200 bg-white dark:border-white/5 dark:bg-white/[0.02]">
      <div class="mx-auto grid max-w-5xl gap-10 px-6 py-12 lg:grid-cols-[minmax(0,1fr)_14rem]">
        <div class="prose prose-slate max-w-none whitespace-pre-line dark:prose-invert"><p>{{ project.description }}</p></div>
        <dl v-if="project.completion_date_label" class="border-l border-slate-200 pl-6 dark:border-white/10">
          <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Completed</dt>
          <dd class="mt-2 text-sm font-medium text-slate-900 dark:text-white">{{ project.completion_date_label }}</dd>
        </dl>
      </div>
    </section>

    <section v-if="project.images.length" class="mx-auto max-w-5xl px-6 py-12 sm:py-16">
      <h2 class="text-2xl font-bold text-slate-950 dark:text-white">Project gallery</h2>
      <div class="mt-6 grid gap-5 sm:grid-cols-2">
        <figure v-for="image in project.images" :key="image.id">
          <img v-if="image.image_url" :src="image.image_url" :alt="image.caption ?? `${project.title} project image`" class="aspect-[4/3] w-full rounded-lg object-cover">
          <figcaption v-if="image.caption" class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ image.caption }}</figcaption>
        </figure>
      </div>
    </section>
  </main>
</template>