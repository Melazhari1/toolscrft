<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  tools: {
    type: Array,
    required: true
  },
  currentSlug: {
    type: String,
    required: true
  }
});

const scrollContainer = ref(null);
const canScrollLeft = ref(false);
const canScrollRight = ref(true);

const checkScroll = () => {
  if (!scrollContainer.value) return;
  canScrollLeft.value = scrollContainer.value.scrollLeft > 0;
  canScrollRight.value = 
    scrollContainer.value.scrollLeft < 
    scrollContainer.value.scrollWidth - scrollContainer.value.clientWidth - 10;
};

const scroll = (direction) => {
  if (!scrollContainer.value) return;
  const scrollAmount = 300;
  scrollContainer.value.scrollBy({
    left: direction === 'left' ? -scrollAmount : scrollAmount,
    behavior: 'smooth'
  });
  setTimeout(checkScroll, 300);
};

const onMount = () => {
  checkScroll();
  if (scrollContainer.value) {
    scrollContainer.value.addEventListener('scroll', checkScroll);
  }
};

onMount();
</script>

<template>
  <div class="mt-16">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-slate-900">Other Tools</h2>
      <p class="text-slate-500 mt-1">Explore more utilities</p>
    </div>

    <div class="relative">
      <!-- Left scroll button -->
      <button
        v-if="canScrollLeft"
        @click="scroll('left')"
        class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:shadow-xl transition-shadow"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-slate-900">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
      </button>

      <!-- Scrollable container -->
      <div
        ref="scrollContainer"
        class="flex gap-4 overflow-x-auto scrollbar-hide px-12"
        @load="checkScroll"
      >
        <Link
          v-for="tool in tools"
          v-show="tool.slug !== currentSlug"
          :key="tool.slug"
          :href="route(tool.slug)"
          class="flex-shrink-0 w-64 bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg transition-shadow"
        >
          <div class="flex flex-col h-full">
            <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ tool.name }}</h3>
            <p class="text-sm text-slate-600 flex-1">{{ tool.desc }}</p>
            <div class="mt-4 text-indigo-600 font-semibold text-sm flex items-center gap-1">
              Open Tool
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
              </svg>
            </div>
          </div>
        </Link>
      </div>

      <!-- Right scroll button -->
      <button
        v-if="canScrollRight"
        @click="scroll('right')"
        class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:shadow-xl transition-shadow"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-slate-900">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5L15.75 12l-7.5 7.5" />
        </svg>
      </button>
    </div>
  </div>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>