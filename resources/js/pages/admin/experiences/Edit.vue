<template>
<Head :title="`Edit Experience: ${experience.company}`" />

<AppLayout>
  <div>
    <h1>Edit Experience</h1>
    <p>This is the Edit Experience page for the admin section.</p>
  </div>

  <div class="my-4">
    <Form
      @submit="onSubmit"
      class="space-y-6"
      :validation-schema="formSchema"
      :initial-values="initialValues"
    >
      <FormField v-slot="{ componentField }" name="company">
        <FormItem>
          <FormLabel>Company</FormLabel>
          <FormControl>
            <Input placeholder="Enter company..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="role">
        <FormItem>
          <FormLabel>Role</FormLabel>
          <FormControl>
            <Input placeholder="Enter role..." v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <FormField v-slot="{ componentField }" name="location">
          <FormItem>
            <FormLabel>Location</FormLabel>
            <FormControl>
              <Input placeholder="Enter location..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="employment_type">
          <FormItem>
            <FormLabel>Employment Type</FormLabel>
            <Select v-bind="componentField">
              <FormControl>
                <SelectTrigger class="w-full">
                  <SelectValue placeholder="Select employment type" />
                </SelectTrigger>
              </FormControl>
              <SelectContent>
                <SelectItem value="Full-time">Full-time</SelectItem>
                <SelectItem value="Part-time">Part-time</SelectItem>
                <SelectItem value="Contract">Contract</SelectItem>
                <SelectItem value="Internship">Internship</SelectItem>
                <SelectItem value="Freelance">Freelance</SelectItem>
              </SelectContent>
            </Select>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

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
              <Input type="date" :disabled="currentlyWorking" v-bind="componentField" />
            </FormControl>
            <FormDescription>Leave blank if currently working here.</FormDescription>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

      <FormField v-slot="{ value, handleChange }" name="currently_working">
        <FormItem class="flex flex-row items-center gap-2">
          <FormControl>
            <Checkbox
              :model-value="value"
              @update:model-value="(checked) => { handleChange(checked); currentlyWorking = Boolean(checked) }"
            />
          </FormControl>
          <FormLabel class="!mt-0">Currently working here</FormLabel>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="description">
        <FormItem>
          <FormLabel>Description</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter a description..." rows="6" v-bind="componentField" />
          </FormControl>
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
import { update } from '@/routes/admin/experiences'

type ExperienceRecord = {
  id: number
  company: string
  role: string
  location: string | null
  employment_type: string
  start_date: string
  end_date: string | null
  currently_working: boolean
  description: string
}

const props = defineProps<{
  experience: ExperienceRecord
}>()

const processing = ref(false)
const currentlyWorking = ref(props.experience.currently_working ?? false)

function toDateInput(value: string | null): string {
  if (!value) {
    return ''
  }

  return value.slice(0, 10)
}

const initialValues = computed(() => ({
  company: props.experience.company ?? '',
  role: props.experience.role ?? '',
  location: props.experience.location ?? '',
  employment_type: props.experience.employment_type ?? '',
  start_date: toDateInput(props.experience.start_date),
  end_date: toDateInput(props.experience.end_date),
  currently_working: props.experience.currently_working ?? false,
  description: props.experience.description ?? '',
}))

const formSchema = toTypedSchema(
  z.object({
    company: z.string().min(1, 'Company is required').max(255),
    role: z.string().min(1, 'Role is required').max(255),
    location: z.union([z.string().max(255), z.literal('')]).optional(),
    employment_type: z.string().min(1, 'Employment type is required').max(255),
    start_date: z.string().min(1, 'Start date is required'),
    end_date: z.union([z.string(), z.literal('')]).optional(),
    currently_working: z.boolean().optional(),
    description: z.string().min(1, 'Description is required'),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true

  const payload = {
    ...values,
    location: values.location || null,
    currently_working: values.currently_working ?? false,
    end_date: values.currently_working ? null : values.end_date || null,
  }

  const { action } = update.form(props.experience.id)
  router.post(action, payload, {
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>
