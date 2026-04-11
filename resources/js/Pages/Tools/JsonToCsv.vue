<script setup>
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const json = ref('');
const csv = ref('');
const error = ref('');
const delimiter = ref(',');
const includeHeaders = ref(true);
const quoteAll = ref(false);
const flattenDeep = ref(false);
const flattenSeparator = ref('.');

const flattenObject = (obj, prefix = '') => {
    return Object.entries(obj || {}).reduce((acc, [key, value]) => {
        const nextKey = prefix ? `${prefix}${flattenSeparator.value}${key}` : key;
        if (value && typeof value === 'object' && !Array.isArray(value)) {
            Object.assign(acc, flattenObject(value, nextKey));
        } else {
            acc[nextKey] = value;
        }
        return acc;
    }, {});
};

const formatCell = (value) => {
    let cell = value === null || value === undefined ? '' : String(value);
    const shouldQuote = quoteAll.value || cell.includes(delimiter.value) || cell.includes('"') || cell.includes('\n') || cell.includes('\r');
    cell = cell.replace(/"/g, '""');
    return shouldQuote ? `"${cell}"` : cell;
};

const convert = () => {
    error.value = '';
    try {
        if (!json.value.trim()) {
            csv.value = '';
            return;
        }

        let data = JSON.parse(json.value);
        if (!Array.isArray(data)) data = [data];
        if (!data.length) {
            csv.value = '';
            return;
        }

        if (flattenDeep.value) {
            data = data.map(item => (item && typeof item === 'object' && !Array.isArray(item)) ? flattenObject(item) : item);
        }

        const headers = Array.from(new Set(data.flatMap(item => Object.keys(item || {}))));
        const rows = data.map(obj => headers.map(header => formatCell(obj?.[header])).join(delimiter.value));
        csv.value = includeHeaders.value ? [headers.map(formatCell).join(delimiter.value), ...rows].join('\n') : rows.join('\n');
    } catch {
        error.value = 'Invalid JSON array or object format.';
        csv.value = '';
    }
};

watch([json, delimiter, includeHeaders, quoteAll, flattenDeep, flattenSeparator], convert, { immediate: true });

const download = () => {
    if (!csv.value) return;
    const blob = new Blob([csv.value], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'export.csv';
    a.click();
    URL.revokeObjectURL(url);
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
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">JSON to CSV Converter</h1>
        <p class="text-slate-500 mt-1">Convert structured data effortlessly for spreadsheets.</p>
      </div>
      
      <button @click="download" :disabled="!csv" 
              class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-emerald-200 transition-all disabled:opacity-30 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
        Download CSV
      </button>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-8">
      <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Delimiter</label>
          <select v-model="delimiter" class="w-full rounded-2xl border border-slate-200 px-3 py-2 text-slate-900 focus:ring-indigo-500 focus:border-indigo-500">
            <option value=",">Comma</option>
            <option value=";">Semicolon</option>
            <option value="|">Pipe</option>
            <option value="\t">Tab</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Headers</label>
          <div class="flex items-center gap-3">
            <input id="include-headers" type="checkbox" v-model="includeHeaders" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="include-headers" class="text-sm text-slate-700">Include header row</label>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Quoting</label>
          <div class="flex items-center gap-3">
            <input id="quote-all" type="checkbox" v-model="quoteAll" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="quote-all" class="text-sm text-slate-700">Quote all fields</label>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Nested objects</label>
          <div class="space-y-2">
            <div class="flex items-center gap-3">
              <input id="flatten-deep" type="checkbox" v-model="flattenDeep" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
              <label for="flatten-deep" class="text-sm text-slate-700">Flatten nested object fields</label>
            </div>
            <div v-if="flattenDeep" class="pt-2">
              <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Separator</label>
              <input type="text" v-model="flattenSeparator" maxlength="2" class="w-full rounded-2xl border border-slate-200 px-3 py-2 text-slate-900 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
          <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">JSON Input</span>
          <span v-if="error" class="text-xs font-bold text-red-500 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
            {{ error }}
          </span>
        </div>
        <div class="flex-1 bg-slate-950 rounded-[2.5rem] p-8 border border-slate-800 shadow-inner">
          <textarea v-model="json" @input="convert" class="w-full h-[500px] bg-transparent border-none focus:ring-0 text-emerald-400 font-mono text-sm leading-relaxed resize-none outline-none" 
                    placeholder='[{"id": 1, "name": "ToolsCraft", "role": "Full-Stack Expert"}]'></textarea>
        </div>
      </div>
      
      <div class="flex flex-col gap-4">
        <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">CSV Output</span>
        <div class="flex-1 bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-inner">
          <textarea readonly :value="csv" class="w-full h-[500px] bg-transparent border-none focus:ring-0 text-slate-700 font-mono text-sm leading-relaxed resize-none outline-none"
                    placeholder="Results will appear here..."></textarea>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
