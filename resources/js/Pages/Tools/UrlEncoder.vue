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
const encoded = ref('');
const decoded = ref('');
const mode = ref('encode');

const encode = (text) => {
    try {
        return encodeURIComponent(text);
    } catch {
        return '';
    }
};

const decode = (text) => {
    try {
        return decodeURIComponent(text);
    } catch {
        return '';
    }
};

const convert = () => {
    if (mode.value === 'encode') {
        encoded.value = encode(input.value);
        decoded.value = '';
    } else {
        decoded.value = decode(input.value);
        encoded.value = '';
    }
};

watch([input, mode], convert, { immediate: true });

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
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
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">URL Encoder/Decoder</h1>
        <p class="text-slate-500 mt-1">Encode and decode URLs for safe web transmission.</p>
      </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-8">
      <div class="flex gap-4">
        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Mode</label>
          <div class="flex gap-2">
            <button @click="mode = 'encode'" :class="mode === 'encode' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-4 py-2 rounded-2xl font-medium transition-colors">
              Encode
            </button>
            <button @click="mode = 'decode'" :class="mode === 'decode' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-4 py-2 rounded-2xl font-medium transition-colors">
              Decode
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <div class="flex flex-col gap-4">
        <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Input</span>
        <div class="flex-1 bg-slate-950 rounded-[2.5rem] p-8 border border-slate-800 shadow-inner">
          <textarea v-model="input" class="w-full h-[300px] bg-transparent border-none focus:ring-0 text-emerald-400 font-mono text-sm leading-relaxed resize-none outline-none"
                    :placeholder="mode === 'encode' ? 'Enter text to encode...' : 'Enter URL to decode...'"></textarea>
        </div>
      </div>

      <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
          <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Output</span>
          <button v-if="encoded || decoded" @click="copyToClipboard(encoded || decoded)" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2m-6 12h8a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" /></svg>
            Copy
          </button>
        </div>
        <div class="flex-1 bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-inner">
          <textarea readonly :value="encoded || decoded" class="w-full h-[300px] bg-transparent border-none focus:ring-0 text-slate-700 font-mono text-sm leading-relaxed resize-none outline-none"
                    placeholder="Results will appear here..."></textarea>
        </div>
      </div>
    </div>

    <OtherToolsSlider :tools="tools" :current-slug="currentTool" />
  </AppLayout>
</template>