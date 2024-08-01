/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
    "./src/**/*.{html, js, ts, vue}",
    "./src/**/*"
  ],
  theme: {
    extend: {
      colors: {
        "white": "#FFF",
        "white--2": "#F6F7F9",
        "gray": "#F5F5F5",
        "primary--100": "#D6E4FD",
        "primary--200": "#AEC8FC",
        "primary--300": "#85A8F8",
        "primary--400": "#658DF1",
        "primary--500": "#3563E9",
        "primary--600": "#264BC8",
        "primary--700": "#1A37A7",
        "primary--800": "#102587",
        "primary--900": "#0A196F",

        "information--100": "#DCF3FF",
        "information--200": "#BAE5FF",
        "information--300": "#98D3FF",
        "information--400": "#7EC2FF",
        "information--500": "#54A6FF",
        "information--600": "#3D81DB",
        "information--700": "#2A60B7",
        "information--800": "#1A4393",
        "information--900": "#102E7A",

        "secondary--100": "#E0E9F4",
        "secondary--200": "#C3D4E9",
        "secondary--300": "#90A3BF",
        "secondary--400": "#596780",
        "secondary--500": "#1A202C",
        "secondary--600": "#131825",
        "secondary--700": "#0D121F",
        "secondary--800": "#080C19",
        "secondary--900": "#040815",
      },
    },
  },
  plugins: [],
}

