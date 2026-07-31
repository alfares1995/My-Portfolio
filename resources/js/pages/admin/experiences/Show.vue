<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { edit, index } from '@/routes/admin/experiences'

type ExperienceRecord = {
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
  experience: ExperienceRecord
}>()
</script>

<template>
  <Head :title="`Experience: ${props.experience.company}`" />

  <AppLayout>
    <div class="space-y-4">
      <div class="flex items-center justify-between">
        <h1>{{ props.experience.role }} at {{ props.experience.company }}</h1>
        <div class="flex gap-2">
          <Button as-child variant="outline">
            <Link :href="index()">Back to list</Link>
          </Button>
          <Button as-child>
            <Link :href="edit(props.experience.id)">Edit</Link>
          </Button>
        </div>
      </div>

      <div class="flex flex-wrap items-center gap-2">
        <Badge variant="secondary">{{ props.experience.employment_type }}</Badge>
        <Badge v-if="props.experience.currently_working" variant="default">Currently Working</Badge>
      </div>

      <p><strong>Location:</strong> {{ props.experience.location ?? '—' }}</p>
      <p><strong>Start Date:</strong> {{ new Date(props.experience.start_date).toLocaleDateString() }}</p>
      <p><strong>End Date:</strong> {{ props.experience.currently_working ? 'Present' : (props.experience.end_date ? new Date(props.experience.end_date).toLocaleDateString() : '—') }}</p>

      <div>
        <strong>Description:</strong>
        <p class="whitespace-pre-wrap">{{ props.experience.description }}</p>
      </div>

      <p><strong>Created At:</strong> {{ props.experience.created_at ? new Date(props.experience.created_at).toLocaleString() : '—' }}</p>
      <p><strong>Updated At:</strong> {{ props.experience.updated_at ? new Date(props.experience.updated_at).toLocaleString() : '—' }}</p>
    </div>
  </AppLayout>
</template>
