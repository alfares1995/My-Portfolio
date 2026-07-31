<template>
<AppLayout>
  <div>
    <h1>Blog Posts</h1>
    <p>This is the Blog Posts page for the admin section.</p>
  </div>

  <div class="my-4">
    <Input v-model="search" placeholder="Search..." />
  </div>

  <div class="my-4">
    <Button as-child>
      <Link :href="create()">Create Blog Post</Link>
    </Button>
  </div>

  <Table>
    <TableCaption>A list of your blog posts.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[80px]">
          ID
        </TableHead>
        <TableHead>Featured Image</TableHead>
        <TableHead>Title</TableHead>
        <TableHead>Category</TableHead>
        <TableHead>Tags</TableHead>
        <TableHead>Status</TableHead>
        <TableHead>Views</TableHead>
        <TableHead>Published At</TableHead>
        <TableHead>Created At</TableHead>
        <TableHead class="text-right">
          Actions
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-if="filteredBlogPosts.length === 0">
        <TableCell colspan="10" class="text-center text-muted-foreground">
          No blog posts found.
        </TableCell>
      </TableRow>
      <TableRow v-for="blogPost in filteredBlogPosts" :key="blogPost.id">
        <TableCell class="font-medium">
          {{ blogPost.id }}
        </TableCell>
        <TableCell>
          <img
            v-if="blogPost.featured_image_url"
            :src="blogPost.featured_image_url"
            alt="Featured image"
            class="h-12 w-20 rounded object-cover"
          >
          <span v-else class="text-muted-foreground">No image</span>
        </TableCell>
        <TableCell class="max-w-xs truncate">{{ blogPost.title }}</TableCell>
        <TableCell>{{ blogPost.category?.name || '—' }}</TableCell>
        <TableCell>
          <div class="flex flex-wrap gap-1">
            <Badge v-for="tag in blogPost.tags" :key="tag.id" variant="secondary">
              {{ tag.name }}
            </Badge>
            <span v-if="blogPost.tags.length === 0" class="text-muted-foreground">—</span>
          </div>
        </TableCell>
        <TableCell>
          <Badge :variant="blogPost.status === 'published' ? 'default' : 'outline'">
            {{ blogPost.status }}
          </Badge>
        </TableCell>
        <TableCell>{{ blogPost.views }}</TableCell>
        <TableCell>{{ blogPost.published_at ? new Date(blogPost.published_at).toLocaleDateString() : '—' }}</TableCell>
        <TableCell>{{ blogPost.created_at ? new Date(blogPost.created_at).toLocaleDateString() : '—' }}</TableCell>
        <TableCell class="text-right">
          <div class="flex justify-end gap-2">
            <Button as-child variant="outline" size="icon" title="View">
              <Link :href="show(blogPost.id)">
                <Eye class="size-4" />
              </Link>
            </Button>
            <Button as-child variant="outline" size="icon" title="Edit">
              <Link :href="edit(blogPost.id)">
                <Pencil class="size-4" />
              </Link>
            </Button>
            <Button
              variant="destructive"
              size="icon"
              title="Delete"
              @click="handleDelete(blogPost.id)"
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

import { create, edit, show, destroy } from '@/routes/admin/blog-posts'

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

type BlogPost = {
  id: number
  category_id: number | null
  category: BlogCategory | null
  title: string
  slug: string
  excerpt: string
  content: string
  featured_image: string | null
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
  blogPosts: BlogPost[]
}>()

const search = ref('')

const filteredBlogPosts = computed(() => {
  const term = search.value.trim().toLowerCase()
  if (!term) {
    return props.blogPosts
  }

  return props.blogPosts.filter((blogPost) =>
    [
      blogPost.id,
      blogPost.title,
      blogPost.slug,
      blogPost.excerpt,
      blogPost.status,
      blogPost.category?.name,
      ...blogPost.tags.map((tag) => tag.name),
    ]
      .filter((value) => value !== null && value !== undefined && value !== '')
      .some((value) => String(value).toLowerCase().includes(term)),
  )
})

function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this blog post?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>
