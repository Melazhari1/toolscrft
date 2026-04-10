<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const text = ref('');

const stats = computed(() => {
    const raw = text.value.trim();
    if (!raw) return { words: 0, characters: 0, density: [] };
    
    const wordsArray = raw.toLowerCase().replace(/[^a-z0-9\s]/g, '').split(/\s+/).filter(Boolean);
    const frequencies = {};
    
    wordsArray.forEach(w => { frequencies[w] = (frequencies[w] || 0) + 1; });
    const density = Object.keys(frequencies)
        .map(w => ({ word: w, count: frequencies[w], percent: ((frequencies[w] / wordsArray.length) * 100).toFixed(1) }))
        .sort((a, b) => b.count - a.count)
        .slice(0, 10);
        
    return { words: wordsArray.length, characters: raw.length, density };
});
</script>

<template>
  <AppLayout>
    <div class="mb-8 flex items-center justify-between">
      <div>
        <Link href="/" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 mb-2 group">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
          Back to Tools
        </Link>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Textalyzer</h1>
        <p class="text-slate-500 mt-1">Analyze word frequency and character density in seconds.</p>
      </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2">
        <div class="bg-white p-1 rounded-3xl shadow-sm border border-slate-200 focus-within:ring-4 focus-within:ring-indigo-500/10 transition-all">
          <textarea v-model="text" class="w-full h-96 p-6 bg-transparent border-none focus:ring-0 text-slate-700 leading-relaxed resize-none outline-none text-lg" 
                    placeholder="Paste your text here to begin analysis..."></textarea>
        </div>
      </div>
      
      <div class="space-y-6">
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
          <h3 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-600"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" /></svg>
            Quick Stats
          </h3>
          <div class="grid grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
              <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Words</p>
              <p class="text-2xl font-black text-slate-900">{{ stats.words }}</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
              <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Chars</p>
              <p class="text-2xl font-black text-slate-900">{{ stats.characters }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
          <h3 class="font-bold text-slate-900 mb-6">Top Word Density</h3>
          <div v-if="stats.density.length" class="space-y-3">
            <div v-for="item in stats.density" :key="item.word" class="flex flex-col gap-1">
              <div class="flex justify-between text-sm">
                <span class="font-bold text-slate-700">{{ item.word }}</span>
                <span class="text-slate-500">{{ item.count }} ({{ item.percent }}%)</span>
              </div>
              <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-indigo-500 h-full rounded-full transition-all duration-500" :style="{ width: item.percent + '%' }"></div>
              </div>
            </div>
          </div>
          <p v-else class="text-sm text-slate-400 italic">Enter some text to see density analysis...</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
