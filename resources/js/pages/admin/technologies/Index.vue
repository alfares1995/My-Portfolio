<template>
<AppLayout>
  <div>
    <h1>Technologies</h1>
    <p>This is the Technologies page for the admin section.</p>
  </div>

  <div class="my-4">
    <Input v-model="search" placeholder="Search..." />
  </div>

  <div class="my-4">
    <Button as-child>
      <Link :href="create()">Create Technology</Link>
    </Button>
  </div>

  <Table>
    <TableCaption>A list of your technologies.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[80px]">
          ID
        </TableHead>
        <TableHead>Icon</TableHead>
        <TableHead>Name</TableHead>
        <TableHead>Color</TableHead>
        <TableHead>Projects</TableHead>
        <TableHead>Created At</TableHead>
        <TableHead class="text-right">
          Actions
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-if="filteredTechnologies.length === 0">
        <TableCell colspan="7" class="text-center text-muted-foreground">
          No technologies found.
        </TableCell>
      </TableRow>
      <TableRow v-for="technology in filteredTechnologies" :key="technology.id">
        <TableCell class="font-medium">
          {{ technology.id }}
        </TableCell>
        <TableCell>
          <span v-if="technology.icon" class="text-sm text-muted-foreground">{{ technology.icon }}</span>
          <span v-else class="text-muted-foreground">—</span>
        </TableCell>
        <TableCell>{{ technology.name }}</TableCell>
        <TableCell>
          <div v-if="technology.color" class="flex items-center gap-2">
            <span class="size-4 rounded-full border" :style="{ backgroundColor: technology.color }" />
            {{ technology.color }}
          </div>
          <span v-else class="text-muted-foreground">—</span>
        </TableCell>
        <TableCell>{{ technology.projects_count ?? 0 }}</TableCell>
        <TableCell>{{ technology.created_at ? new Date(technology.created_at).toLocaleDateString() : '—' }}</TableCell>
        <TableCell class="text-right">
          <div class="flex justify-end gap-2">
            <Button as-child variant="outline" size="icon" title="View">
              <Link :href="show(technology.id)">
                <Eye class="size-4" />
              </Link>
            </Button>
            <Button as-child variant="outline" size="icon" title="Edit">
              <Link :href="edit(technology.id)">
                <Pencil class="size-4" />
              </Link>
            </Button>
            <Button
              variant="destructive"
              size="icon"
              title="Delete"
              @click="handleDelete(technology.id)"
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

import { Link, router } from '@inertiajs/vue3'
import { Eye, Pencil, Trash2 } from 'lucide-vue-next'

import { create, edit, show, destroy } from '@/routes/admin/technologies'

type Technology = {
  id: number
  name: string
  icon: string | null
  color: string | null
  projects_count?: number
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  technologies: Technology[]
}>()

const search = ref('')

const filteredTechnologies = computed(() => {
  const term = search.value.trim().toLowerCase()
  if (!term) {
    return props.technologies
  }

  return props.technologies.filter((technology) =>
    [technology.id, technology.name, technology.icon, technology.color]
      .filter((value) => value !== null && value !== undefined && value !== '')
      .some((value) => String(value).toLowerCase().includes(term)),
  )
})

function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this technology?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>
