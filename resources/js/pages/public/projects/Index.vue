<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, watch } from 'vue'
import { ArrowRight, Code2 } from 'lucide-vue-next'
import PortfolioLayout from '@/layouts/PortfolioLayout.vue'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { index, show } from '@/routes/projects'

defineOptions({ layout: PortfolioLayout })

type Technology = {
  id: number
  name: string
  color: string | null
}

type Project = {
  id: number
  title: string
  slug: string
  short_description: string
  thumbnail_url: string | null
  completion_date: string | null
  technologies: Technology[]
}

const props = defineProps<{
  projects: Project[]
  technologies: Technology[]
  filters: { technology: string | null }
}>()

const allTechnologiesValue = 'all'
const selectedTechnology = ref(props.filters.technology ?? allTechnologiesValue)
const projectCount = computed(() => `${props.projects.length} project${props.projects.length === 1 ? '' : 's'}`)

watch(selectedTechnology, (technology) => {
  router.get(index({ query: technology === allTechnologiesValue ? {} : { technology } }).url, {}, {
    preserveScroll: true,
    preserveState: true,
  })
})
</script>

<template>
  <Head title="Projects" />

  <main>
    <section class="border-b border-slate-200 bg-white dark:border-white/5 dark:bg-slate-950">
      <div class="mx-auto max-w-7xl px-6 py-16 sm:py-20">
        <p class="text-sm font-semibold uppercase tracking-wider text-violet-500">Selected work</p>
        <div class="mt-3 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
          <div>
            <h1 class="text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">Projects</h1>
            <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600 dark:text-slate-400">A collection of published work across product, web, and engineering.</p>
          </div>
          <label class="block w-full md:w-64">
            <span class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Technology</span>
            <Select v-model="selectedTechnology">
              <SelectTrigger class="h-11 w-full rounded-lg border-slate-300 bg-white text-slate-900 shadow-sm hover:bg-slate-50 focus-visible:border-violet-500 focus-visible:ring-violet-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                <SelectValue placeholder="All technologies" />
              </SelectTrigger>
              <SelectContent class="rounded-lg border-slate-300 bg-white text-slate-900 shadow-lg dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                <SelectItem :value="allTechnologiesValue">All technologies</SelectItem>
                <SelectItem v-for="technology in technologies" :key="technology.id" :value="technology.name">
                  {{ technology.name }}
                </SelectItem>
              </SelectContent>
            </Select>
          </label>
        </div>
      </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 sm:py-16">
      <p class="mb-6 text-sm text-slate-500 dark:text-slate-400">{{ projectCount }}</p>
      <div v-if="projects.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <article v-for="project in projects" :key="project.id" class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-violet-300 hover:shadow-lg dark:border-white/10 dark:bg-white/[0.03] dark:hover:border-violet-400/50">
          <Link :href="show(project.slug)" class="block">
            <div class="aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-white/5">
              <img v-if="project.thumbnail_url" :src="project.thumbnail_url" :alt="project.title" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
              <div v-else class="grid h-full place-items-center text-slate-400 dark:text-slate-500"><Code2 class="size-10" /></div>
            </div>
            <div class="p-5">
              <div class="flex flex-wrap gap-2">
                <span v-for="technology in project.technologies" :key="technology.id" class="rounded-md px-2 py-1 text-xs font-medium" :style="technology.color ? { backgroundColor: `${technology.color}20`, color: technology.color } : undefined">{{ technology.name }}</span>
              </div>
              <h2 class="mt-4 text-xl font-semibold text-slate-950 dark:text-white">{{ project.title }}</h2>
              <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ project.short_description }}</p>
              <span class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-violet-600 dark:text-violet-400">View project <ArrowRight class="size-4 transition group-hover:translate-x-1" /></span>
            </div>
          </Link>
        </article>
      </div>
      <div v-else class="border border-dashed border-slate-300 px-6 py-16 text-center dark:border-white/15">
        <p class="text-lg font-medium text-slate-900 dark:text-white">No projects found</p>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Try selecting a different technology.</p>
      </div>
    </section>
  </main>
</template>