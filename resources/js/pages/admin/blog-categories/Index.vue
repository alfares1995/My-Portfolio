<template>
<AppLayout>
  <div>
    <h1>Blog Categories</h1>
    <p>This is the Blog Categories page for the admin section.</p>
  </div>

  <div class="my-4">
    <Input v-model="search" placeholder="Search..." />
  </div>

  <div class="my-4">
    <Button as-child>
      <Link :href="create()">Create Blog Category</Link>
    </Button>
  </div>

  <Table>
    <TableCaption>A list of your blog categories.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[80px]">
          ID
        </TableHead>
        <TableHead>Name</TableHead>
        <TableHead>Slug</TableHead>
        <TableHead>Posts</TableHead>
        <TableHead>Created At</TableHead>
        <TableHead class="text-right">
          Actions
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-if="filteredBlogCategories.length === 0">
        <TableCell colspan="6" class="text-center text-muted-foreground">
          No blog categories found.
        </TableCell>
      </TableRow>
      <TableRow v-for="blogCategory in filteredBlogCategories" :key="blogCategory.id">
        <TableCell class="font-medium">
          {{ blogCategory.id }}
        </TableCell>
        <TableCell>{{ blogCategory.name }}</TableCell>
        <TableCell>{{ blogCategory.slug }}</TableCell>
        <TableCell>{{ blogCategory.posts_count ?? 0 }}</TableCell>
        <TableCell>{{ blogCategory.created_at ? new Date(blogCategory.created_at).toLocaleDateString() : '—' }}</TableCell>
        <TableCell class="text-right">
          <div class="flex justify-end gap-2">
            <Button as-child variant="outline" size="icon" title="View">
              <Link :href="show(blogCategory.id)">
                <Eye class="size-4" />
              </Link>
            </Button>
            <Button as-child variant="outline" size="icon" title="Edit">
              <Link :href="edit(blogCategory.id)">
                <Pencil class="size-4" />
              </Link>
            </Button>
            <Button
              variant="destructive"
              size="icon"
              title="Delete"
              @click="handleDelete(blogCategory.id)"
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

import { create, edit, show, destroy } from '@/routes/admin/blog-categories'

type BlogCategory = {
  id: number
  name: string
  slug: string
  posts_count?: number
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  blogCategories: BlogCategory[]
}>()

const search = ref('')

const filteredBlogCategories = computed(() => {
  const term = search.value.trim().toLowerCase()
  if (!term) {
    return props.blogCategories
  }

  return props.blogCategories.filter((blogCategory) =>
    [blogCategory.id, blogCategory.name, blogCategory.slug]
      .filter((value) => value !== null && value !== undefined && value !== '')
      .some((value) => String(value).toLowerCase().includes(term)),
  )
})

function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this blog category?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>
