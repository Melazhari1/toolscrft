<script setup>
import { Link, Head, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  seo: Object
});

const page = usePage();
const isMobileMenuOpen = ref(false);

const seoData = computed(() => props.seo || page.props.seo || { title: 'ToolsCraft', description: 'SEO Tools Suite', schema: {}, geo: {}, aeo: null });

const navLinks = [
  { name: 'All Tools', href: '/', route: 'home' },
  { name: 'How it Works', href: '/how-it-works', route: 'how-it-works' },
  { name: 'Privacy Policy', href: '/privacy-policy', route: 'privacy-policy' },
];

const isActive = (href) => page.url === href;

</script>

<template>
  <div class="min-h-screen bg-white text-slate-900 relative selection:bg-indigo-600 selection:text-white overflow-x-hidden">
    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
      <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-indigo-500/10 rounded-full blur-[120px] animate-pulse"></div>
      <div class="absolute bottom-[10%] right-[-10%] w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[100px] animation-delay-2000"></div>
    </div>

    <Head>
      <title>{{ seoData.title }}</title>
      <meta name="description" :content="seoData.description" />
      <meta v-if="seoData.geo?.region" name="geo.region" :content="seoData.geo.region" />
      <meta v-if="seoData.geo?.placename" name="geo.placename" :content="seoData.geo.placename" />
      <meta v-if="seoData.geo?.position" name="geo.position" :content="seoData.geo.position" />
      <meta v-if="seoData.geo?.icbm" name="ICBM" :content="seoData.geo.icbm" />
      <meta v-if="seoData.aeo" name="aeo" :content="seoData.aeo" />
      <component :is="'script'" type="application/ld+json">
        {{ JSON.stringify(seoData.schema) }}
      </component>
    </Head>

    <header class="sticky top-4 z-50 px-6">
      <div class="max-w-6xl mx-auto bg-white/70 backdrop-blur-2xl border border-white shadow-2xl shadow-indigo-500/10 rounded-3xl px-6 py-4 flex items-center justify-between">
        <Link href="/" class="flex items-center gap-3 group transition-all">
          <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-200 group-hover:rotate-12 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
            </svg>
          </div>
          <div class="flex flex-col leading-tight">
            <span class="text-xl font-black bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-600 tracking-tighter uppercase whitespace-nowrap">ToolsCraft</span>
            <span class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Pro Tools</span>
          </div>
        </Link>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex items-center gap-1">
          <Link v-for="link in navLinks" :key="link.href" :href="link.href" 
                :class="[
                  'px-5 py-2.5 text-xs font-black uppercase tracking-widest transition-all rounded-xl',
                  isActive(link.href) ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-500 hover:text-indigo-600 hover:bg-indigo-50'
                ]">
            {{ link.name }}
          </Link>
        </nav>

        <!-- Mobile Menu Toggle -->
        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden p-2 text-slate-900 leading-none">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
            <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Mobile Nav Overlay -->
      <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 translate-y-[-10px]" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-[-10px]">
        <div v-if="isMobileMenuOpen" class="md:hidden mt-4 bg-white/90 backdrop-blur-xl border border-white shadow-2xl rounded-3xl p-4 space-y-2 relative z-[60]">
          <Link v-for="link in navLinks" :key="link.href" :href="link.href" @click="isMobileMenuOpen = false"
                :class="[
                  'block px-6 py-4 text-base font-black tracking-widest uppercase rounded-2xl',
                  isActive(link.href) ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-600 active:bg-indigo-50'
                ]">
            {{ link.name }}
          </Link>
        </div>
      </transition>
    </header>
    
    <main class="relative z-10 max-w-6xl mx-auto px-6 py-12 md:py-20">
      <slot />
    </main>

    <footer class="relative z-10 border-t border-slate-100 mt-20 py-20 bg-slate-50/50 backdrop-blur-sm">
      <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-4 gap-12 text-sm">
        <div class="md:col-span-2">
           <Link href="/" class="text-xl font-black bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-600 tracking-tighter mb-4 block uppercase whitespace-nowrap">ToolsCraft</Link>
           <p class="text-slate-500 max-w-sm leading-relaxed font-medium">The ultimate local-first utility tool suite. Privacy focused, fast, and free forever. Built for developers and marketers.</p>
        </div>
        <div>
          <h4 class="font-black text-slate-900 mb-6 uppercase tracking-widest text-xs">Platform</h4>
          <ul class="space-y-4 text-slate-500 font-bold">
            <li><Link href="/how-it-works" class="hover:text-indigo-600 transition-colors">How it works</Link></li>
            <li><Link href="/privacy-policy" class="hover:text-indigo-600 transition-colors">Privacy Policy</Link></li>
          </ul>
        </div>
        <div class="text-right">
          <p class="text-slate-400 font-black tracking-tighter">© 2026 ToolsCraft</p>
        </div>
      </div>
    </footer>
  </div>
</template>
