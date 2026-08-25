<script setup>
import { Github, Linkedin, Twitter, Instagram, Mail, Phone, MapPin } from 'lucide-vue-next';

const quickLinks = ['Home', 'About', 'Projects', 'Blog', 'Contact'];
const services = ['Web Development', 'Mobile Development', 'UI/UX Design', 'API Development'];

defineProps({ profile: Object });

</script>

<template>
  <footer class="border-t border-white/5 px-6 py-14">
    <div class="mx-auto grid max-w-7xl gap-10 sm:grid-cols-2 lg:grid-cols-4">
      <div>
        <p class="text-lg font-semibold text-white">Dev<span class="text-violet-500">Folio</span>.</p>
        <p class="mt-3 max-w-xs text-sm text-slate-500">
          Building digital experiences one line of code at a time.
        </p>
      </div>

      <div>
        <h4 class="font-semibold text-white">Quick Links</h4>
        <ul class="mt-4 space-y-2 text-sm text-slate-400">
          <li v-for="link in quickLinks" :key="link"><a href="#" class="hover:text-white">{{ link }}</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-semibold text-white">Services</h4>
        <ul class="mt-4 space-y-2 text-sm text-slate-400">
          <li v-for="s in services" :key="s"><a href="#" class="hover:text-white">{{ s }}</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-semibold text-white">Contact Info</h4>
        <ul class="mt-4 space-y-3 text-sm text-slate-400">
          <li class="flex items-center gap-2"><Mail class="h-4 w-4" />{{ profile.social.find(s => s.icon === 'mail')?.url.replace('mailto:', '') }}</li>
          <li class="flex items-center gap-2"><Phone class="h-4 w-4" /> {{ profile.social.find(s => s.icon === 'phone')?.url.replace('tel:', '') }}</li>
          <li class="flex items-center gap-2"><MapPin class="h-4 w-4" /> {{ profile.social.find(s => s.icon === 'map')?.url ?? '' }}</li>
        </ul>
        <div class="mt-4 flex gap-3">
          <a :href="profile.social.find(s => s.icon === 'github')?.url" class="text-slate-400 hover:text-white"><Github class="h-4 w-4" /></a>
          <a :href="profile.social.find(s => s.icon === 'linkedin')?.url" class="text-slate-400 hover:text-white"><Linkedin class="h-4 w-4" /></a>
          <a :href="profile.social.find(s => s.icon === 'twitter')?.url" class="text-slate-400 hover:text-white"><Twitter class="h-4 w-4" /></a>
          <a :href="profile.social.find(s => s.icon === 'instagram')?.url" class="text-slate-400 hover:text-white"><Instagram class="h-4 w-4" /></a>
        </div>
      </div>
    </div>

    <div class="mx-auto mt-10 max-w-7xl border-t border-white/5 pt-6 text-xs text-slate-500">
      © {{ new Date().getFullYear() }} John Doe. All rights reserved.
    </div>
  </footer>
</template>
