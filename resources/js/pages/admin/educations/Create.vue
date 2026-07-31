<template>
<AppLayout>
  <div>
    <h1>Create Education</h1>
    <p>This is the Create Education page for the admin section.</p>
  </div>

  <div class="my-4">
    <Form
      @submit="onSubmit"
      class="space-y-6"
      :validation-schema="formSchema"
    >
      <FormField v-slot="{ componentField }" name="institution">
        <FormItem>
          <FormLabel>Institution</FormLabel>
          <FormControl>
            <Input placeholder="Enter institution..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="degree">
        <FormItem>
          <FormLabel>Degree</FormLabel>
          <FormControl>
            <Input placeholder="Enter degree..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="field">
        <FormItem>
          <FormLabel>Field of Study</FormLabel>
          <FormControl>
            <Input placeholder="Enter field of study..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <FormField v-slot="{ componentField }" name="start_date">
          <FormItem>
            <FormLabel>Start Date</FormLabel>
            <FormControl>
              <Input type="date" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="end_date">
          <FormItem>
            <FormLabel>End Date</FormLabel>
            <FormControl>
              <Input type="date" v-bind="componentField" />
            </FormControl>
            <FormDescription>Leave blank if currently ongoing.</FormDescription>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

      <FormField v-slot="{ componentField }" name="description">
        <FormItem>
          <FormLabel>Description</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter a description..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <Button type="submit" :disabled="processing">Create Education</Button>
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
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { toTypedSchema } from '@vee-validate/zod'
import { z } from 'zod'
import { store } from '@/routes/admin/educations'

const processing = ref(false)

const formSchema = toTypedSchema(
  z.object({
    institution: z.string().min(1, 'Institution is required').max(255),
    degree: z.string().min(1, 'Degree is required').max(255),
    field: z.string().min(1, 'Field of study is required').max(255),
    start_date: z.string().min(1, 'Start date is required'),
    end_date: z.union([z.string(), z.literal('')]).optional(),
    description: z.union([z.string(), z.literal('')]).optional(),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true

  const payload = {
    ...values,
    end_date: values.end_date || null,
    description: values.description || null,
  }

  router.post(store.url(), payload, {
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>
