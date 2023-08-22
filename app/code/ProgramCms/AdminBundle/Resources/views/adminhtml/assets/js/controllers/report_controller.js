/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import { Controller } from '@hotwired/stimulus';
import Chart from 'chart.js/auto';

/**
 * Sidebar Controller
 * Manage Backoffice entries and pages
 */
export default class extends Controller {

    connect() {
        $(function() {
            const ctx = document.getElementById('myChart');
            const ctxLine = document.getElementById('myChartLine');
            //const labels = Utils.months({count: 7});

            new Chart(ctxLine, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: '% of Progress',
                        data: [12, 19, 0, 0, 0, 0],
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

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [65, 59, 80, 81, 56, 55, 40],
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });
        });
    }
}