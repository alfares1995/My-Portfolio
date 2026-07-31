<template>
<AppLayout>
  <div>
    <h1>Create Skill</h1>
    <p>This is the Create Skill page for the admin section.</p>
  </div>

  <div class="my-4">
    <Form
      @submit="onSubmit"
      class="space-y-6"
      :validation-schema="formSchema"
      :initial-values="{ category: 'frontend', sort_order: 0 }"
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

      <FormField v-slot="{ componentField }" name="category">
        <FormItem>
          <FormLabel>Category</FormLabel>
          <Select v-bind="componentField">
            <FormControl>
              <SelectTrigger class="w-full">
                <SelectValue placeholder="Select a category" />
              </SelectTrigger>
            </FormControl>
            <SelectContent>
              <SelectItem value="frontend">Frontend</SelectItem>
              <SelectItem value="backend">Backend</SelectItem>
              <SelectItem value="devops">DevOps</SelectItem>
              <SelectItem value="database">Database</SelectItem>
              <SelectItem value="other">Other</SelectItem>
            </SelectContent>
          </Select>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="percentage">
        <FormItem>
          <FormLabel>Percentage</FormLabel>
          <FormControl>
            <Input type="number" min="0" max="100" placeholder="0-100" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="icon">
        <FormItem>
          <FormLabel>Icon</FormLabel>
          <FormControl>
            <Input placeholder="e.g. devicon-vuejs-plain" v-bind="componentField" />
          </FormControl>
          <FormDescription>Optional icon name/class used to render the skill's icon.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="sort_order">
        <FormItem>
          <FormLabel>Sort Order</FormLabel>
          <FormControl>
            <Input type="number" min="0" v-bind="componentField" />
          </FormControl>
          <FormDescription>Lower numbers appear first.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <Button type="submit" :disabled="processing">Create Skill</Button>
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
import { store } from '@/routes/admin/skills'

const processing = ref(false)

const formSchema = toTypedSchema(
  z.object({
    name: z.string().min(1, 'Name is required').max(255),
    category: z.enum(['frontend', 'backend', 'devops', 'database', 'other']),
    percentage: z.coerce.number().int().min(0).max(100),
    icon: z.union([z.string().max(255), z.literal('')]).optional(),
    sort_order: z.coerce.number().int().min(0).optional(),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true

  const payload = {
    ...values,
    icon: values.icon || null,
    sort_order: values.sort_order ?? 0,
  }

  router.post(store.url(), payload, {
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>
