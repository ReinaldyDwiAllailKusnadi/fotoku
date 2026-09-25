import type { Config } from "tailwindcss";

/**
 * Konfigurasi Tailwind untuk Fotoku.
 *
 * KENAPA TEMA GELAP DI SINI, SEDANGKAN PROYEK LAIN TERANG:
 *   Yang dijual situs portofolio fotografer adalah FOTONYA. Latar gelap
 *   membuat foto terlihat lebih kontras dan warnanya lebih kaya — semua
 *   aplikasi galeri profesional (Lightroom, 500px, Unsplash malam) bekerja
 *   begitu. Latar terang justru membuat foto tampak "pucat" di sekelilingnya.
 *
 * KENAPA warna utamanya AMBER, BUKAN BIRU:
 *   Amber (+warna cahaya matahari/lampu studio) cocok dengan tema fotografi
 *   dan bertahan terbaca di atas latar gelap. Biru pada latar gelap adalah
 *   palet default ribuan template — dan ini bukan template.
 */
const config: Config = {
  content: ["./resources/views/**/*.blade.php"],
  theme: {
    extend: {
      colors: {
        malam: {
          950: "#0c0a09",
          900: "#171412",
          800: "#221e1b",
          700: "#332d28",
        },
        emas: {
          500: "#f59e0b",
          600: "#d97706",
          400: "#fbbf24",
        },
      },
      fontFamily: {
        sans: ["Figtree", "ui-sans-serif", "system-ui", "sans-serif"],
      },
    },
  },
  plugins: [],
};
export default config;
