<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { edit, index } from '@/routes/admin/educations'

type EducationRecord = {
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
  education: EducationRecord
}>()
</script>

<template>
  <Head :title="`Education: ${props.education.institution}`" />

  <AppLayout>
    <div class="space-y-4">
      <div class="flex items-center justify-between">
        <h1>{{ props.education.institution }}</h1>
        <div class="flex gap-2">
          <Button as-child variant="outline">
            <Link :href="index()">Back to list</Link>
          </Button>
          <Button as-child>
            <Link :href="edit(props.education.id)">Edit</Link>
          </Button>
        </div>
      </div>

      <p><strong>Degree:</strong> {{ props.education.degree }}</p>
      <p><strong>Field of Study:</strong> {{ props.education.field }}</p>
      <p><strong>Start Date:</strong> {{ new Date(props.education.start_date).toLocaleDateString() }}</p>
      <p><strong>End Date:</strong> {{ props.education.end_date ? new Date(props.education.end_date).toLocaleDateString() : 'Present' }}</p>

      <div v-if="props.education.description">
        <strong>Description:</strong>
        <p class="whitespace-pre-wrap">{{ props.education.description }}</p>
      </div>

      <p><strong>Created At:</strong> {{ props.education.created_at ? new Date(props.education.created_at).toLocaleString() : '—' }}</p>
      <p><strong>Updated At:</strong> {{ props.education.updated_at ? new Date(props.education.updated_at).toLocaleString() : '—' }}</p>
    </div>
  </AppLayout>
</template>
