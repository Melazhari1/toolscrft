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
const mode = ref('minify'); // 'minify' or 'format'

const minifyCss = (css) => {
    return css
        .replace(/\/\*[\s\S]*?\*\//g, '') // Remove comments
        .replace(/\s+/g, ' ')             // Replace multiple spaces with single space
        .replace(/\s*([\{\}:;,])\s*/g, '$1') // Remove spaces around symbols
        .replace(/;}/g, '}')              // Remove trailing semicolon before }
        .trim();
};

const formatCss = (css) => {
    let formatted = css
        .replace(/\/\*[\s\S]*?\*\//g, '') // Remove comments first for simplicity
        .replace(/\s*\{\s*/g, ' {\n    ')
        .replace(/\s*;\s*/g, ';\n    ')
        .replace(/\s*\}\s*/g, '\n}\n\n')
        .replace(/\n\s*\n/g, '\n')       // Remove extra newlines
        .replace(/,\s*/g, ', ')          // Space after commas in selectors
        .trim();
    
    // Fix indentation for the last property in a block
    formatted = formatted.replace(/    \n\}/g, '\n}');
    
    return formatted;
};

const process = () => {
    if (!input.value) {
        output.value = '';
        return;
    }

    if (mode.value === 'minify') {
        output.value = minifyCss(input.value);
    } else {
        output.value = formatCss(input.value);
    }
};

watch([input, mode], process, { immediate: true });

const copyToClipboard = () => {
    navigator.clipboard.writeText(output.value);
};

const clearInput = () => {
    input.value = '';
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
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">CSS Minifier & Formatter</h1>
        <p class="text-slate-500 mt-1">Compress your CSS for production or beautify it for readability.</p>
      </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-8">
      <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest mr-2">Mode:</span>
            <div class="inline-flex bg-slate-100 p-1 rounded-2xl">
                <button @click="mode = 'minify'" 
                        :class="mode === 'minify' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" 
                        class="px-4 py-1.5 rounded-xl font-semibold text-sm transition-all">
                Minify
                </button>
                <button @click="mode = 'format'" 
                        :class="mode === 'format' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" 
                        class="px-4 py-1.5 rounded-xl font-semibold text-sm transition-all">
                Format
                </button>
            </div>
        </div>
        
        <button @click="clearInput" class="text-sm font-medium text-slate-400 hover:text-red-500 transition-colors flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 12m-4.77 0L9.34 9m12-3h-3.07a12.24 12.24 0 0 1-2.34-1.24c-.66-.41-1.3-.87-1.92-1.36a3.68 3.68 0 0 0-2.34-.96c-.84 0-1.66.36-2.34.96-.62.49-1.26.95-1.92 1.36a12.24 12.24 0 0 1-2.34 1.24H2.76m12-3h-12m12 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
            Clear
        </button>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <div class="flex flex-col gap-4">
        <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Input CSS</span>
        <div class="flex-1 bg-slate-950 rounded-[2.5rem] p-8 border border-slate-800 shadow-inner group focus-within:border-indigo-500/50 transition-colors">
          <textarea v-model="input" 
                    class="w-full h-[400px] bg-transparent border-none focus:ring-0 text-emerald-400 font-mono text-sm leading-relaxed resize-none outline-none"
                    placeholder="Paste your CSS here..."></textarea>
        </div>
      </div>

      <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
          <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Result</span>
          <button v-if="output" @click="copyToClipboard" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 px-3 py-1 bg-indigo-50 rounded-full transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2m-6 12h8a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" /></svg>
            Copy
          </button>
        </div>
        <div class="flex-1 bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-inner">
          <textarea readonly 
                    :value="output" 
                    class="w-full h-[400px] bg-transparent border-none focus:ring-0 text-slate-700 font-mono text-sm leading-relaxed resize-none outline-none"
                    placeholder="Processed CSS will appear here..."></textarea>
        </div>
      </div>
    </div>

    <OtherToolsSlider :tools="tools" :current-slug="currentTool" />
  </AppLayout>
</template>
