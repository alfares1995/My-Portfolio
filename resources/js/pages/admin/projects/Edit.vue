<template>
<Head :title="`Edit Project: ${project.title}`" />

<AppLayout>
  <div>
    <h1>Edit Project</h1>
    <p>This is the Edit Project page for the admin section.</p>
  </div>
  <div class="my-4">
    <Form
      @submit="onSubmit"
      class="space-y-6"
      :validation-schema="formSchema"
      :initial-values="initialValues"
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

      <FormField v-slot="{ componentField }" name="short_description">
        <FormItem>
          <FormLabel>Short Description</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter a short description..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="description">
        <FormItem>
          <FormLabel>Description</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter the full description..." rows="10" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ handleChange, handleBlur }" name="thumbnail">
        <FormItem>
          <FormLabel>Thumbnail</FormLabel>
          <img
            v-if="project.thumbnail_url"
            :src="project.thumbnail_url"
            alt="Current thumbnail"
            class="mb-2 h-16 w-32 rounded object-cover"
          >
          <FormControl>
            <Input
              type="file"
              accept="image/*"
              @change="(e: Event) => handleChange((e.target as HTMLInputElement).files?.[0] ?? null)"
              @blur="handleBlur"
            />
          </FormControl>
          <FormDescription>Upload a new thumbnail to replace the current one (jpeg, png, jpg, gif, svg).</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormItem v-if="project.images.length > 0">
        <FormLabel>Existing Gallery Images</FormLabel>
        <div class="flex flex-wrap gap-4">
          <label v-for="image in project.images" :key="image.id" class="relative flex flex-col items-center gap-1 text-sm">
            <img :src="image.image_url ?? ''" alt="Gallery image" class="h-20 w-28 rounded object-cover">
            <span class="flex items-center gap-1">
              <Checkbox
                :model-value="deleteImageIds.includes(image.id)"
                @update:model-value="(checked) => toggleDeleteImage(image.id, checked)"
              />
              Delete
            </span>
          </label>
        </div>
      </FormItem>

      <FormField v-slot="{ handleChange, handleBlur }" name="images">
        <FormItem>
          <FormLabel>Add Gallery Images</FormLabel>
          <FormControl>
            <Input
              type="file"
              accept="image/*"
              multiple
              @change="(e: Event) => handleChange(Array.from((e.target as HTMLInputElement).files ?? []))"
              @blur="handleBlur"
            />
          </FormControl>
          <FormDescription>Upload one or more new gallery images.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <FormField v-slot="{ componentField }" name="github_url">
          <FormItem>
            <FormLabel>GitHub URL</FormLabel>
            <FormControl>
              <Input placeholder="https://github.com/..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="live_url">
          <FormItem>
            <FormLabel>Live URL</FormLabel>
            <FormControl>
              <Input placeholder="https://..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <FormField v-slot="{ componentField }" name="completion_date">
          <FormItem>
            <FormLabel>Completion Date</FormLabel>
            <FormControl>
              <Input type="date" v-bind="componentField" />
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

      <FormField v-slot="{ value, handleChange }" name="featured">
        <FormItem class="flex flex-row items-center gap-2">
          <FormControl>
            <Checkbox :model-value="value" @update:model-value="handleChange" />
          </FormControl>
          <FormLabel class="!mt-0">Featured</FormLabel>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ value, handleChange }" name="technologies">
        <FormItem>
          <FormLabel>Technologies</FormLabel>
          <div class="flex flex-wrap gap-4">
            <label v-for="technology in technologies" :key="technology.id" class="flex items-center gap-2 text-sm">
              <Checkbox
                :model-value="((value as number[] | undefined) ?? []).includes(technology.id)"
                @update:model-value="(checked) => handleChange(checked
                  ? [...((value as number[] | undefined) ?? []), technology.id]
                  : ((value as number[] | undefined) ?? []).filter((id: number) => id !== technology.id))"
              />
              {{ technology.name }}
            </label>
            <span v-if="technologies.length === 0" class="text-sm text-muted-foreground">No technologies available.</span>
          </div>
          <FormMessage />
        </FormItem>
      </FormField>

      <Button type="submit" :disabled="processing">Save Changes</Button>
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
import { computed, ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { toTypedSchema } from '@vee-validate/zod'
import { z } from 'zod'
import { update } from '@/routes/admin/projects'

type Technology = {
  id: number
  name: string
  icon: string | null
  color: string | null
}

type ProjectImage = {
  id: number
  image_url: string | null
  caption: string | null
  sort_order: number
}

type ProjectRecord = {
  id: number
  title: string
  slug: string
  short_description: string
  description: string
  thumbnail_url: string | null
  github_url: string | null
  live_url: string | null
  featured: boolean
  status: 'draft' | 'published'
  completion_date: string | null
  technologies: Technology[]
  images: ProjectImage[]
}

const props = defineProps<{
  project: ProjectRecord
  technologies: Technology[]
}>()

const processing = ref(false)
const deleteImageIds = ref<number[]>([])

function toggleDeleteImage(id: number, checked: boolean) {
  deleteImageIds.value = checked
    ? [...deleteImageIds.value, id]
    : deleteImageIds.value.filter((imageId) => imageId !== id)
}

const initialValues = computed(() => ({
  title: props.project.title ?? '',
  slug: props.project.slug ?? '',
  short_description: props.project.short_description ?? '',
  description: props.project.description ?? '',
  github_url: props.project.github_url ?? '',
  live_url: props.project.live_url ?? '',
  completion_date: props.project.completion_date ?? '',
  status: props.project.status ?? 'draft',
  featured: props.project.featured ?? false,
  technologies: props.project.technologies.map((technology) => technology.id),
}))

const imageField = z
  .instanceof(File)
  .nullable()
  .optional()
  .refine((file) => !file || file.size <= 2048 * 1024, 'Image must not exceed 2MB')
  .refine((file) => !file || file.type.startsWith('image/'), 'File must be an image')

const formSchema = toTypedSchema(
  z.object({
    title: z.string().min(1, 'Title is required').max(255),
    slug: z.union([z.string().max(255), z.literal('')]).optional(),
    short_description: z.string().min(1, 'Short description is required'),
    description: z.string().min(1, 'Description is required'),
    thumbnail: imageField,
    images: z.array(z.instanceof(File)).optional(),
    github_url: z.union([z.string().url('Must be a valid URL').max(255), z.literal('')]).optional(),
    live_url: z.union([z.string().url('Must be a valid URL').max(255), z.literal('')]).optional(),
    completion_date: z.union([z.string(), z.literal('')]).optional(),
    status: z.enum(['draft', 'published']),
    featured: z.boolean().optional(),
    technologies: z.array(z.number()).optional(),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true

  const payload = {
    ...values,
    github_url: values.github_url || null,
    live_url: values.live_url || null,
    completion_date: values.completion_date || null,
    featured: values.featured ?? false,
    technologies: values.technologies ?? [],
    images: values.images ?? [],
    delete_images: deleteImageIds.value,
  }

  const { action } = update.form(props.project.id)
  router.post(action, payload, {
    forceFormData: true,
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>
