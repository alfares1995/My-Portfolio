<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { edit, index } from '@/routes/admin/blog-categories'

type BlogCategoryRecord = {
  id: number
  name: string
  slug: string
  posts_count?: number
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  blogCategory: BlogCategoryRecord
}>()
</script>

<template>
  <Head :title="`Blog Category: ${props.blogCategory.name}`" />

  <AppLayout>
    <div class="space-y-4">
      <div class="flex items-center justify-between">
        <h1>{{ props.blogCategory.name }}</h1>
        <div class="flex gap-2">
          <Button as-child variant="outline">
            <Link :href="index()">Back to list</Link>
          </Button>
          <Button as-child>
            <Link :href="edit(props.blogCategory.id)">Edit</Link>
          </Button>
        </div>
      </div>

      <p><strong>Slug:</strong> {{ props.blogCategory.slug }}</p>
      <p><strong>Posts:</strong> {{ props.blogCategory.posts_count ?? 0 }}</p>
      <p><strong>Created At:</strong> {{ props.blogCategory.created_at ? new Date(props.blogCategory.created_at).toLocaleString() : '—' }}</p>
      <p><strong>Updated At:</strong> {{ props.blogCategory.updated_at ? new Date(props.blogCategory.updated_at).toLocaleString() : '—' }}</p>
    </div>
  </AppLayout>
</template>
