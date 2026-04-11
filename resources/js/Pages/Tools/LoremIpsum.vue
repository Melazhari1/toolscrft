<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const count = ref(3);
const outputType = ref('paragraphs');
const sentenceLength = ref('medium');
const includeClassicStart = ref(true);

const loremChunks = {
  short: [
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    'Etiam eget ligula eu lectus lobortis condimentum.',
    'Aliquam nonummy auctor massa.',
    'Pellentesque habitant morbi tristique senectus et netus.'
  ],
  medium: [
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
    'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
  ],
  long: [
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
    'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Curabitur pretium tincidunt lacus.'
  ]
};

const standardStart = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

const generateParagraph = () => {
  const sentences = loremChunks[sentenceLength.value];
  const paragraph = sentences.join(' ');
  return includeClassicStart.value ? `${standardStart} ${paragraph}` : paragraph;
};

const output = computed(() => {
  const amount = Math.max(0, count.value || 0);
  const sentences = loremChunks[sentenceLength.value];
  const sentenceList = includeClassicStart.value ? [standardStart, ...sentences] : sentences;

  if (outputType.value === 'words') {
    const words = sentenceList.join(' ').replace(/[.]/g, '');
    const wordList = words.split(/\s+/).filter(Boolean);
    return Array.from({ length: amount }, (_, index) => wordList[index % wordList.length]).join(' ');
  }

  if (outputType.value === 'sentences') {
    return Array.from({ length: amount }, (_, index) => sentenceList[index % sentenceList.length]).join(' ');
  }

  return Array.from({ length: amount }, generateParagraph).join('\n\n');
});

const copy = () => navigator.clipboard.writeText(output.value);
</script>

<template>
  <AppLayout>
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
      <div>
        <Link href="/" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 mb-2 group">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
          Back to Tools
        </Link>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Lorem Ipsum Generator</h1>
        <p class="text-slate-500 mt-1">Generate placeholder text for your design projects.</p>
      </div>
      
      <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm grid gap-4 md:grid-cols-2 xl:grid-cols-[minmax(0,1fr)_auto] items-end">
        <div class="grid gap-4 sm:grid-cols-2">
          <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Count</label>
            <input type="number" v-model="count" min="1" max="200" class="w-full px-3 py-2 text-lg font-bold bg-slate-50 border border-slate-200 rounded-2xl focus:ring-0 focus:border-indigo-500 text-slate-900" />
          </div>
          <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Output Type</label>
            <select v-model="outputType" class="w-full rounded-2xl border border-slate-200 px-3 py-2 text-slate-900 focus:ring-indigo-500 focus:border-indigo-500">
              <option value="paragraphs">Paragraphs</option>
              <option value="sentences">Sentences</option>
              <option value="words">Words</option>
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Sentence Length</label>
            <select v-model="sentenceLength" class="w-full rounded-2xl border border-slate-200 px-3 py-2 text-slate-900 focus:ring-indigo-500 focus:border-indigo-500">
              <option value="short">Short</option>
              <option value="medium">Medium</option>
              <option value="long">Long</option>
            </select>
          </div>
          <div class="flex items-center gap-3">
            <input id="classic-start" type="checkbox" v-model="includeClassicStart" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="classic-start" class="text-sm font-medium text-slate-700">Classic Lorem Start</label>
          </div>
        </div>

        <div class="md:col-span-2 xl:col-span-1 flex items-center justify-end">
          <button @click="copy" class="w-full bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold hover:bg-black transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg>
            Copy All
          </button>
        </div>
      </div>
    </div>
    
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-10 min-h-[500px]">
      <div class="prose prose-slate max-w-none">
        <p v-for="(p, i) in output.split('\n\n')" :key="i" class="text-slate-600 text-lg leading-relaxed mb-6 last:mb-0">{{ p }}</p>
      </div>
    </div>
  </AppLayout>
</template>
