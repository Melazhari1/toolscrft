<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const domain = ref('');
const result = ref(null);
const loading = ref(false);

const check = async () => {
    loading.value = true;
    try {
        const { data } = await axios.post(route('domain-whois.check'), { domain: domain.value });
        result.value = data;
    } catch {
        result.value = { error: 'Lookup failed' };
    } finally {
        loading.value = false;
    }
};
</script>

<template>
  <AppLayout>
    <div class="mb-8">
      <Link href="/" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 mb-2 group">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
        Back to Tools
      </Link>
      <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Whois Lookup</h1>
      <p class="text-slate-500 mt-1">Get detailed registration information for any domain name.</p>
    </div>

    <div class="max-w-4xl mx-auto">
      <div class="bg-white p-1 rounded-[2.5rem] border border-slate-200 shadow-sm mb-8">
        <form @submit.prevent="check" class="flex p-2 gap-2">
          <input v-model="domain" placeholder="e.g., example.org" required 
                 class="flex-1 px-6 py-4 bg-transparent rounded-2xl focus:ring-0 border-none outline-none font-medium text-slate-700 text-lg" />
          <button type="submit" :disabled="loading" 
                  class="bg-slate-900 text-white px-10 py-4 rounded-[1.25rem] font-bold hover:bg-black disabled:opacity-50 transition-all flex items-center justify-center gap-2">
            {{ loading ? 'Fetching...' : 'Lookup' }}
          </button>
        </form>
      </div>
      
      <div v-if="result" class="bg-slate-950 rounded-[2.5rem] overflow-hidden shadow-2xl animate-in zoom-in-95 duration-300">
        <div class="px-8 py-5 bg-slate-900/50 border-b border-white/5 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="flex gap-1.5">
              <div class="w-3 h-3 rounded-full bg-red-400"></div>
              <div class="w-3 h-3 rounded-full bg-amber-400"></div>
              <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
            </div>
            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-4">Registry Data</span>
          </div>
          <button @click="() => { navigator.clipboard.writeText(JSON.stringify(result, null, 2)) }" class="text-xs font-bold text-slate-400 hover:text-white transition-colors">Copy JSON</button>
        </div>
        <div class="p-10">
          <pre class="text-emerald-400 font-mono text-sm overflow-x-auto whitespace-pre-wrap leading-relaxed">{{ JSON.stringify(result, null, 2) }}</pre>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
