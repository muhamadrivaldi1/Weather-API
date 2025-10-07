<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aplikasi Cuaca</title>
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      background: linear-gradient(160deg, #4facfe 0%, #00f2fe 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .glass {
      background: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.4);
    }
    .fade-in {
      animation: fadeIn 1s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    input::placeholder {
      color: rgba(0, 0, 0, 0.6);
    }
  </style>
</head>
<body>

<div id="app" class="w-[340px] p-6 rounded-3xl glass text-black shadow-2xl fade-in">
  <div class="text-center mb-6">
    <div class="text-6xl font-bold">@{{ weather ? parseInt(weather.suhu) : '--' }}°</div>
    <div class="text-xl capitalize font-semibold">@{{ weather ? weather.cuaca : '---' }}</div>
    <div class="text-sm mt-1">@{{ weather ? weather.kota : '-' }}</div>
    <div class="text-xs opacity-80">Terasa seperti: @{{ weather ? parseFloat(weather.suhu).toFixed(1) + ' °C' : '--' }}</div>
  </div>

  <div class="flex justify-center mb-5">
    <img :src="weatherIcon" class="w-24 h-24 drop-shadow-lg transition-transform duration-500 hover:scale-110" />
  </div>

  <div class="grid grid-cols-2 gap-4 mb-5">
    <div class="p-3 rounded-xl bg-white/50 text-center">
      🌡️ 
      <div class="text-lg font-bold">
        @{{ weather ? parseFloat(weather.suhu).toFixed(1) + ' °C' : '--' }}
      </div>
      <div class="text-xs opacity-80">Suhu</div>
    </div>
    <div class="p-3 rounded-xl bg-white/50 text-center">
      💧 
      <div class="text-lg font-bold">
        @{{ weather ? parseInt(weather.kelembapan) + ' %' : '--' }}
      </div>
      <div class="text-xs opacity-80">Kelembapan</div>
    </div>
  </div>

  <div v-if="recommendation" class="p-3 rounded-xl bg-yellow-300/40 text-center text-sm mb-4">
    ☁️ @{{ recommendation }}
  </div>

  <div class="flex flex-col space-y-3">
    <input 
      v-model="city" 
      @keyup.enter="getWeather" 
      type="text" 
      placeholder="🌆 Masukkan nama kota (misal: Jakarta)" 
      class="w-full px-4 py-2 rounded-xl bg-white/60 text-black text-center placeholder-black/60 focus:outline-none focus:ring-2 focus:ring-black/40"
    >
    <button 
      @click="getWeather" 
      class="py-2 rounded-xl bg-black/70 hover:bg-black/90 text-white font-semibold transition-all duration-300">
      🔎 Cek Cuaca
    </button>
  </div>
</div>

<script>
const { createApp } = Vue;

createApp({
  data() {
    return {
      city: '',
      weather: null,
      recommendation: ''
    };
  },
  computed: {
    weatherIcon() {
      if (!this.weather) return 'https://cdn-icons-png.flaticon.com/512/1163/1163661.png';
      const kondisi = this.weather.cuaca.toLowerCase();
      if (kondisi.includes('hujan')) return 'https://cdn-icons-png.flaticon.com/512/414/414974.png';
      if (kondisi.includes('cerah')) return 'https://cdn-icons-png.flaticon.com/512/869/869869.png';
      if (kondisi.includes('awan')) return 'https://cdn-icons-png.flaticon.com/512/414/414927.png';
      return 'https://cdn-icons-png.flaticon.com/512/1163/1163661.png';
    }
  },
  methods: {
    async getWeather() {
      if (!this.city) {
        alert('Masukkan nama kota!');
        return;
      }
      try {
        const res = await fetch(`/api/weather?city=${this.city}`);
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal mengambil data cuaca');
        this.weather = data;
        this.setRecommendation();
      } catch (e) {
        alert(e.message);
      }
    },
    setRecommendation() {
      const kondisi = this.weather.cuaca.toLowerCase();
      if (kondisi.includes('hujan')) this.recommendation = 'Bawa payung, hujan akan turun 🌧️';
      else if (kondisi.includes('cerah')) this.recommendation = 'Cuaca cerah, cocok untuk aktivitas luar ☀️';
      else if (kondisi.includes('awan')) this.recommendation = 'Berawan, cuaca cenderung sejuk ☁️';
      else this.recommendation = 'Perhatikan kondisi cuaca sebelum keluar rumah.';
    }
  }
}).mount('#app');
</script>

</body>
</html>
