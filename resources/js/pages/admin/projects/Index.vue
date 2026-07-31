<template>
<AppLayout>
  <div>
    <h1>Projects</h1>
    <p>This is the Projects page for the admin section.</p>
  </div>

  <div class="my-4">
    <Input v-model="search" placeholder="Search..." />
  </div>

  <div class="my-4">
    <Button as-child>
      <Link :href="create()">Create Project</Link>
    </Button>
  </div>

  <Table>
    <TableCaption>A list of your projects.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[80px]">
          ID
        </TableHead>
        <TableHead>Thumbnail</TableHead>
        <TableHead>Title</TableHead>
        <TableHead>Technologies</TableHead>
        <TableHead>Images</TableHead>
        <TableHead>Featured</TableHead>
        <TableHead>Status</TableHead>
        <TableHead>Completion Date</TableHead>
        <TableHead class="text-right">
          Actions
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-if="filteredProjects.length === 0">
        <TableCell colspan="9" class="text-center text-muted-foreground">
          No projects found.
        </TableCell>
      </TableRow>
      <TableRow v-for="project in filteredProjects" :key="project.id">
        <TableCell class="font-medium">
          {{ project.id }}
        </TableCell>
        <TableCell>
          <img
            v-if="project.thumbnail_url"
            :src="project.thumbnail_url"
            alt="Thumbnail"
            class="h-12 w-20 rounded object-cover"
          >
          <span v-else class="text-muted-foreground">No image</span>
        </TableCell>
        <TableCell class="max-w-xs truncate">{{ project.title }}</TableCell>
        <TableCell>
          <div class="flex flex-wrap gap-1">
            <Badge v-for="technology in project.technologies" :key="technology.id" variant="secondary">
              {{ technology.name }}
            </Badge>
            <span v-if="project.technologies.length === 0" class="text-muted-foreground">—</span>
          </div>
        </TableCell>
        <TableCell>{{ project.images_count }}</TableCell>
        <TableCell>
          <Badge :variant="project.featured ? 'default' : 'outline'">
            {{ project.featured ? 'Yes' : 'No' }}
          </Badge>
        </TableCell>
        <TableCell>
          <Badge :variant="project.status === 'published' ? 'default' : 'outline'">
            {{ project.status }}
          </Badge>
        </TableCell>
        <TableCell>{{ project.completion_date ? new Date(project.completion_date).toLocaleDateString() : '—' }}</TableCell>
        <TableCell class="text-right">
          <div class="flex justify-end gap-2">
            <Button as-child variant="outline" size="icon" title="View">
              <Link :href="show(project.id)">
                <Eye class="size-4" />
              </Link>
            </Button>
            <Button as-child variant="outline" size="icon" title="Edit">
              <Link :href="edit(project.id)">
                <Pencil class="size-4" />
              </Link>
            </Button>
            <Button
              variant="destructive"
              size="icon"
              title="Delete"
              @click="handleDelete(project.id)"
            >
              <Trash2 class="size-4" />
            </Button>
          </div>
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</AppLayout>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'

import { Link, router } from '@inertiajs/vue3'
import { Eye, Pencil, Trash2 } from 'lucide-vue-next'

import { create, edit, show, destroy } from '@/routes/admin/projects'

type Technology = {
  id: number
  name: string
  icon: string | null
  color: string | null
}

type Project = {
  id: number
  title: string
  slug: string
  short_description: string
  description: string
  thumbnail: string | null
  thumbnail_url: string | null
  github_url: string | null
  live_url: string | null
  featured: boolean
  status: 'draft' | 'published'
  completion_date: string | null
  technologies: Technology[]
  images_count: number
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  projects: Project[]
}>()

const search = ref('')

const filteredProjects = computed(() => {
  const term = search.value.trim().toLowerCase()
  if (!term) {
    return props.projects
  }

  return props.projects.filter((project) =>
    [
      project.id,
      project.title,
      project.slug,
      project.short_description,
      project.status,
      ...project.technologies.map((technology) => technology.name),
    ]
      .filter((value) => value !== null && value !== undefined && value !== '')
      .some((value) => String(value).toLowerCase().includes(term)),
  )
})

function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this project?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>
