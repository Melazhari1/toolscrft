<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import OtherToolsSlider from '@/Components/OtherToolsSlider.vue';

defineProps({
  tools: Array,
  currentTool: String
});

const form = ref({
    url: '',
    source: '',
    medium: '',
    campaign: '',
    term: '',
    content: ''
});

const generatedUrl = computed(() => {
    if (!form.value.url) return '';
    
    try {
        let url = new URL(form.value.url);
        if (form.value.source) url.searchParams.set('utm_source', form.value.source);
        if (form.value.medium) url.searchParams.set('utm_medium', form.value.medium);
        if (form.value.campaign) url.searchParams.set('utm_campaign', form.value.campaign);
        if (form.value.term) url.searchParams.set('utm_term', form.value.term);
        if (form.value.content) url.searchParams.set('utm_content', form.value.content);
        
        return url.toString();
    } catch (e) {
        return 'Invalid Website URL';
    }
});

const copyToClipboard = () => {
    if (generatedUrl.value && generatedUrl.value !== 'Invalid Website URL') {
        navigator.clipboard.writeText(generatedUrl.value);
    }
};

const clearForm = () => {
    form.value = {
        url: '',
        source: '',
        medium: '',
        campaign: '',
        term: '',
        content: ''
    };
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
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Campaign URL Builder</h1>
        <p class="text-slate-500 mt-1">Generate URLs with UTM parameters for tracking in Google Analytics.</p>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8">
        <div class="flex items-center justify-between mb-8">
            <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Campaign Parameters</span>
            <button @click="clearForm" class="text-xs font-semibold text-rose-600 hover:text-rose-700">Clear All</button>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Website URL <span class="text-rose-500">*</span></label>
                <input v-model="form.url" type="url" placeholder="https://www.example.com" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                <p class="text-[11px] text-slate-400 mt-1.5 ml-1">The full website URL (e.g. https://www.example.com)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Campaign Source <span class="text-rose-500">*</span></label>
                    <input v-model="form.source" type="text" placeholder="google, newsletter" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                    <p class="text-[11px] text-slate-400 mt-1.5 ml-1">The referrer: (e.g. google, newsletter)</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Campaign Medium <span class="text-rose-500">*</span></label>
                    <input v-model="form.medium" type="text" placeholder="cpc, email" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                    <p class="text-[11px] text-slate-400 mt-1.5 ml-1">Marketing medium: (e.g. cpc, banner, email)</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Campaign Name <span class="text-rose-500">*</span></label>
                <input v-model="form.campaign" type="text" placeholder="spring_sale" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                <p class="text-[11px] text-slate-400 mt-1.5 ml-1">Product, promo code, or slogan (e.g. spring_sale)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Campaign Term</label>
                    <input v-model="form.term" type="text" placeholder="running+shoes" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                    <p class="text-[11px] text-slate-400 mt-1.5 ml-1">Identify the paid keywords</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Campaign Content</label>
                    <input v-model="form.content" type="text" placeholder="logolink" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                    <p class="text-[11px] text-slate-400 mt-1.5 ml-1">Use to differentiate ads</p>
                </div>
            </div>
        </div>
      </div>

      <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
          <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Generated URL</span>
          <button v-if="generatedUrl && generatedUrl !== 'Invalid Website URL'" @click="copyToClipboard" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2m-6 12h8a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" /></svg>
            Copy URL
          </button>
        </div>
        <div class="flex-1 bg-slate-950 rounded-[2.5rem] p-8 border border-slate-800 shadow-inner overflow-hidden flex flex-col">
          <div v-if="generatedUrl" class="flex-1 text-emerald-400 font-mono text-sm leading-relaxed break-all whitespace-pre-wrap outline-none">
            {{ generatedUrl }}
          </div>
          <div v-else class="flex-1 text-slate-600 font-mono text-sm italic">
            Generated URL will appear here once you fill in the Website URL...
          </div>
        </div>
        
        <div class="bg-indigo-50 border border-indigo-100 rounded-3xl p-6 mt-4">
            <h3 class="text-indigo-900 font-bold text-sm uppercase tracking-wider mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                Pro Tip
            </h3>
            <p class="text-indigo-700 text-sm leading-relaxed">
                UTM parameters help you see where your traffic is coming from in your analytics reports. Always use consistent naming conventions for your sources and mediums to keep your data clean.
            </p>
        </div>
      </div>
    </div>

    <OtherToolsSlider :tools="tools" :current-slug="currentTool" />
  </AppLayout>
</template>
