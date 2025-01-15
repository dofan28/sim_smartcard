module.exports = {
  content: ["./public/**/*.{html,php}", "./src/views/**/*.{html,php}"],
  theme: {
    extend: {
      colors: {
        primary: "#0A5EB0",
        secondary: "#0A97B0",
        tertiary: "#FFCFEF",
        neutral: "#2A3335",
      },
      fontFamily: {
        poppins: ['"Poppins"', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
