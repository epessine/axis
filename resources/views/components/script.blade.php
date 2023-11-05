@props(['id', 'chart'])

<script>
    {
        chart: undefined,
        init() {
            this.chart = new Chart(this.$refs.canvas, {
                type: @js($chart::TYPE ?? null),
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple',
                        'Orange'
                    ],
                    datasets: [{
                        type: 'bar',
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
</script>
