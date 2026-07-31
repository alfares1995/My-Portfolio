<template>
<AppLayout>
  <div>
    <h1>Create Technology</h1>
    <p>This is the Create Technology page for the admin section.</p>
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

      <FormField v-slot="{ componentField }" name="icon">
        <FormItem>
          <FormLabel>Icon</FormLabel>
          <FormControl>
            <Input placeholder="e.g. devicon-laravel-plain" v-bind="componentField" />
          </FormControl>
          <FormDescription>Optional icon name/class used to render the technology's icon.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="color">
        <FormItem>
          <FormLabel>Color</FormLabel>
          <FormControl>
            <Input type="color" class="h-10 w-20 p-1" v-bind="componentField" />
          </FormControl>
          <FormDescription>Optional brand color used for badges.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <Button type="submit" :disabled="processing">Create Technology</Button>
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
import { store } from '@/routes/admin/technologies'

const processing = ref(false)

const formSchema = toTypedSchema(
  z.object({
    name: z.string().min(1, 'Name is required').max(255),
    icon: z.union([z.string().max(255), z.literal('')]).optional(),
    color: z.union([z.string().max(255), z.literal('')]).optional(),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true

  const payload = {
    ...values,
    icon: values.icon || null,
    color: values.color || null,
  }

  router.post(store.url(), payload, {
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>
