export default function buildStatistics(mostSold) {
    const canvas = document.createElement('canvas');
    const colors = ['rgb(135, 156, 232)', 'rgb(185, 151, 198)',
     'rgb(130, 77, 153)', 'rgb(78, 121, 196)', 'rgb(87, 162, 172)',
     'rgb(126, 184, 117)', 'rgb(208, 180, 64)', 'rgb(230, 127, 51)',
     'rgb(206, 34, 32)', 'rgb(82, 25, 19)'].reverse();
    const pieChart = new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        showTooltips: false,
        data: {
            datasets: [{
                data: mostSold.map(product => product.sold),
                backgroundColor: colors,
            }],

            labels: mostSold.map(product => product.name)
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true
            },
            plugins: {
                labels:{
                    render: 'percentage',
                    fontColor: '#fff'
                }
            }
        }
    });


    return canvas;
}