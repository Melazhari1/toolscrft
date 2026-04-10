<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  seo: Object
});

const steps = [
  {
    title: 'Input Your Data',
    desc: 'Paste your text, JSON, or domain lists into our secure, local-first inputs.',
    icon: 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'
  },
  {
    title: 'Local Processing',
    desc: 'The tools run entirely in your browser or on your local server. No data ever hits the cloud.',
    icon: 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z'
  },
  {
    title: 'Instant Results',
    desc: 'Get word counts, CSV exports, or whois data rendered instantly with professional precision.',
    icon: 'M13 10V3L4 14h7v7l9-11h-7z'
  }
];
</script>

<template>
  <AppLayout :seo="seo">
    <div class="max-w-4xl mx-auto px-6 py-12">
      <div class="text-center mb-20 animate-fade-in">
        <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-6 tracking-tighter leading-tight">
          How <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-600">ToolsCraft</span> Works
        </h1>
        <p class="text-xl text-slate-510 font-medium leading-relaxed max-w-2xl mx-auto text-slate-500">
          Our philosophy is simple: professional tools should be fast, private, and local-first. Here is how we ensure your data stays yours.
        </p>
      </div>

      <div class="space-y-12 mb-24">
        <div v-for="(step, i) in steps" :key="i" 
             class="group relative bg-white p-12 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 flex flex-col md:flex-row items-center gap-12">
          
          <div class="flex-shrink-0 w-24 h-24 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-3xl flex items-center justify-center text-white shadow-2xl shadow-indigo-200 group-hover:rotate-6 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
              <path stroke-linecap="round" stroke-linejoin="round" :d="step.icon" />
            </svg>
          </div>

          <div class="text-center md:text-left flex-1">
            <div class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-2">Step 0{{ i + 1 }}</div>
            <h2 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">{{ step.title }}</h2>
            <p class="text-lg text-slate-500 font-medium leading-relaxed">{{ step.desc }}</p>
          </div>

          <div v-if="i < steps.length - 1" class="absolute -bottom-12 left-1/2 -translate-x-1/2 hidden md:block">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-200">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-slate-900 rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500/20 rounded-full blur-[100px]"></div>
        
        <h2 class="text-4xl font-black text-white mb-6 relative z-10 tracking-tight">Ready to boost your workflow?</h2>
        <p class="text-indigo-200 text-lg font-medium mb-12 max-w-lg mx-auto relative z-10">
          No signups, no hidden costs. Join thousands of pros who trust ToolsCraft every day.
        </p>
        <Link href="/" class="inline-flex items-center px-10 py-5 bg-white text-slate-900 rounded-2xl font-black text-lg hover:bg-indigo-50 transition-all relative z-10 shadow-xl">
          Get Started Now
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5 ml-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
