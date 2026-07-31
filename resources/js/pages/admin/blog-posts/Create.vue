<template>
<AppLayout>
  <div>
    <h1>Create Blog Post</h1>
    <p>This is the Create Blog Post page for the admin section.</p>
  </div>
  <div class="my-4">
    <Form
      @submit="onSubmit"
      class="space-y-6"
      :validation-schema="formSchema"
      :initial-values="{ status: 'draft', category_id: 'none' }"
    >
      <FormField v-slot="{ componentField }" name="title">
        <FormItem>
          <FormLabel>Title</FormLabel>
          <FormControl>
            <Input placeholder="Enter title..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="slug">
        <FormItem>
          <FormLabel>Slug</FormLabel>
          <FormControl>
            <Input placeholder="Enter slug..." v-bind="componentField" />
          </FormControl>
          <FormDescription>Leave blank to auto-generate from the title.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="category_id">
        <FormItem>
          <FormLabel>Category</FormLabel>
          <Select v-bind="componentField">
            <FormControl>
              <SelectTrigger class="w-full">
                <SelectValue placeholder="Select a category" />
              </SelectTrigger>
            </FormControl>
            <SelectContent>
              <SelectItem value="none">
                No category
              </SelectItem>
              <SelectItem v-for="category in categories" :key="category.id" :value="String(category.id)">
                {{ category.name }}
              </SelectItem>
            </SelectContent>
          </Select>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="excerpt">
        <FormItem>
          <FormLabel>Excerpt</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter a short excerpt..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="content">
        <FormItem>
          <FormLabel>Content</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter the full post content..." rows="10" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ handleChange, handleBlur }" name="featured_image">
        <FormItem>
          <FormLabel>Featured Image</FormLabel>
          <FormControl>
            <Input
              type="file"
              accept="image/*"
              @change="(e: Event) => handleChange((e.target as HTMLInputElement).files?.[0] ?? null)"
              @blur="handleBlur"
            />
          </FormControl>
          <FormDescription>Upload a featured image (jpeg, png, jpg, gif, svg).</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <FormField v-slot="{ componentField }" name="published_at">
          <FormItem>
            <FormLabel>Published At</FormLabel>
            <FormControl>
              <Input type="datetime-local" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="status">
          <FormItem>
            <FormLabel>Status</FormLabel>
            <Select v-bind="componentField">
              <FormControl>
                <SelectTrigger class="w-full">
                  <SelectValue placeholder="Select status" />
                </SelectTrigger>
              </FormControl>
              <SelectContent>
                <SelectItem value="draft">
                  Draft
                </SelectItem>
                <SelectItem value="published">
                  Published
                </SelectItem>
              </SelectContent>
            </Select>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

      <FormField v-slot="{ value, handleChange }" name="tags">
        <FormItem>
          <FormLabel>Tags</FormLabel>
          <div class="flex flex-wrap gap-4">
            <label v-for="tag in tags" :key="tag.id" class="flex items-center gap-2 text-sm">
              <Checkbox
                :model-value="((value as number[] | undefined) ?? []).includes(tag.id)"
                @update:model-value="(checked) => handleChange(checked
                  ? [...((value as number[] | undefined) ?? []), tag.id]
                  : ((value as number[] | undefined) ?? []).filter((id: number) => id !== tag.id))"
              />
              {{ tag.name }}
            </label>
            <span v-if="tags.length === 0" class="text-sm text-muted-foreground">No tags available.</span>
          </div>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="seo_title">
        <FormItem>
          <FormLabel>SEO Title</FormLabel>
          <FormControl>
            <Input placeholder="Enter SEO title..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="seo_description">
        <FormItem>
          <FormLabel>SEO Description</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter SEO description..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <Button type="submit" :disabled="processing">Submit</Button>
    </Form>
  </div>
</AppLayout>
</template>

<script setup lang="ts">
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { toTypedSchema } from '@vee-validate/zod'
import { z } from 'zod'
import { store } from '@/routes/admin/blog-posts'

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

const props = defineProps<{
  categories: BlogCategory[]
  tags: BlogTag[]
}>()

const processing = ref(false)

const imageField = z
  .instanceof(File)
  .nullable()
  .optional()
  .refine((file) => !file || file.size <= 2048 * 1024, 'Image must not exceed 2MB')
  .refine((file) => !file || file.type.startsWith('image/'), 'File must be an image')

const formSchema = toTypedSchema(
  z.object({
    category_id: z.string().optional(),
    title: z.string().min(1, 'Title is required').max(255),
    slug: z.union([z.string().max(255), z.literal('')]).optional(),
    excerpt: z.string().min(1, 'Excerpt is required'),
    content: z.string().min(1, 'Content is required'),
    featured_image: imageField,
    published_at: z.union([z.string(), z.literal('')]).optional(),
    status: z.enum(['draft', 'published']),
    seo_title: z.union([z.string().max(255), z.literal('')]).optional(),
    seo_description: z.union([z.string(), z.literal('')]).optional(),
    tags: z.array(z.number()).optional(),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true

  const payload = {
    ...values,
    category_id: values.category_id && values.category_id !== 'none' ? Number(values.category_id) : null,
    published_at: values.published_at || null,
    tags: values.tags ?? [],
  }

  router.post(store.url(), payload, {
    forceFormData: true,
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>
