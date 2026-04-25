<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({ tools: Array });
const search = ref('');

const filteredTools = computed(() => {
    return props.tools.filter(t => t.name.toLowerCase().includes(search.value.toLowerCase()) || 
                                   t.desc.toLowerCase().includes(search.value.toLowerCase()));
});
</script>

<template>
  <AppLayout>
    <div class="mb-24 text-center relative">
      <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-black uppercase tracking-widest mb-8 animate-bounce">
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
        </span>
        New Tools Added Soon  
      </div>
      <h1 class="text-5xl md:text-7xl font-black text-slate-900 mb-6 tracking-tighter leading-[0.9]">
        Elevate Your <br/>
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-blue-600 to-emerald-500">Digital Workflow</span>
      </h1>
      <p class="text-xl text-slate-500 max-w-2xl mx-auto mb-12 font-medium leading-relaxed">
        ToolsCraft is a suite of professional-grade tools designed to give you the edge. No cloud, no tracking, just speed.
      </p>
      
      <div class="relative max-w-2xl mx-auto group">
        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-[2rem] blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
        <div class="relative flex items-center bg-white border border-slate-200 rounded-[2rem] shadow-2xl overflow-hidden">
          <div class="pl-6 text-slate-400">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
          </div>
          <input v-model="search" type="text" placeholder="What tool are you looking for today?" 
                 class="w-full px-4 py-6 bg-transparent outline-none text-lg font-bold placeholder:text-slate-300" />
        </div>
      </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <Link v-for="(tool, index) in filteredTools" :key="tool.slug" :href="route(tool.slug)" 
            class="group relative bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-500">
        
        <!-- Hover Background Glow -->
        <div class="absolute inset-x-0 -bottom-2 h-1/2 bg-gradient-to-t from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-b-[2.5rem]"></div>

        <div class="relative z-10">
          <div :class="[
            'w-16 h-16 rounded-2xl flex items-center justify-center mb-8 shadow-lg transition-all duration-500 group-hover:scale-110 group-hover:rotate-3',
            index % 3 === 0 ? 'bg-indigo-600 text-white shadow-indigo-200' : 
            index % 3 === 1 ? 'bg-blue-600 text-white shadow-blue-200' : 
            'bg-emerald-600 text-white shadow-emerald-200'
          ]">
            <svg v-if="tool.name.includes('Text')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" /></svg>
            <svg v-else-if="tool.name.includes('Domain')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
            <svg v-else-if="tool.name.includes('Lorem')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>
            <svg v-else-if="tool.name.includes('CSS') || tool.name.includes('Gradient')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122l9.37-5.055a9 9 0 11-1.018-4.376M9.53 16.122a3 3 0 11-3.034-4.76l3.034 4.76z" /></svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
          </div>
          <h2 class="text-2xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors tracking-tight">{{ tool.name }}</h2>
          <p class="text-slate-500 mt-4 text-base font-medium leading-relaxed">{{ tool.desc }}</p>
          <div class="mt-10 flex items-center text-sm font-black text-indigo-600 uppercase tracking-widest group-hover:gap-2 transition-all">
            Launch Tool
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 ml-2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
          </div>
        </div>
      </Link>
    </div>
  </AppLayout>
</template>
