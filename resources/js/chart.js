import Chart from 'chart.js/auto';

window.Chart = Chart;
mix.js('resources/js/app.js', 'public/js').sass('resources/sass/app.scss', 'public/css').sourceMaps();