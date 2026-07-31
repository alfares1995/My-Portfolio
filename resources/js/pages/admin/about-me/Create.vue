<template>
<AppLayout>
  <div>
    <h1>Create About Me</h1>
    <p>This is the Create About Me page for the admin section.</p>
  </div>
  <div class="my-4">
    <Form
      @submit="onSubmit"
      class="space-y-6"
      :validation-schema="formSchema"
      :initial-values="{ availability: 'available' }"
    >
      <FormField v-slot="{ componentField }" name="full_name">
        <FormItem>
          <FormLabel>Full Name</FormLabel>
          <FormControl>
            <Input placeholder="Enter full name..." v-bind="componentField" />
          </FormControl>
          <FormDescription>Enter the full name for your About Me section.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="headline">
        <FormItem>
          <FormLabel>Headline</FormLabel>
          <FormControl>
            <Input placeholder="Enter headline..." v-bind="componentField" />
          </FormControl>
          <FormDescription>A short tagline shown under your name.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="short_bio">
        <FormItem>
          <FormLabel>Short Bio</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter a short bio..." v-bind="componentField" />
          </FormControl>
          <FormDescription>Enter the short bio for your About Me section.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="long_bio">
        <FormItem>
          <FormLabel>Long Bio</FormLabel>
          <FormControl>
            <Textarea placeholder="Enter a longer bio..." v-bind="componentField" />
          </FormControl>
          <FormDescription>Enter the full biography for your About Me section.</FormDescription>
          <FormMessage />
        </FormItem>
      </FormField>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <FormField v-slot="{ handleChange, handleBlur }" name="profile_image">
          <FormItem>
            <FormLabel>Profile Image</FormLabel>
            <FormControl>
              <Input
                type="file"
                accept="image/*"
                @change="(e: Event) => handleChange((e.target as HTMLInputElement).files?.[0] ?? null)"
                @blur="handleBlur"
              />
            </FormControl>
            <FormDescription>Upload a profile image (jpeg, png, jpg, gif, svg).</FormDescription>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ handleChange, handleBlur }" name="banner_image">
          <FormItem>
            <FormLabel>Banner Image</FormLabel>
            <FormControl>
              <Input
                type="file"
                accept="image/*"
                @change="(e: Event) => handleChange((e.target as HTMLInputElement).files?.[0] ?? null)"
                @blur="handleBlur"
              />
            </FormControl>
            <FormDescription>Upload a banner image (jpeg, png, jpg, gif, svg).</FormDescription>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <FormField v-slot="{ componentField }" name="years_experience">
          <FormItem>
            <FormLabel>Years Experience</FormLabel>
            <FormControl>
              <Input type="number" min="0" placeholder="0" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="projects_completed">
          <FormItem>
            <FormLabel>Projects Completed</FormLabel>
            <FormControl>
              <Input type="number" min="0" placeholder="0" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="happy_clients">
          <FormItem>
            <FormLabel>Happy Clients</FormLabel>
            <FormControl>
              <Input type="number" min="0" placeholder="0" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="cups_of_coffee">
          <FormItem>
            <FormLabel>Cups of Coffee</FormLabel>
            <FormControl>
              <Input type="number" min="0" placeholder="0" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

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

        <FormField v-slot="{ componentField }" name="email">
          <FormItem>
            <FormLabel>Email</FormLabel>
            <FormControl>
              <Input type="email" placeholder="Enter email..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="phone">
          <FormItem>
            <FormLabel>Phone</FormLabel>
            <FormControl>
              <Input type="tel" placeholder="Enter phone number..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="availability">
          <FormItem>
            <FormLabel>Availability</FormLabel>
            <Select v-bind="componentField">
              <FormControl>
                <SelectTrigger class="w-full">
                  <SelectValue placeholder="Select availability" />
                </SelectTrigger>
              </FormControl>
              <SelectContent>
                <SelectItem value="available">
                  Available
                </SelectItem>
                <SelectItem value="busy">
                  Busy
                </SelectItem>
                <SelectItem value="freelancing">
                  Freelancing
                </SelectItem>
                <SelectItem value="not_available">
                  Not Available
                </SelectItem>
              </SelectContent>
            </Select>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <FormField v-slot="{ handleChange, handleBlur }" name="resume">
          <FormItem>
            <FormLabel>Resume</FormLabel>
            <FormControl>
              <Input
                type="file"
                accept=".pdf,.doc,.docx"
                @change="(e: Event) => handleChange((e.target as HTMLInputElement).files?.[0] ?? null)"
                @blur="handleBlur"
              />
            </FormControl>
            <FormDescription>Upload a resume file (PDF or Word).</FormDescription>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="github_username">
          <FormItem>
            <FormLabel>GitHub Username</FormLabel>
            <FormControl>
              <Input placeholder="Enter GitHub username..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="linkedin_url">
          <FormItem>
            <FormLabel>LinkedIn URL</FormLabel>
            <FormControl>
              <Input type="url" placeholder="https://..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="twitter_url">
          <FormItem>
            <FormLabel>Twitter URL</FormLabel>
            <FormControl>
              <Input type="url" placeholder="https://..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="website_url">
          <FormItem>
            <FormLabel>Website URL</FormLabel>
            <FormControl>
              <Input type="url" placeholder="https://..." v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

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
import { store } from '@/routes/admin/about-me'

