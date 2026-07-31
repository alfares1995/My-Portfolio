<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { edit, index } from '@/routes/admin/skills'

type SkillRecord = {
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
  skill: SkillRecord
}>()
</script>

<template>
  <Head :title="`Skill: ${props.skill.name}`" />

  <AppLayout>
    <div class="space-y-4">
      <div class="flex items-center justify-between">
        <h1>{{ props.skill.name }}</h1>
        <div class="flex gap-2">
          <Button as-child variant="outline">
            <Link :href="index()">Back to list</Link>
          </Button>
          <Button as-child>
            <Link :href="edit(props.skill.id)">Edit</Link>
          </Button>
        </div>
      </div>

      <Badge variant="secondary">{{ props.skill.category }}</Badge>

      <p><strong>Percentage:</strong> {{ props.skill.percentage }}%</p>
      <p><strong>Icon:</strong> {{ props.skill.icon ?? '—' }}</p>
      <p><strong>Sort Order:</strong> {{ props.skill.sort_order }}</p>
      <p><strong>Created At:</strong> {{ props.skill.created_at ? new Date(props.skill.created_at).toLocaleString() : '—' }}</p>
      <p><strong>Updated At:</strong> {{ props.skill.updated_at ? new Date(props.skill.updated_at).toLocaleString() : '—' }}</p>
    </div>
  </AppLayout>
</template>
