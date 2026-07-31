<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { edit, index } from '@/routes/admin/projects'

type Technology = {
  id: number
  name: string
  icon: string | null
  color: string | null
}

type ProjectImage = {
  id: number
  image_url: string | null
  caption: string | null
  sort_order: number
}

type ProjectRecord = {
  id: number
  title: string
  slug: string
  short_description: string
  description: string
  thumbnail_url: string | null
  github_url: string | null
  live_url: string | null
  featured: boolean
  status: 'draft' | 'published'
  completion_date: string | null
  technologies: Technology[]
  images: ProjectImage[]
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  project: ProjectRecord
}>()
</script>

<template>
  <Head :title="`Project: ${props.project.title}`" />

  <AppLayout>
    <div class="space-y-4">
      <div class="flex items-center justify-between">
        <h1>{{ props.project.title }}</h1>
        <div class="flex gap-2">
          <Button as-child variant="outline">
            <Link :href="index()">Back to list</Link>
          </Button>
          <Button as-child>
            <Link :href="edit(props.project.id)">Edit</Link>
          </Button>
        </div>
      </div>

      <img
        v-if="props.project.thumbnail_url"
        :src="props.project.thumbnail_url"
        alt="Thumbnail"
        class="h-48 w-full max-w-md rounded object-cover"
      >

      <div class="flex flex-wrap items-center gap-2">
        <Badge :variant="props.project.status === 'published' ? 'default' : 'outline'">
          {{ props.project.status }}
        </Badge>
        <Badge v-if="props.project.featured" variant="default">Featured</Badge>
        <Badge v-for="technology in props.project.technologies" :key="technology.id" variant="secondary">
          {{ technology.name }}
        </Badge>
      </div>

      <p><strong>Slug:</strong> {{ props.project.slug }}</p>
      <p><strong>GitHub URL:</strong> <a v-if="props.project.github_url" :href="props.project.github_url" target="_blank" class="underline">{{ props.project.github_url }}</a><span v-else>—</span></p>
      <p><strong>Live URL:</strong> <a v-if="props.project.live_url" :href="props.project.live_url" target="_blank" class="underline">{{ props.project.live_url }}</a><span v-else>—</span></p>
      <p><strong>Completion Date:</strong> {{ props.project.completion_date ? new Date(props.project.completion_date).toLocaleDateString() : '—' }}</p>
      <p><strong>Short Description:</strong> {{ props.project.short_description }}</p>

      <div>
        <strong>Description:</strong>
        <p class="whitespace-pre-wrap">{{ props.project.description }}</p>
      </div>

      <div v-if="props.project.images.length > 0">
        <strong>Gallery</strong>
        <div class="mt-2 flex flex-wrap gap-4">
          <img
            v-for="image in props.project.images"
            :key="image.id"
            :src="image.image_url ?? ''"
            :alt="image.caption ?? 'Gallery image'"
            class="h-24 w-32 rounded object-cover"
          >
        </div>
      </div>

      <p><strong>Created At:</strong> {{ props.project.created_at ? new Date(props.project.created_at).toLocaleString() : '—' }}</p>
      <p><strong>Updated At:</strong> {{ props.project.updated_at ? new Date(props.project.updated_at).toLocaleString() : '—' }}</p>
    </div>
  </AppLayout>
</template>