const processing = ref(false)

const imageField = z
  .instanceof(File)
  .nullable()
  .optional()
  .refine((file) => !file || file.size <= 2048 * 1024, 'Image must not exceed 2MB')
  .refine((file) => !file || file.type.startsWith('image/'), 'File must be an image')

const resumeField = z
  .instanceof(File)
  .nullable()
  .optional()
  .refine((file) => !file || file.size <= 5120 * 1024, 'Resume must not exceed 5MB')
  .refine(
    (file) => !file || ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'].includes(file.type),
    'File must be a PDF or Word document',
  )

const formSchema = toTypedSchema(
  z.object({
    full_name: z.string().min(1, 'Full name is required').max(255),
    headline: z.string().min(1, 'Headline is required').max(255),
    short_bio: z.string().min(1, 'Short bio is required').max(500),
    long_bio: z.string().min(1, 'Long bio is required'),
    profile_image: imageField,
    banner_image: imageField,
    years_experience: z.coerce.number({ invalid_type_error: 'Years experience is required' }).int('Must be a whole number').min(0, 'Must be 0 or greater'),
    projects_completed: z.coerce.number({ invalid_type_error: 'Projects completed is required' }).int('Must be a whole number').min(0, 'Must be 0 or greater'),
    happy_clients: z.coerce.number({ invalid_type_error: 'Happy clients is required' }).int('Must be a whole number').min(0, 'Must be 0 or greater'),
    cups_of_coffee: z.coerce.number({ invalid_type_error: 'Cups of coffee is required' }).int('Must be a whole number').min(0, 'Must be 0 or greater'),
    location: z.union([z.string().max(255), z.literal('')]).optional(),
    email: z.string().min(1, 'Email is required').email('Invalid email').max(255),
    phone: z.union([z.string().max(20), z.literal('')]).optional(),
    availability: z.enum(['available', 'busy', 'freelancing', 'not_available']).optional(),
    resume: resumeField,
    github_username: z.union([z.string().max(255), z.literal('')]).optional(),
    linkedin_url: z.union([z.string().url('Invalid URL').max(255), z.literal('')]).optional(),
    twitter_url: z.union([z.string().url('Invalid URL').max(255), z.literal('')]).optional(),
    website_url: z.union([z.string().url('Invalid URL').max(255), z.literal('')]).optional(),
  }),
)

function onSubmit(values: Record<string, any>) {
  processing.value = true
  router.post(store.url(), values as any, {
    forceFormData: true,
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>