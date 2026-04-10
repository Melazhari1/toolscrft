<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  seo: Object
});

const sections = [
  {
    title: 'Data Collection',
    content: 'ToolsCraft does not collect, store, or transmit your personal data. All processing happens locally on your device.'
  },
  {
    title: 'Local Processing',
    content: 'Our tools use client-side JavaScript to perform operations like word counting, JSON conversion, and lorem ipsum generation. Your inputs stay in your browser.'
  },
  {
    title: 'No Tracking',
    content: 'We do not use tracking cookies or analytics that target individual users. Your privacy is our priority.'
  },
  {
    title: 'Third-Party Services',
    content: 'Some network-intensive tools (like Whois or Domain Expiry) may make requests to our secure backend API, but these requests do not include personally identifiable information.'
  }
];
</script>

<template>
  <AppLayout :seo="seo">
    <div class="max-w-4xl mx-auto px-6 py-12">
      <div class="text-center mb-20">
        <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-6 tracking-tighter">
          Privacy <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-600">Policy</span>
        </h1>
        <p class="text-xl text-slate-500 font-medium leading-relaxed max-w-2xl mx-auto">
          Last updated: April 2026. ToolsCraft is built with a local-first architecture to ensure your data never leaves your machine.
        </p>
      </div>

      <div class="grid gap-8 mb-24">
        <div v-for="(section, i) in sections" :key="i" 
             class="p-10 bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40">
          <h2 class="text-2xl font-black text-slate-900 mb-4 tracking-tight">{{ section.title }}</h2>
          <p class="text-lg text-slate-600 font-medium leading-relaxed">{{ section.content }}</p>
        </div>
      </div>

      <div class="bg-indigo-50 rounded-[2.5rem] p-12 text-center border border-indigo-100 shadow-inner">
        <h3 class="text-2xl font-black text-indigo-900 mb-4 tracking-tight">Questions about your privacy?</h3>
        <p class="text-indigo-600 font-medium mb-8">We are committed to transparency. If you have any questions, feel free to reach out.</p>
        <a href="mailto:privacy@toolscraft.base" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
          Contact Privacy Team
        </a>
      </div>
    </div>
  </AppLayout>
</template>
