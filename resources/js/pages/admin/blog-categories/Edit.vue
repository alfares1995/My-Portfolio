<template>
<Head :title="`Edit Blog Category: ${blogCategory.name}`" />

<AppLayout>
  <div>
    <h1>Edit Blog Category</h1>
    <p>This is the Edit Blog Category page for the admin section.</p>
  </div>

  <div class="my-4">
    <Form
      @submit="onSubmit"
      class="space-y-6"
      :validation-schema="formSchema"
      :initial-values="initialValues"
    >
      <FormField v-slot="{ componentField }" name="name">
        <FormItem>
          <FormLabel>Name</FormLabel>
          <FormControl>
            <Input placeholder="Enter name..." v-bind="componentField" />
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
          <FormDescription>Leave blank to auto-generate from the name.</FormDescription>
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
import { Button } from '@/components/ui/button'
import { computed, ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { toTypedSchema } from '@vee-validate/zod'
import { z } from 'zod'
import { update } from '@/routes/admin/blog-categories'

type BlogCategoryRecord = {
  id: number
  name: string
  slug: string
}

const props = defineProps<{
  blogCategory: BlogCategoryRecord
}>()

const processing = ref(false)

const initialValues = computed(() => ({
  name: props.blogCategory.name ?? '',
  slug: props.blogCategory.slug ?? '',
}))

const formSchema = toTypedSchema(
  z.object({
    name: z.string().min(1, 'Name is required').max(255),
    slug: z.union([z.string().max(255), z.literal('')]).optional(),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true

  const { action } = update.form(props.blogCategory.id)
  router.post(action, values, {
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>
