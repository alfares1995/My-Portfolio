<template>
<AppLayout>
  <div>
    <h1>Skills</h1>
    <p>This is the Skills page for the admin section.</p>
  </div>

  <div class="my-4">
    <Input v-model="search" placeholder="Search..." />
  </div>

  <div class="my-4">
    <Button as-child>
      <Link :href="create()">Create Skill</Link>
    </Button>
  </div>

  <Table>
    <TableCaption>A list of your skills.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[80px]">
          ID
        </TableHead>
        <TableHead>Name</TableHead>
        <TableHead>Category</TableHead>
        <TableHead>Percentage</TableHead>
        <TableHead>Icon</TableHead>
        <TableHead>Sort Order</TableHead>
        <TableHead class="text-right">
          Actions
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-if="filteredSkills.length === 0">
        <TableCell colspan="7" class="text-center text-muted-foreground">
          No skills found.
        </TableCell>
      </TableRow>
      <TableRow v-for="skill in filteredSkills" :key="skill.id">
        <TableCell class="font-medium">
          {{ skill.id }}
        </TableCell>
        <TableCell>{{ skill.name }}</TableCell>
        <TableCell>
          <Badge variant="secondary">{{ skill.category }}</Badge>
        </TableCell>
        <TableCell>{{ skill.percentage }}%</TableCell>
        <TableCell>
          <span v-if="skill.icon" class="text-sm text-muted-foreground">{{ skill.icon }}</span>
          <span v-else class="text-muted-foreground">—</span>
        </TableCell>
        <TableCell>{{ skill.sort_order }}</TableCell>
        <TableCell class="text-right">
          <div class="flex justify-end gap-2">
            <Button as-child variant="outline" size="icon" title="View">
              <Link :href="show(skill.id)">
                <Eye class="size-4" />
              </Link>
            </Button>
            <Button as-child variant="outline" size="icon" title="Edit">
              <Link :href="edit(skill.id)">
                <Pencil class="size-4" />
              </Link>
            </Button>
            <Button
              variant="destructive"
              size="icon"
              title="Delete"
              @click="handleDelete(skill.id)"
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

import { create, edit, show, destroy } from '@/routes/admin/skills'

type Skill = {
  id: number
  name: string
  percentage: number
  category: 'frontend' | 'backend' | 'devops' | 'database' | 'other'
  icon: string | null
  sort_order: number
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  skills: Skill[]
}>()

const search = ref('')

const filteredSkills = computed(() => {
  const term = search.value.trim().toLowerCase()
  if (!term) {
    return props.skills
  }

  return props.skills.filter((skill) =>
    [skill.id, skill.name, skill.category, skill.icon]
      .filter((value) => value !== null && value !== undefined && value !== '')
      .some((value) => String(value).toLowerCase().includes(term)),
  )
})

function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this skill?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>
