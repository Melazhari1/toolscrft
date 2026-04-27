<script setup>
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import OtherToolsSlider from '@/Components/OtherToolsSlider.vue';

defineProps({
  tools: Array,
  currentTool: String
});

const input = ref('');
const output = ref('');
const separator = ref('-');
const removeStopWords = ref(false);
const removeNumbers = ref(false);
const lowercase = ref(true);

const stopWords = [
    'a', 'an', 'and', 'are', 'as', 'at', 'be', 'but', 'by', 'for', 'if', 'in', 'into', 'is', 'it', 'no', 'not', 'of', 'on', 'or', 'such', 'that', 'the', 'their', 'then', 'there', 'these', 'they', 'this', 'to', 'was', 'will', 'with'
];

const generateSlug = () => {
    let text = input.value;
    
    if (lowercase.value) {
        text = text.toLowerCase();
    }

    // Remove stop words if enabled
    if (removeStopWords.value) {
        const words = text.split(/\s+/);
        text = words.filter(word => !stopWords.includes(word.toLowerCase())).join(' ');
    }

    // Remove numbers if enabled
    if (removeNumbers.value) {
        text = text.replace(/[0-9]/g, '');
    }

    // Replace non-alphanumeric characters with the separator
    text = text
        .replace(/[^a-z0-9\s-]/gi, '') // Remove special chars
        .trim()
        .replace(/\s+/g, separator.value) // Replace spaces
        .replace(new RegExp(`\\${separator.value}+`, 'g'), separator.value); // Replace multiple separators

    output.value = text;
};

watch([input, separator, removeStopWords, removeNumbers, lowercase], generateSlug, { immediate: true });

const copyToClipboard = () => {
    navigator.clipboard.writeText(output.value);
};

const clearInput = () => {
    input.value = '';
};

const resetOptions = () => {
    separator.value = '-';
    removeStopWords.value = false;
    removeNumbers.value = false;
    lowercase.value = true;
};
</script>

<template>
  <AppLayout>
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
      <div>
        <Link href="/" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 mb-2 group">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
          Back to Tools
        </Link>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">URL Slug Generator</h1>
        <p class="text-slate-500 mt-1">Create search engine friendly and user friendly URL slugs.</p>
      </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mb-3">Separator</label>
          <div class="flex gap-2">
            <button @click="separator = '-'" :class="separator === '-' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="flex-1 px-4 py-2 rounded-xl font-medium transition-colors text-sm">
              Dash (-)
            </button>
            <button @click="separator = '_'" :class="separator === '_' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="flex-1 px-4 py-2 rounded-xl font-medium transition-colors text-sm">
              Underscore (_)
            </button>
          </div>
        </div>

        <div class="flex items-center gap-2 pt-6">
            <input type="checkbox" id="lowercase" v-model="lowercase" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
            <label for="lowercase" class="text-sm font-medium text-slate-700">Lowercase</label>
        </div>

        <div class="flex items-center gap-2 pt-6">
            <input type="checkbox" id="stopWords" v-model="removeStopWords" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
            <label for="stopWords" class="text-sm font-medium text-slate-700">Remove Stop Words</label>
        </div>

        <div class="flex items-center gap-2 pt-6">
            <input type="checkbox" id="numbers" v-model="removeNumbers" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
            <label for="numbers" class="text-sm font-medium text-slate-700">Remove Numbers</label>
        </div>
      </div>
      
      <div class="flex justify-end gap-2 mt-6 pt-6 border-t border-slate-100">
          <button @click="resetOptions" class="text-xs font-semibold text-slate-500 hover:text-slate-700">Reset Options</button>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Input Text</span>
            <button @click="clearInput" class="text-xs font-semibold text-rose-600 hover:text-rose-700">Clear</button>
        </div>
        <div class="flex-1 bg-slate-950 rounded-[2.5rem] p-8 border border-slate-800 shadow-inner">
          <textarea v-model="input" class="w-full h-[300px] bg-transparent border-none focus:ring-0 text-emerald-400 font-mono text-sm leading-relaxed resize-none outline-none"
                    placeholder="Enter the title or text to slugify..."></textarea>
        </div>
      </div>

      <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
          <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">URL Slug</span>
          <button v-if="output" @click="copyToClipboard" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2m-6 12h8a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" /></svg>
            Copy Slug
          </button>
        </div>
        <div class="flex-1 bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-inner">
          <textarea readonly :value="output" class="w-full h-[300px] bg-transparent border-none focus:ring-0 text-slate-700 font-mono text-sm leading-relaxed resize-none outline-none"
                    placeholder="Slug will appear here..."></textarea>
        </div>
      </div>
    </div>

    <OtherToolsSlider :tools="tools" :current-slug="currentTool" />
  </AppLayout>
</template>
