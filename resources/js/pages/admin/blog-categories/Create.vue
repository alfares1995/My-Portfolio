<template>
<AppLayout>
  <div>
    <h1>Create Blog Category</h1>
    <p>This is the Create Blog Category page for the admin section.</p>
  </div>

  <div class="my-4">
    <Form
      @submit="onSubmit"
      class="space-y-6"
      :validation-schema="formSchema"
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

      <Button type="submit" :disabled="processing">Create Blog Category</Button>
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
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { toTypedSchema } from '@vee-validate/zod'
import { z } from 'zod'
import { store } from '@/routes/admin/blog-categories'

const processing = ref(false)

const formSchema = toTypedSchema(
  z.object({
    name: z.string().min(1, 'Name is required').max(255),
    slug: z.union([z.string().max(255), z.literal('')]).optional(),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true

  router.post(store.url(), values, {
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>
