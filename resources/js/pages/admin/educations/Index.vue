<template>
<AppLayout>
  <div>
    <h1>Educations</h1>
    <p>This is the Educations page for the admin section.</p>
  </div>

  <div class="my-4">
    <Input v-model="search" placeholder="Search..." />
  </div>

  <div class="my-4">
    <Button as-child>
      <Link :href="create()">Create Education</Link>
    </Button>
  </div>

  <Table>
    <TableCaption>A list of your educations.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[80px]">
          ID
        </TableHead>
        <TableHead>Institution</TableHead>
        <TableHead>Degree</TableHead>
        <TableHead>Field</TableHead>
        <TableHead>Start Date</TableHead>
        <TableHead>End Date</TableHead>
        <TableHead class="text-right">
          Actions
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-if="filteredEducations.length === 0">
        <TableCell colspan="7" class="text-center text-muted-foreground">
          No educations found.
        </TableCell>
      </TableRow>
      <TableRow v-for="education in filteredEducations" :key="education.id">
        <TableCell class="font-medium">
          {{ education.id }}
        </TableCell>
        <TableCell>{{ education.institution }}</TableCell>
        <TableCell>{{ education.degree }}</TableCell>
        <TableCell>{{ education.field }}</TableCell>
        <TableCell>{{ new Date(education.start_date).toLocaleDateString() }}</TableCell>
        <TableCell>{{ education.end_date ? new Date(education.end_date).toLocaleDateString() : 'Present' }}</TableCell>
        <TableCell class="text-right">
          <div class="flex justify-end gap-2">
            <Button as-child variant="outline" size="icon" title="View">
              <Link :href="show(education.id)">
                <Eye class="size-4" />
              </Link>
            </Button>
            <Button as-child variant="outline" size="icon" title="Edit">
              <Link :href="edit(education.id)">
                <Pencil class="size-4" />
              </Link>
            </Button>
            <Button
              variant="destructive"
              size="icon"
              title="Delete"
              @click="handleDelete(education.id)"
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

import { create, edit, show, destroy } from '@/routes/admin/educations'

type Education = {
  id: number
  institution: string
  degree: string
  field: string
  start_date: string
  end_date: string | null
  description: string | null
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  educations: Education[]
}>()

const search = ref('')

const filteredEducations = computed(() => {
  const term = search.value.trim().toLowerCase()
  if (!term) {
    return props.educations
  }

  return props.educations.filter((education) =>
    [education.id, education.institution, education.degree, education.field]
      .filter((value) => value !== null && value !== undefined && value !== '')
      .some((value) => String(value).toLowerCase().includes(term)),
  )
})

function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this education?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>
