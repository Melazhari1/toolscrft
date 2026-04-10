<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const domain = ref('');
const expiry = ref(null);
const loading = ref(false);

const check = async () => {
    loading.value = true;
    try {
        const { data } = await axios.post(route('domain-expiry.check'), { domain: domain.value });
        expiry.value = data.expiry;
    } catch {
        expiry.value = 'Lookup failed';
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
      <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Domain Expiry Checker</h1>
      <p class="text-slate-500 mt-1">instantly check the expiration date of any domain name.</p>
    </div>

    <div class="max-w-2xl mx-auto mt-12">
      <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-indigo-500/5 transition-all">
        <form @submit.prevent="check" class="flex flex-col sm:flex-row gap-4 mb-10">
          <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
            </div>
            <input v-model="domain" placeholder="example.com" required 
                   class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-slate-700" />
          </div>
          <button type="submit" :disabled="loading" 
                  class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-700 disabled:opacity-50 shadow-lg shadow-indigo-200 transition-all flex items-center justify-center gap-2 whitespace-nowrap">
            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            {{ loading ? 'Searching...' : 'Check Expiry' }}
          </button>
        </form>
        
        <div v-if="expiry" class="p-8 bg-indigo-50 rounded-3xl border border-indigo-100 flex flex-col items-center text-center animate-in fade-in slide-in-from-bottom-4 duration-500">
          <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
          </div>
          <p class="text-indigo-600 font-bold text-xs uppercase tracking-widest mb-1">Expiration Date</p>
          <p class="text-4xl font-black text-slate-900 tracking-tight">{{ expiry }}</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
