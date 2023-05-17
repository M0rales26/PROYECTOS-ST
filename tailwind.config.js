/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./resources/**/*.vue",
	],
	theme: {
		extend: {
			colors:{
				primary: '#5556a6',
				check: '#055329',
			}
		},
	},
	plugins: [
		require('tailwind-scrollbar'),
	],
}