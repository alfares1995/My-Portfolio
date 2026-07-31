<template>
<AppLayout>
  <div>
    <h1>About Me</h1>
    <p>This is the About Me page for the admin section.</p>
  </div>

  <div class="my-4">
    <Input v-model="search" placeholder="Search..." />
  </div>

  <div class="my-4">
    <Button as-child>
      <Link :href="create()">Create About Me</Link>
    </Button>
  </div>
  <Table>
    <TableCaption>A list of your About Me entries.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[80px]">
          ID
        </TableHead>
        <TableHead>Profile Image</TableHead>
        <TableHead>Banner Image</TableHead>
        <TableHead>Full Name</TableHead>
        <TableHead>Headline</TableHead>
        <TableHead>Short Bio</TableHead>
        <TableHead>Long Bio</TableHead>
        <TableHead>Years Exp.</TableHead>
        <TableHead>Projects</TableHead>
        <TableHead>Happy Clients</TableHead>
        <TableHead>Cups of Coffee</TableHead>
        <TableHead>Location</TableHead>
        <TableHead>Email</TableHead>
        <TableHead>Phone</TableHead>
        <TableHead>Availability</TableHead>
        <TableHead>Resume</TableHead>
        <TableHead>GitHub</TableHead>
        <TableHead>LinkedIn</TableHead>
        <TableHead>Twitter</TableHead>
        <TableHead>Website</TableHead>
        <TableHead>Created At</TableHead>
        <TableHead class="text-right">
          Actions
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-if="filteredAboutMeData.length === 0">
        <TableCell colspan="21" class="text-center text-muted-foreground">
          No About Me entries found.
        </TableCell>
      </TableRow>
      <TableRow v-for="aboutMe in filteredAboutMeData" :key="aboutMe.id">
        <TableCell class="font-medium">
          {{ aboutMe.id }}
        </TableCell>
        <TableCell>
          <img
            v-if="aboutMe.profile_image_url"
            :src="aboutMe.profile_image_url"
            alt="Profile image"
            class="size-12 rounded-full object-cover"
          >
          <span v-else class="text-muted-foreground">No image</span>
        </TableCell>
        <TableCell>
          <img
            v-if="aboutMe.banner_image_url"
            :src="aboutMe.banner_image_url"
            alt="Banner image"
            class="h-12 w-24 rounded object-cover"
          >
          <span v-else class="text-muted-foreground">No image</span>
        </TableCell>
        <TableCell>{{ aboutMe.full_name }}</TableCell>
        <TableCell>{{ aboutMe.headline || '—' }}</TableCell>
        <TableCell class="max-w-xs truncate">{{ aboutMe.short_bio || '—' }}</TableCell>
        <TableCell class="max-w-xs truncate">{{ aboutMe.long_bio || '—' }}</TableCell>
        <TableCell>{{ aboutMe.years_experience }}</TableCell>
        <TableCell>{{ aboutMe.projects_completed }}</TableCell>
        <TableCell>{{ aboutMe.happy_clients }}</TableCell>
        <TableCell>{{ aboutMe.cups_of_coffee }}</TableCell>
        <TableCell>{{ aboutMe.location || '—' }}</TableCell>
        <TableCell>{{ aboutMe.email || '—' }}</TableCell>
        <TableCell>{{ aboutMe.phone || '—' }}</TableCell>
        <TableCell>{{ aboutMe.availability || '—' }}</TableCell>
        <TableCell>
          <a
            v-if="aboutMe.resume_url"
            :href="aboutMe.resume_url"
            target="_blank"
            rel="noopener noreferrer"
            class="text-primary underline"
          >View</a>
          <span v-else class="text-muted-foreground">—</span>
        </TableCell>
        <TableCell>{{ aboutMe.github_username || '—' }}</TableCell>
        <TableCell>
          <a
            v-if="aboutMe.linkedin_url"
            :href="aboutMe.linkedin_url"
            target="_blank"
            rel="noopener noreferrer"
            class="text-primary underline"
          >View</a>
          <span v-else class="text-muted-foreground">—</span>
        </TableCell>
        <TableCell>
          <a
            v-if="aboutMe.twitter_url"
            :href="aboutMe.twitter_url"
            target="_blank"
            rel="noopener noreferrer"
            class="text-primary underline"
          >View</a>
          <span v-else class="text-muted-foreground">—</span>
        </TableCell>
        <TableCell>
          <a
            v-if="aboutMe.website_url"
            :href="aboutMe.website_url"
            target="_blank"
            rel="noopener noreferrer"
            class="text-primary underline"
          >View</a>
          <span v-else class="text-muted-foreground">—</span>
        </TableCell>
        <TableCell>{{ aboutMe.created_at ? new Date(aboutMe.created_at).toLocaleDateString() : '—' }}</TableCell>
        <TableCell class="text-right">
          <div class="flex justify-end gap-2">
            <Button as-child variant="outline" size="icon" title="View">
              <Link :href="show(aboutMe.id)">
                <Eye class="size-4" />
              </Link>
            </Button>
            <Button as-child variant="outline" size="icon" title="Edit">
              <Link :href="edit(aboutMe.id)">
                <Pencil class="size-4" />
              </Link>
            </Button>
            <Button
              variant="destructive"
              size="icon"
              title="Delete"
              @click="handleDelete(aboutMe.id)"
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

import { create, edit, show, destroy } from '@/routes/admin/about-me'

type AboutMe = {
  id: number
  full_name: string
  headline: string 
  short_bio: string 
  long_bio: string 
  profile_image: string | null
  banner_image: string | null
  profile_image_url: string | null
  banner_image_url: string | null
  years_experience: number
  projects_completed: number
  happy_clients: number
  cups_of_coffee: number
  location: string | null
  email: string 
  phone: string | null
  availability: string 
  resume_url: string | null
  github_username: string | null
  linkedin_url: string | null
  twitter_url: string | null
  website_url: string | null
  created_at: string | null
  updated_at: string | null
}

const props = defineProps<{
  aboutMeData: AboutMe[]
}>()

const search = ref('')

const filteredAboutMeData = computed(() => {
  const term = search.value.trim().toLowerCase()
  if (!term) {
    return props.aboutMeData
  }

  return props.aboutMeData.filter((aboutMe) =>
    [
      aboutMe.id,
      aboutMe.full_name,
      aboutMe.headline,
      aboutMe.short_bio,
      aboutMe.long_bio,
      aboutMe.years_experience,
      aboutMe.projects_completed,
      aboutMe.happy_clients,
      aboutMe.cups_of_coffee,
      aboutMe.location,
      aboutMe.email,
      aboutMe.phone,
      aboutMe.availability,
      aboutMe.github_username,
    ]
      .filter((value) => value !== null && value !== undefined && value !== '')
      .some((value) => String(value).toLowerCase().includes(term)),
  )
})

function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this About Me entry?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>