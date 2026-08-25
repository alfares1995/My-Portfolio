<script setup>
import PortfolioLayout from '@/layouts/PortfolioLayout.vue';
import Hero from '@/components/portfolio/Hero.vue';
import TrustedBy from '@/components/portfolio/TrustedBy.vue';
import AboutMe from '@/components/portfolio/AboutMe.vue';
import FeaturedProjects from '@/components/portfolio/FeaturedProjects.vue';
import BlogAndSkills from '@/components/portfolio/BlogAndSkills.vue';
import CtaBanner from '@/components/portfolio/CtaBanner.vue';

defineOptions({ layout: PortfolioLayout });

defineProps({
  profile: Object,
  trustedBy: Array,
  projects: Array,
  posts: Array,
  skills: Array,
});
</script>

<template>
  <Hero :profile="profile" />
  <TrustedBy :logos="trustedBy" />
  <AboutMe :profile="profile" />
  <FeaturedProjects :projects="projects" />
  <BlogAndSkills :posts="posts" :skills="skills" />
  <CtaBanner />
</template>
