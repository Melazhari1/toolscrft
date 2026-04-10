<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const count = ref(3);

const output = computed(() => {
    const base = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
    return Array.from({ length: count.value || 0 }, () => base).join('\n\n');
});

const copy = () => navigator.clipboard.writeText(output.value);
</script>

<template>
  <AppLayout>
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
      <div>
        <Link href="/" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 mb-2 group">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
          Back to Tools
        </Link>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Lorem Ipsum Generator</h1>
        <p class="text-slate-500 mt-1">Generate placeholder text for your design projects.</p>
      </div>
      
      <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="px-4 py-1">
          <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Paragraphs</label>
          <input type="number" v-model="count" min="1" max="50" class="w-16 p-0 text-xl font-bold bg-transparent border-none focus:ring-0 text-slate-900" />
        </div>
        <button @click="copy" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-black transition-all flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg>
          Copy All
        </button>
      </div>
    </div>
    
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-10 min-h-[500px]">
      <div class="prose prose-slate max-w-none">
        <p v-for="(p, i) in output.split('\n\n')" :key="i" class="text-slate-600 text-lg leading-relaxed mb-6 last:mb-0">{{ p }}</p>
      </div>
    </div>
  </AppLayout>
</template>
