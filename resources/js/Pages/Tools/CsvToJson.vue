<script setup>
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import OtherToolsSlider from '@/Components/OtherToolsSlider.vue';

defineProps({
  tools: Array,
  currentTool: String
});

const csv = ref('');
const json = ref('');
const error = ref('');
const delimiter = ref(',');
const hasHeaders = ref(true);
const skipEmptyLines = ref(true);
const trimWhitespace = ref(true);

const parseCsv = (csvText) => {
    const lines = csvText.split('\n').filter(line => skipEmptyLines.value ? line.trim() : true);
    if (!lines.length) return [];

    const rows = lines.map(line => {
        const result = [];
        let current = '';
        let inQuotes = false;
        let i = 0;

        while (i < line.length) {
            const char = line[i];
            if (char === '"') {
                if (inQuotes && line[i + 1] === '"') {
                    current += '"';
                    i += 2;
                } else {
                    inQuotes = !inQuotes;
                    i++;
                }
            } else if (char === delimiter.value && !inQuotes) {
                result.push(trimWhitespace.value ? current.trim() : current);
                current = '';
                i++;
            } else {
                current += char;
                i++;
            }
        }
        result.push(trimWhitespace.value ? current.trim() : current);
        return result;
    });

    if (hasHeaders.value && rows.length > 0) {
        const headers = rows.shift();
        return rows.map(row => {
            const obj = {};
            headers.forEach((header, index) => {
                obj[header] = row[index] || '';
            });
            return obj;
        });
    }

    return rows;
};

const convert = () => {
    error.value = '';
    try {
        if (!csv.value.trim()) {
            json.value = '';
            return;
        }

        const data = parseCsv(csv.value);
        json.value = JSON.stringify(data, null, 2);
    } catch (e) {
        error.value = 'Invalid CSV format.';
        json.value = '';
    }
};

watch([csv, delimiter, hasHeaders, skipEmptyLines, trimWhitespace], convert, { immediate: true });

const download = () => {
    if (!json.value) return;
    const blob = new Blob([json.value], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'export.json';
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
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">CSV to JSON Converter</h1>
        <p class="text-slate-500 mt-1">Convert CSV data effortlessly for APIs and data processing.</p>
      </div>

      <button @click="download" :disabled="!json"
              class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-emerald-200 transition-all disabled:opacity-30 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
        Download JSON
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
            <input id="has-headers" type="checkbox" v-model="hasHeaders" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="has-headers" class="text-sm text-slate-700">First row is headers</label>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Skip empty lines</label>
          <div class="flex items-center gap-3">
            <input id="skip-empty" type="checkbox" v-model="skipEmptyLines" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="skip-empty" class="text-sm text-slate-700">Skip empty lines</label>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Trim whitespace</label>
          <div class="flex items-center gap-3">
            <input id="trim-whitespace" type="checkbox" v-model="trimWhitespace" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="trim-whitespace" class="text-sm text-slate-700">Trim field whitespace</label>
          </div>
        </div>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
          <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">CSV Input</span>
          <span v-if="error" class="text-xs font-bold text-red-500 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
            {{ error }}
          </span>
        </div>
        <div class="flex-1 bg-slate-950 rounded-[2.5rem] p-8 border border-slate-800 shadow-inner">
          <textarea v-model="csv" @input="convert" class="w-full h-[500px] bg-transparent border-none focus:ring-0 text-emerald-400 font-mono text-sm leading-relaxed resize-none outline-none"
                    placeholder='id,name,role
1,ToolsCraft,Full-Stack Expert'></textarea>
        </div>
      </div>

      <div class="flex flex-col gap-4">
        <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">JSON Output</span>
        <div class="flex-1 bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-inner">
          <textarea readonly :value="json" class="w-full h-[500px] bg-transparent border-none focus:ring-0 text-slate-700 font-mono text-sm leading-relaxed resize-none outline-none"
                    placeholder="Results will appear here..."></textarea>
        </div>
      </div>
    </div>

    <OtherToolsSlider :tools="tools" :current-slug="currentTool" />
  </AppLayout>
</template>