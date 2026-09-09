<script setup>
import { computed } from 'vue';
import { Github, Linkedin, Twitter, Instagram, Mail, Phone, MapPin } from 'lucide-vue-next';

const quickLinks = ['Home', 'About', 'Projects', 'Blog', 'Contact'];
const services = ['Web Development', 'Mobile Development', 'UI/UX Design', 'API Development'];

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
  currentYear: {
    type: Number,
    required: true,
  },
});

const social = computed(() => props.profile.social ?? [
  { icon: 'github', url: props.profile.githubUrl },
  { icon: 'phone', url: props.profile.phone ? `tel:${props.profile.phone}` : null },
  { icon: 'linkedin', url: props.profile.linkedinUrl },
  { icon: 'twitter', url: props.profile.twitterUrl },
  { icon: 'mail', url: props.profile.email ? `mailto:${props.profile.email}` : null },
  { icon: 'map', url: props.profile.location },
].filter((link) => link.url));

const socialLink = (icon) => social.value.find((link) => link.icon === icon)?.url;
const profileName = computed(() => props.profile.fullName || [props.profile.firstName, props.profile.lastName].filter(Boolean).join(' ') || 'DevFolio');
</script>

<template>
  <footer class="border-t border-slate-200 px-6 py-14 dark:border-white/5">
    <div class="mx-auto grid max-w-7xl gap-10 sm:grid-cols-2 lg:grid-cols-4">
      <div>
        <p class="text-lg font-semibold text-slate-950 dark:text-white">Dev<span class="text-violet-500">Folio</span>.</p>
        <p class="mt-3 max-w-xs text-sm text-slate-500">
          Building digital experiences one line of code at a time.
        </p>
      </div>

      <div>
        <h4 class="font-semibold text-slate-950 dark:text-white">Quick Links</h4>
        <ul class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-400">
          <li v-for="link in quickLinks" :key="link"><a href="#" class="hover:text-slate-950 dark:hover:text-white">{{ link }}</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-semibold text-slate-950 dark:text-white">Services</h4>
        <ul class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-400">
          <li v-for="s in services" :key="s"><a href="#" class="hover:text-slate-950 dark:hover:text-white">{{ s }}</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-semibold text-slate-950 dark:text-white">Contact Info</h4>
        <ul class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-400">
          <li v-if="socialLink('mail')" class="flex items-center gap-2"><Mail class="h-4 w-4" />{{ socialLink('mail')?.replace('mailto:', '') }}</li>
          <li v-if="socialLink('phone')" class="flex items-center gap-2"><Phone class="h-4 w-4" />{{ socialLink('phone')?.replace('tel:', '') }}</li>
          <li v-if="socialLink('map')" class="flex items-center gap-2"><MapPin class="h-4 w-4" />{{ socialLink('map') }}</li>
        </ul>
        <div class="mt-4 flex gap-3">
          <a v-if="socialLink('github')" :href="socialLink('github')" class="text-slate-500 hover:text-slate-950 dark:text-slate-400 dark:hover:text-white"><Github class="h-4 w-4" /></a>
          <a v-if="socialLink('linkedin')" :href="socialLink('linkedin')" class="text-slate-500 hover:text-slate-950 dark:text-slate-400 dark:hover:text-white"><Linkedin class="h-4 w-4" /></a>
          <a v-if="socialLink('twitter')" :href="socialLink('twitter')" class="text-slate-500 hover:text-slate-950 dark:text-slate-400 dark:hover:text-white"><Twitter class="h-4 w-4" /></a>
          <a v-if="socialLink('instagram')" :href="socialLink('instagram')" class="text-slate-500 hover:text-slate-950 dark:text-slate-400 dark:hover:text-white"><Instagram class="h-4 w-4" /></a>
        </div>
      </div>
    </div>

    <div class="mx-auto mt-10 max-w-7xl border-t border-slate-200 pt-6 text-xs text-slate-500 dark:border-white/5">
      © {{ currentYear }} {{ profileName }}. All rights reserved.
    </div>
  </footer>
</template>
