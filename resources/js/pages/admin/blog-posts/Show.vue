<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { edit, index } from '@/routes/admin/blog-posts'

type BlogCategory = {
  id: number
  name: string
  slug: string
}

type BlogTag = {
  id: number
  name: string
  slug: string
}

type BlogPostRecord = {
  id: number
  category: BlogCategory | null
  title: string
  slug: string
  excerpt: string
  content: string
  featured_image_url: string | null
  published_at: string | null
  status: 'draft' | 'published'
  views: number
  seo_title: string | null
  seo_description: string | null
  tags: BlogTag[]
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  blogPost: BlogPostRecord
}>()
</script>

<template>
  <Head :title="`Blog Post: ${props.blogPost.title}`" />

  <AppLayout>
    <div class="space-y-4">
      <div class="flex items-center justify-between">
        <h1>{{ props.blogPost.title }}</h1>
        <div class="flex gap-2">
          <Button as-child variant="outline">
            <Link :href="index()">Back to list</Link>
          </Button>
          <Button as-child>
            <Link :href="edit(props.blogPost.id)">Edit</Link>
          </Button>
        </div>
      </div>

      <img
        v-if="props.blogPost.featured_image_url"
        :src="props.blogPost.featured_image_url"
        alt="Featured image"
        class="h-48 w-full max-w-md rounded object-cover"
      >

      <div class="flex flex-wrap items-center gap-2">
        <Badge :variant="props.blogPost.status === 'published' ? 'default' : 'outline'">
          {{ props.blogPost.status }}
        </Badge>
        <Badge v-for="tag in props.blogPost.tags" :key="tag.id" variant="secondary">
          {{ tag.name }}
        </Badge>
      </div>

      <p><strong>Slug:</strong> {{ props.blogPost.slug }}</p>
      <p><strong>Category:</strong> {{ props.blogPost.category?.name ?? '—' }}</p>
      <p><strong>Views:</strong> {{ props.blogPost.views }}</p>
      <p><strong>Published At:</strong> {{ props.blogPost.published_at ? new Date(props.blogPost.published_at).toLocaleString() : '—' }}</p>
      <p><strong>Excerpt:</strong> {{ props.blogPost.excerpt }}</p>

      <div>
        <strong>Content:</strong>
        <p class="whitespace-pre-wrap">{{ props.blogPost.content }}</p>
      </div>

      <p><strong>SEO Title:</strong> {{ props.blogPost.seo_title ?? '—' }}</p>
      <p><strong>SEO Description:</strong> {{ props.blogPost.seo_description ?? '—' }}</p>

      <p><strong>Created At:</strong> {{ props.blogPost.created_at ? new Date(props.blogPost.created_at).toLocaleString() : '—' }}</p>
      <p><strong>Updated At:</strong> {{ props.blogPost.updated_at ? new Date(props.blogPost.updated_at).toLocaleString() : '—' }}</p>
    </div>
  </AppLayout>
</template>
