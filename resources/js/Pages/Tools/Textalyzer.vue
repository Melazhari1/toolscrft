<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import OtherToolsSlider from '@/Components/OtherToolsSlider.vue';

defineProps({
  tools: Array,
  currentTool: String
});

const text = ref('');

// Options
const caseSensitive = ref(false);
const includeSpaces = ref(false);
const excludeStopWords = ref(false);
const readingSpeed = ref(200); // words per minute

const stopWords = new Set([
  'the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'is', 'are', 'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should', 'may', 'might', 'must', 'can', 'shall', 'this', 'that', 'these', 'those', 'i', 'you', 'he', 'she', 'it', 'we', 'they', 'me', 'him', 'her', 'us', 'them', 'my', 'your', 'his', 'its', 'our', 'their', 'what', 'which', 'who', 'when', 'where', 'why', 'how', 'all', 'any', 'both', 'each', 'few', 'more', 'most', 'other', 'some', 'such', 'no', 'nor', 'not', 'only', 'own', 'same', 'so', 'than', 'too', 'very'
]);

const stats = computed(() => {
    const raw = text.value.trim();
    if (!raw) return { words: 0, characters: 0, sentences: 0, uniqueWords: 0, avgWordLength: 0, readingTime: 0, density: [] };
    
    let wordsArray = raw.replace(/[^a-z0-9\s]/g, '').split(/\s+/).filter(Boolean);
    if (!caseSensitive.value) {
        wordsArray = wordsArray.map(w => w.toLowerCase());
    }
    
    const frequencies = {};
    wordsArray.forEach(w => { 
        if (excludeStopWords.value && stopWords.has(w.toLowerCase())) return;
        frequencies[w] = (frequencies[w] || 0) + 1; 
    });
    
    const density = Object.keys(frequencies)
        .map(w => ({ word: w, count: frequencies[w], percent: ((frequencies[w] / wordsArray.length) * 100).toFixed(1) }))
        .sort((a, b) => b.count - a.count)
        .slice(0, 10);
        
    const sentences = raw.split(/[.!?]+/).filter(s => s.trim()).length;
    const uniqueWords = Object.keys(frequencies).length;
    const avgWordLength = wordsArray.length ? (wordsArray.reduce((sum, w) => sum + w.length, 0) / wordsArray.length).toFixed(1) : 0;
    const characters = includeSpaces.value ? raw.length : raw.replace(/\s/g, '').length;
    const readingTime = Math.ceil(wordsArray.length / readingSpeed.value);
        
    return { words: wordsArray.length, characters, sentences, uniqueWords, avgWordLength, readingTime, density };
});

const clearText = () => {
    text.value = '';
};

const copyStats = async () => {
    const statsText = `Words: ${stats.value.words}\nCharacters: ${stats.value.characters}\nSentences: ${stats.value.sentences}\nUnique Words: ${stats.value.uniqueWords}\nAvg Word Length: ${stats.value.avgWordLength}\nReading Time: ${stats.value.readingTime} min`;
    await navigator.clipboard.writeText(statsText);
};
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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-600"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 1.143c.214.19.441.286.701.286s.487-.096.7-.286l1.297-1.143a1.125 1.125 0 011.37-.49l1.217.456c.355.133.75.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v6" /></svg>
            Analysis Options
          </h3>
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <label class="text-sm font-medium text-slate-700">Case Sensitive</label>
              <input type="checkbox" v-model="caseSensitive" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            </div>
            <div class="flex items-center justify-between">
              <label class="text-sm font-medium text-slate-700">Include Spaces in Character Count</label>
              <input type="checkbox" v-model="includeSpaces" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            </div>
            <div class="flex items-center justify-between">
              <label class="text-sm font-medium text-slate-700">Exclude Common Words</label>
              <input type="checkbox" v-model="excludeStopWords" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            </div>
            <div class="flex items-center justify-between">
              <label class="text-sm font-medium text-slate-700">Reading Speed (WPM)</label>
              <select v-model="readingSpeed" class="text-sm border border-slate-300 rounded px-2 py-1 focus:ring-indigo-500 focus:border-indigo-500">
                <option :value="150">150 (Slow)</option>
                <option :value="200">200 (Average)</option>
                <option :value="250">250 (Fast)</option>
                <option :value="300">300 (Very Fast)</option>
              </select>
            </div>
            <div class="flex gap-3 pt-2">
              <button @click="clearText" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                Clear Text
              </button>
              <button @click="copyStats" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                Copy Stats
              </button>
            </div>
          </div>
        </div>

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
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
              <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sentences</p>
              <p class="text-2xl font-black text-slate-900">{{ stats.sentences }}</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
              <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Unique Words</p>
              <p class="text-2xl font-black text-slate-900">{{ stats.uniqueWords }}</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
              <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Avg Word Len</p>
              <p class="text-2xl font-black text-slate-900">{{ stats.avgWordLength }}</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
              <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Read Time</p>
              <p class="text-2xl font-black text-slate-900">{{ stats.readingTime }} min</p>
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

    <OtherToolsSlider :tools="tools" :current-slug="currentTool" />
  </AppLayout>
</template>
