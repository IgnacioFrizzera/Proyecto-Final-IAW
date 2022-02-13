const receiptTpes = ['Factura', 'Factura C.C', 'Efectivo', 'Tarjeta Crédito', 'Tarjeta Débito'];
const receiptColors = ['rgb(60, 179, 113)', 'rgb(255, 0, 0)', 'rgb(0, 0, 255)', 'rgb(255, 165, 0)', 'rgb(0, 0, 70)'];

const receiptTypeTranslation = {
    'FC': 'Factura',
    'FCC': 'Factura Cuenta Corriente',
    'EF': 'Efectivo',
    'TC': 'Tarjeta de crédito',
    'TD': 'Tarjeta de débito'
};



function makeMovementsChart(movements) {
    const movementsBarChart = document.getElementById('movementsBarChart');
    const movementsPieChart = document.getElementById('movementsPieChart');

    const totalMovements = movements.length;
    var facturaAmount = 0;
    var facturaCCAmount = 0;
    var efectivoAmount = 0;
    var tarjetaCAmount = 0;
    var tarjetaDAmount = 0;

    for(let movement of movements) {
        if (movement.receipt_type == 'FC') {
            facturaAmount += 1;
        }
        if (movement.receipt_type == 'FCC') {
            facturaCCAmount += 1;
        }
        if (movement.receipt_type == 'EF') {
            efectivoAmount += 1;
        }
        if (movement.receipt_type == 'TC') {
            tarjetaCAmount += 1;
        }
        if (movement.receipt_type == 'TD') {
            tarjetaDAmount += 1;
        }
    }

    const movementsAmountData = [facturaAmount, facturaCCAmount, efectivoAmount, tarjetaCAmount, tarjetaDAmount]

    const barChartData = [
        {
            title: 'Hola :)',
            x: receiptTpes,
            y: movementsAmountData,
            marker:{
                color: receiptColors
                // color: ['rgba(204,204,204,1)', 'rgba(222,45,38,0.8)', 'rgba(204,204,204,1)', 'rgba(204,204,204,1)', 'rgba(204,204,204,1)']
            },
            type: 'bar'
        }
    ];

    const barChartLayout = {
        title: 'Cantidad de movimientos por tipo de comprobante',
    };

    Plotly.newPlot(movementsBarChart, barChartData, barChartLayout);

    const movementsPercentagesData = [];
    for (movementAmount of movementsAmountData) {
        movementsPercentagesData.push(movementAmount / totalMovements);
    }

    const pieChartData = [
        {
            values: movementsPercentagesData,
            labels: receiptTpes,
            type: 'pie',
            textinfo: "label+percent",
            textposition: "inside",
        }
    ];

    const pieChartLayout = {
        title: 'Porcentaje de movimientos por tipo de comprobante',
        heigh: 400,
        width: 500
    };

    Plotly.newPlot(movementsPieChart, pieChartData, pieChartLayout);
}


makeMovementsChart(ChartNamespace.movements);