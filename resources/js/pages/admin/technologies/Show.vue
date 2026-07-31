<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { edit, index } from '@/routes/admin/technologies'

type TechnologyRecord = {
  id: number
  name: string
  icon: string | null
  color: string | null
  projects_count?: number
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  technology: TechnologyRecord
}>()
</script>

<template>
  <Head :title="`Technology: ${props.technology.name}`" />

  <AppLayout>
    <div class="space-y-4">
      <div class="flex items-center justify-between">
        <h1>{{ props.technology.name }}</h1>
        <div class="flex gap-2">
          <Button as-child variant="outline">
            <Link :href="index()">Back to list</Link>
          </Button>
          <Button as-child>
            <Link :href="edit(props.technology.id)">Edit</Link>
          </Button>
        </div>
      </div>

      <div v-if="props.technology.color" class="flex items-center gap-2">
        <span class="size-6 rounded-full border" :style="{ backgroundColor: props.technology.color }" />
        {{ props.technology.color }}
      </div>

      <p><strong>Icon:</strong> {{ props.technology.icon ?? '—' }}</p>
      <p><strong>Projects:</strong> {{ props.technology.projects_count ?? 0 }}</p>
      <p><strong>Created At:</strong> {{ props.technology.created_at ? new Date(props.technology.created_at).toLocaleString() : '—' }}</p>
      <p><strong>Updated At:</strong> {{ props.technology.updated_at ? new Date(props.technology.updated_at).toLocaleString() : '—' }}</p>
    </div>
  </AppLayout>
</template>
