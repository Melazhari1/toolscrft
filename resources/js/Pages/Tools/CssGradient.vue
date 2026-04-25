<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import OtherToolsSlider from '@/Components/OtherToolsSlider.vue';

defineProps({
  tools: Array,
  currentTool: String
});

const color1 = ref('#6366f1');
const color2 = ref('#a855f7');
const angle = ref(135);
const type = ref('linear'); // 'linear' or 'radial'

const gradientCss = computed(() => {
    if (type.value === 'linear') {
        return `linear-gradient(${angle.value}deg, ${color1.value}, ${color2.value})`;
    } else {
        return `radial-gradient(circle, ${color1.value}, ${color2.value})`;
    }
});

const fullCss = computed(() => {
    return `background: ${color1.value};\nbackground: ${gradientCss.value};`;
});

const copyToClipboard = () => {
    navigator.clipboard.writeText(fullCss.value);
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
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">CSS Gradient Generator</h1>
        <p class="text-slate-500 mt-1">Design beautiful gradients visually and get the CSS code.</p>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-12">
      <!-- Controls -->
      <div class="space-y-8">
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-10 space-y-8">
          
          <div class="space-y-4">
            <label class="text-sm font-bold text-slate-900 uppercase tracking-widest block">Gradient Type</label>
            <div class="flex gap-2 bg-slate-100 p-1.5 rounded-2xl w-fit">
              <button @click="type = 'linear'" :class="type === 'linear' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500'" class="px-6 py-2 rounded-xl font-bold text-sm transition-all">Linear</button>
              <button @click="type = 'radial'" :class="type === 'radial' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500'" class="px-6 py-2 rounded-xl font-bold text-sm transition-all">Radial</button>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6">
            <div class="space-y-4">
              <label class="text-sm font-bold text-slate-900 uppercase tracking-widest block">Start Color</label>
              <div class="flex items-center gap-4">
                <input type="color" v-model="color1" class="w-14 h-14 rounded-2xl border-none p-0 bg-transparent cursor-pointer overflow-hidden shadow-md" />
                <input type="text" v-model="color1" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-mono w-full focus:ring-2 focus:ring-indigo-500 outline-none" />
              </div>
            </div>
            <div class="space-y-4">
              <label class="text-sm font-bold text-slate-900 uppercase tracking-widest block">End Color</label>
              <div class="flex items-center gap-4">
                <input type="color" v-model="color2" class="w-14 h-14 rounded-2xl border-none p-0 bg-transparent cursor-pointer overflow-hidden shadow-md" />
                <input type="text" v-model="color2" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-mono w-full focus:ring-2 focus:ring-indigo-500 outline-none" />
              </div>
            </div>
          </div>

          <div v-if="type === 'linear'" class="space-y-4">
            <div class="flex justify-between items-center">
                <label class="text-sm font-bold text-slate-900 uppercase tracking-widest block">Angle: {{ angle }}°</label>
                <button @click="angle = (angle + 45) % 360" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">+45°</button>
            </div>
            <input type="range" v-model="angle" min="0" max="360" class="w-full h-2 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
          </div>

          <div class="pt-6 border-t border-slate-100">
            <div class="flex items-center justify-between mb-4">
              <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Generated CSS</span>
              <button @click="copyToClipboard" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-4 py-2 rounded-full transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2m-6 12h8a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" /></svg>
                Copy Code
              </button>
            </div>
            <div class="bg-slate-950 rounded-2xl p-6 border border-slate-800">
              <pre class="text-emerald-400 font-mono text-sm leading-relaxed overflow-x-auto"><code>{{ fullCss }}</code></pre>
            </div>
          </div>
        </div>
      </div>

      <!-- Preview -->
      <div class="flex flex-col gap-6">
        <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Live Preview</span>
        <div class="flex-1 min-h-[400px] rounded-[3rem] border-8 border-white shadow-2xl overflow-hidden relative group" :style="{ background: gradientCss }">
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/10 backdrop-blur-[2px]">
                <span class="bg-white px-6 py-3 rounded-2xl font-black text-slate-900 shadow-xl uppercase tracking-tighter text-2xl rotate-3">Looking Good!</span>
            </div>
        </div>
      </div>
    </div>

    <OtherToolsSlider :tools="tools" :current-slug="currentTool" />
  </AppLayout>
</template>

<style scoped>
input[type="range"]::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 24px;
  height: 24px;
  background: white;
  border: 4px solid #4f46e5;
  border-radius: 50%;
  cursor: pointer;
  box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}
</style>
