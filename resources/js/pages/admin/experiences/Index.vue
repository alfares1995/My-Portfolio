<template>
<AppLayout>
  <div>
    <h1>Experiences</h1>
    <p>This is the Experiences page for the admin section.</p>
  </div>

  <div class="my-4">
    <Input v-model="search" placeholder="Search..." />
  </div>

  <div class="my-4">
    <Button as-child>
      <Link :href="create()">Create Experience</Link>
    </Button>
  </div>

  <Table>
    <TableCaption>A list of your experiences.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[80px]">
          ID
        </TableHead>
        <TableHead>Company</TableHead>
        <TableHead>Role</TableHead>
        <TableHead>Type</TableHead>
        <TableHead>Location</TableHead>
        <TableHead>Start Date</TableHead>
        <TableHead>End Date</TableHead>
        <TableHead class="text-right">
          Actions
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-if="filteredExperiences.length === 0">
        <TableCell colspan="8" class="text-center text-muted-foreground">
          No experiences found.
        </TableCell>
      </TableRow>
      <TableRow v-for="experience in filteredExperiences" :key="experience.id">
        <TableCell class="font-medium">
          {{ experience.id }}
        </TableCell>
        <TableCell>{{ experience.company }}</TableCell>
        <TableCell>{{ experience.role }}</TableCell>
        <TableCell>
          <Badge variant="secondary">{{ experience.employment_type }}</Badge>
        </TableCell>
        <TableCell>{{ experience.location ?? '—' }}</TableCell>
        <TableCell>{{ new Date(experience.start_date).toLocaleDateString() }}</TableCell>
        <TableCell>
          <Badge v-if="experience.currently_working" variant="default">Present</Badge>
          <span v-else>{{ experience.end_date ? new Date(experience.end_date).toLocaleDateString() : '—' }}</span>
        </TableCell>
        <TableCell class="text-right">
          <div class="flex justify-end gap-2">
            <Button as-child variant="outline" size="icon" title="View">
              <Link :href="show(experience.id)">
                <Eye class="size-4" />
              </Link>
            </Button>
            <Button as-child variant="outline" size="icon" title="Edit">
              <Link :href="edit(experience.id)">
                <Pencil class="size-4" />
              </Link>
            </Button>
            <Button
              variant="destructive"
              size="icon"
              title="Delete"
              @click="handleDelete(experience.id)"
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

import { create, edit, show, destroy } from '@/routes/admin/experiences'

type Experience = {
  id: number
  company: string
  role: string
  location: string | null
  employment_type: string
  start_date: string
  end_date: string | null
  currently_working: boolean
  description: string
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  experiences: Experience[]
}>()

const search = ref('')

const filteredExperiences = computed(() => {
  const term = search.value.trim().toLowerCase()
  if (!term) {
    return props.experiences
  }

  return props.experiences.filter((experience) =>
    [experience.id, experience.company, experience.role, experience.employment_type, experience.location]
      .filter((value) => value !== null && value !== undefined && value !== '')
      .some((value) => String(value).toLowerCase().includes(term)),
  )
})

function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this experience?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>
